<template>
  <v-container class="pa-0">
    <v-container class="px-10 z-index-2 banner-custom">
      <v-row>
        <v-col cols="6" md="4" class="d-flex align-center position-relative">
          <a @click="$router.go(-1)">
            <v-icon size="70" class=" left-24p">
                mdi-chevron-left
            </v-icon>
          </a>
        </v-col>
        <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
          <h2>地图</h2>
        </v-col>
        <v-col cols="12" md="4" class="d-flex align-center justify-end">
          <!-- <v-btn
            text
            color="primary"
            @click="selContent('template')"
          >
              可用模板 {{tempCnt}}， 草稿 {{draftCnt}}
          </v-btn> -->
          <v-btn
              tile
              dark
              color="#49d29e"
              class="mx-2"
              @click="addFence"
          >
              add
          </v-btn>
          <v-btn
              tile
              dark
              color="#F19861"
              @click="saveFence"
          >
              save
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
    <v-row>
      <v-col cols="3">
        <div v-for="user in userDeviceList" :key="user.imei">
          <v-row class="hover-cursor-point pa-3" :class="{'selDevice':user.active}" @click="selDevice(user)">
            <v-col>
              {{user.imei}}
            </v-col>
          </v-row>
          <v-divider light class="thick-border"></v-divider>
        </div>
      </v-col>
      <v-col cols="9">
        <baidu-map class="map" :center="{lng:centerLng,lat:centerLat}" :zoom="15" :scroll-wheel-zoom="true" @click="addPoint" @rightclick="drawNewpolygon">
          <div v-for="(polygonPathData,i) in allPolygonPath" :key="i">
              <bm-polygon :path="polygonPathData.location" fill-color="red" stroke-color="blue" :stroke-opacity="0.5" :stroke-weight="2" @click="selPolygon(polygonPathData,i)" :editing="true" @lineupdate="updatePolygonPath"/>
          </div>
          <bm-polygon :path="polygonPath" fill-color="red" stroke-color="blue" :stroke-opacity="0.5" :stroke-weight="2"  :editing="true" @lineupdate="updatePolygonPath"/>
          
          <bm-marker :position="{lng: userlng, lat: userlat}" :dragging="true" animation="BMAP_ANIMATION_BOUNCE">
              <!-- <bm-label content="Tiananmen" :labelStyle="{color: 'red', fontSize : '24px'}" :offset="{width: -35, height: 30}"/> -->
          </bm-marker>
          <bm-control>
              
          </bm-control>
          <bm-local-search :keyword="keyword" :auto-viewport="true" :forceLocal="true" :panel="false" :selectFirstResult="true" location="沈阳"></bm-local-search>
          <bm-geolocation anchor="BMAP_ANCHOR_BOTTOM_RIGHT" :showAddressBar="true" :autoLocation="true"></bm-geolocation>
        </baidu-map>
      </v-col>
    </v-row>
      
  </v-container>
</template>

<script>
import {authTokenGet, getData,getFence,createFence,deleteFence} from '~/api/fence'
import {mapGetters,} from 'vuex'
export default {

  data:()=>({
    alarm:'',
    fenceData:{
        fenceName:'',
        fenceType:'水库'
    },
    allPolygonPath:[],
    polygonPath: [],
    isSaving:false,
    isAdding:false,
    isChecking:false,
    isEditing:false,
    isDeleting:false,
    isSelected:false,
    centerLng:123.474976,
    centerLat:41.695735,
    userlng:123.474976,
    userlat:41.695735,
    keyword:'',
    fenceCheck:'',
    selectedIdx:null,
    isNew:true,
    accessToken:'',
    refreshToken:'',
    openApiUrl:'https://cors-anywhere.herokuapp.com/http://open.aichezaixian.com/route/rest',
    time:'',
    format:'json',
    sign_method:'md5',
    user_id:'辽宁国荣科技',
    userPass:'VVuFiyVd6uaGfCj',
    user_pwd_md5:'',
    expires_in:7200,
    v:'1.0',
    appKey:'8FB345B8693CCD0078950C62F0A8C431',
    appSecret:'0aedd5165f824284b57c918595a8cac4',
    imeiStr:'',
    userDeviceList:[],
    fenceModal:false,
    fenceCheckFlag:null,
    realTrackingFlag:false,
    baseUrl:window.Laravel.base_url,
  }),
  
  computed:{
    ...mapGetters({
      authToken:'fence/authToken'
    })
  },

  created(){
    this.accessToken = this.authToken
    if(this.accessToken == undefined){
      this.getAccessTokenFunc()
    }
    console.log("this.accessToken",this.accessToken)
    this.getUserDeveiceList()
  },

  methods:{
    addFence(){
      this.isAdding = true
    },
    addPoint(e){
        if(!this.isAdding){
            return;
        }
        const {lng,lat} = e.Ag;
        this.addPolygonPoint(lng,lat)
    },
    addPolygonPoint (lng,lat) {
        this.polygonPath.push({lng: lng, lat: lat})
    },
    addNewPolygon(){
        this.isAdding = !this.isAdding
        if(this.isAdding == false){
            this.allPolygonPath.push(this.polygonPath)
        }
    },
    saveFence(){
      console.log(this.allPolygonPath)
    },
    drawNewpolygon(e){
        this.fenceModal = true
        this.isAdding = false
    },
    selPolygon(fence,i){
        for(let i=0;i<this.allPolygonPath.length;i++){
            delete this.allPolygonPath[i].editing
        }
        this.$set(fence,'editing',true)
        console.log(fence)
    },
    updatePolygonPath (e) {
        this.polygonPath = e.target.getPath()
    },
    generateSign(methodType){
      var md5 = require('md5');
      var moment= require('moment') 
      let paramPut = {}
      this.time = moment().format(("YYYY-MM-DD HH:mm:SS"));
      this.user_pwd_md5 = md5(this.userPass)
      paramPut.timestamp = this.time
      paramPut.v = this.v
      paramPut.app_key = this.appKey
      paramPut.method = methodType
      paramPut.format = this.format
      paramPut.sign_method = this.sign_method
      paramPut.user_id = this.user_id
      paramPut.user_pwd_md5 = this.user_pwd_md5
      paramPut.expires_in = this.expires_in
      let ordered = {}
      Object.keys(paramPut).sort().forEach(function (key){
          ordered[key] = paramPut[key]
      })
      let str = Object.keys(ordered).map(function(key){
          return "" + key + ordered[key]
      }).join("")
      let md5Secret = md5 (this.appSecret + str + this.appSecret)
      let upper = md5Secret.toUpperCase()
      return upper
    },
    
    async getAccessTokenFunc(){
      let method = 'jimi.oauth.token.get'
      let sign = this.generateSign(method)
      this.isLoading = true
      await authTokenGet({
          sign:sign,
          timestamp:this.time,
          v:this.v,
          app_key:this.appKey,
          method:method,
          format:this.format,
          sign_method:this.sign_method,
          user_id:this.user_id,
          user_pwd_md5:this.user_pwd_md5,
          expires_in:this.expires_in
      }).then(res=>{
          console.log('accessTokenRes',res)
          this.accessToken = res.data.result.accessToken
          this.refreshToken = res.data.result.refreshToken
          this.$store.dispatch('fence/storeAuthToken',this.accessToken)
          // this.$store.commit('setAccessToken',this.accessToken)
          // this.$store.commit('setRefreshToken',this.refreshToken)
          // this.getUserDeviceList()
          this.isLoading = false
      }).catch(err=>{
          console.log('error',err.response)
          this.isLoading = false
      })
    },

    async getUserDeveiceList(){
      if(this.accessToken == undefined){
        this.getAccessTokenFunc()
      }
      var md5 = require('md5');
      var moment= require('moment') 
      let paramPut = {}
      this.time = moment().format(("YYYY-MM-DD HH:mm:SS"));
      this.user_pwd_md5 = md5(this.userPass)

      paramPut.method = 'jimi.user.device.list'
      paramPut.timestamp = this.time
      paramPut.app_key = this.appKey
      paramPut.sign_method = this.sign_method
      paramPut.v = this.v
      paramPut.format = this.format
      paramPut.access_token = this.accessToken
      paramPut.target = this.user_id
      let ordered = {}
      Object.keys(paramPut).sort().forEach(function (key){
          ordered[key] = paramPut[key]
      })
      let str = Object.keys(ordered).map(function(key){
          return "" + key + ordered[key]
      }).join("")
      let md5Secret = md5 (this.appSecret + str + this.appSecret)
      let upper = md5Secret.toUpperCase()
      await getData({
        sign:upper,
        timestamp:this.time,
        v:this.v,
        app_key:this.appKey,
        method:"jimi.user.device.list",
        format:this.format,
        sign_method:this.sign_method,
        access_token:this.accessToken,
        target:this.user_id
      }).then(res=>{
        this.userDeviceList = res.data.result
        console.log('this.userDeviceList',this.userDeviceList)
      }).catch(err=>{
        console.log(err.response)
        this.getAccessTokenFunc()
        this.getUserDeveiceList()

      })

    },

    selDevice(device){
      for(let i=0;i<this.userDeviceList.length;i++){
          delete this.userDeviceList[i].active
      }
      this.$set(device,'active',true)
      this.imeiStr = device.imei
      // this.realTracking()
      this.getFenceData();
      this.getDeviceLocationList()
    },
    realTracking(){
      this.getDeviceLocationList()
      let self = this
      clearInterval(this.fenceCheckFlag)
      this.fenceCheckFlag = setInterval(function(){self.getDeviceLocationList()}, 20000);
    },
    async getDeviceLocationList(){
        if(this.accessToken == undefined){
            this.getAccessTokenFunc();
        }
        var md5 = require('md5');
        var moment= require('moment') 
        let paramPut = {}
        this.time = moment().format(("YYYY-MM-DD HH:mm:SS"));
        this.user_pwd_md5 = md5(this.userPass)

        paramPut.method = 'jimi.device.location.get'
        paramPut.timestamp = this.time
        paramPut.app_key = this.appKey
        paramPut.sign_method = this.sign_method
        paramPut.v = this.v
        paramPut.format = this.format
        paramPut.access_token = this.accessToken
        paramPut.imeis = this.imeiStr
        paramPut.map_type='BAIDU'
        let ordered = {}
        Object.keys(paramPut).sort().forEach(function (key){
            ordered[key] = paramPut[key]
        })
        let str = Object.keys(ordered).map(function(key){
            return "" + key + ordered[key]
        }).join("")
        let md5Secret = md5 (this.appSecret + str + this.appSecret)
        let upper = md5Secret.toUpperCase()
        this.isLoading = true
        await getData({
            sign:upper,
            timestamp:this.time,
            v:this.v,
            app_key:this.appKey,
            method:"jimi.device.location.get",
            format:this.format,
            sign_method:this.sign_method,
            access_token:this.accessToken,
            imeis:this.imeiStr,
            map_type:'BAIDU'
        }).then(res=>{
            console.log('deviceLocationList',res)
            this.deviceLocationList = res.data.result
            this.userlng = res.data.result[0].lng
            this.userlat = res.data.result[0].lat
            this.centerLng = res.data.result[0].lng
            this.centerLat = res.data.result[0].lat
            // this.getDeviceFence()
            // this.fetchHole()
            this.isLoading = false
        }).catch(err=>{
            console.log('error',err)
            this.getAccessTokenFunc()
            this.isLoading = false
        })
    },

    async getFenceData(){
      console.log(this.imeiStr)
    }



  }

}
</script>

<style>
.map {
  width: 100%;
  height: 78vh;
}
.selDevice{
  background-color: #7879FF;
  color:#ffffff;
}
</style>