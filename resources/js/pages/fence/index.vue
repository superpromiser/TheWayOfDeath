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
              <span v-if="isAdding == false">添加</span>
              <span v-else>加...</span> 
          </v-btn>
          <v-btn
              tile
              dark
              class="mx-2"
              color="#F19861"
              @click="familyModal = true"
          >
              亲情号码
          </v-btn>
          <v-btn
              tile
              dark
              color="#7879FF"
              @click="trackModal = true"
          >
              轨迹回放
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
          <bm-polyline :path="trackPath" stroke-color="red" :stroke-opacity="0.5" :stroke-weight="2"></bm-polyline>
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
    <!-- fence modal -->
    <v-row justify="center">
      <v-dialog
        v-model="fenceModal"
        persistent
        max-width="600px"
      >
        <v-card>
          <v-card-title>
            <span class="headline">添加围栏</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                
                <v-col cols="12">
                  <v-text-field
                    label="围栏名称*"
                    required
                    v-model="fenceData.fenceName"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    label="围栏类型*"
                    v-model="fenceData.fenceType"
                    required
                  ></v-text-field>
                </v-col>
                
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="fenceModal = false"
            >
              关闭
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              :loading="isSaving"
              @click="saveFence"
            >
              保存
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
    <!-- phoneNumber modal -->
    <v-row justify="center">
      <v-dialog
        v-model="familyModal"
        persistent
        max-width="600px"
      >
        <v-card>
          <v-card-title>
            <span class="headline">亲情号码</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                
                <v-col cols="12">
                  <v-text-field
                    label="号码1*"
                    required
                    v-model="familyData.phone1"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    label="号码2*"
                    v-model="familyData.phone2"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    label="号码3*"
                    v-model="familyData.phone3"
                    required
                  ></v-text-field>
                </v-col>
                
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="familyModal = false"
            >
              关闭
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              :loading="isSaving"
              @click="instructionSend"
            >
              保存
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
      <!-- trackModal  -->
      <v-row justify="center">
      <v-dialog
        v-model="trackModal"
        persistent
        max-width="600px"
      >
        <v-card>
          <v-card-title>
            <span class="headline">亲情号码</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="6">
                  <v-datetime-picker 
                      label="开始时间" 
                      v-model="trackData.begin_time"
                      :okText='lang.ok'
                      :clearText='lang.cancel'
                  > </v-datetime-picker>
                </v-col>
                <v-col cols="6">
                  <v-datetime-picker 
                      label="截止时间" 
                      v-model="trackData.end_time"
                      :okText='lang.ok'
                      :clearText='lang.cancel'
                  > </v-datetime-picker>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="trackModal = false"
            >
              关闭
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              :loading="isSaving"
              @click="getDeviceTrack"
            >
              保存
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </v-container>
</template>

<script>
import {getData,getFence,createFence,deleteFence} from '~/api/fence'
import lang from '~/helper/lang.json'
import {mapGetters,} from 'vuex'
import axios from 'axios'
export default {
  data:()=>({
    alarm:'',
    fenceData:{
        fenceName:'',
        fenceType:'',
        location:[],
        imei:'',
    },
    lang,
    familyModal:false,
    familyData:{
      phone1:'',
      phone2:'',
      phone3:'',
    },
    trackModal:false,
    trackData:{
      begin_time:'',
      end_time:''
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
    trackPath:[],
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
    handler ({BMap, map}) {
      console.log(BMap, map)
      this.center.lng = 116.404
      this.center.lat = 39.915
      this.zoom = 15
    },

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
    
    async saveFence(){
      this.fenceData.imei = this.imeiStr
      this.fenceData.location = this.polygonPath
      console.log(this.fenceData)
      this.isSaving = true
      await createFence(this.fenceData).then(res=>{
        console.log(res.data)
        this.isSaving = false
        this.allPolygonPath.push(res.data)
        this.fenceModal = false
      }).catch(err=>{
        console.log(err.response)
        this.isSaving = false
      })
    },
    drawNewpolygon(e){
        if(this.polygonPath.length < 3){
          return
        }
        this.fenceModal = true
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
      await getData({
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
        this.selDevice(res.data.result[0])
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
      await getFence({imei:this.imeiStr}).then(res=>{
        this.allPolygonPath = res.data
      }).catch(err=>{
        console.log(err.response)
      })
    },

    getInstructionList(){
      var md5 = require('md5');
      var moment= require('moment') 
      let paramPut = {}
      this.time = moment().format(("YYYY-MM-DD HH:mm:SS"));
      this.user_pwd_md5 = md5(this.userPass)

      paramPut.method = 'jimi.open.instruction.list'
      paramPut.timestamp = this.time
      paramPut.app_key = this.appKey
      paramPut.sign_method = this.sign_method
      paramPut.v = this.v
      paramPut.format = this.format
      paramPut.access_token = this.accessToken
      paramPut.imei = this.imeiStr
      let ordered = {}
      Object.keys(paramPut).sort().forEach(function (key){
          ordered[key] = paramPut[key]
      })
      let str = Object.keys(ordered).map(function(key){
          return "" + key + ordered[key]
      }).join("")
      let md5Secret = md5 (this.appSecret + str + this.appSecret)
      let upper = md5Secret.toUpperCase()
      getData({
        sign:upper,
        timestamp:this.time,
        v:this.v,
        app_key:this.appKey,
        method:"jimi.open.instruction.list",
        format:this.format,
        sign_method:this.sign_method,
        access_token:this.accessToken,
        imei:this.imeiStr,
      }).then(res=>{
        console.log(res.data)
      }).catch(err=>{
        console.log(err.response)
      })
    },

    instructionSend(){
      var md5 = require('md5');
      var moment= require('moment') 
      let paramPut = {}
      let inst_param_json = '{"inst_id":"149","inst_template":"FN&&A&&{0}&&{1}&&{2}&&{3}&&{4}&&{5}##","params":["名称1","' + this.familyData.phone1 + '","名称2","'+ this.familyData.phone2 +'","名称3","' + this.familyData.phone3 + '"],"is_cover":false}'
      // let inst_param_json = '{"inst_id":"149","inst_template":"FN&&A&&{0}&&{1}&&{2}&&{3}&&{4}&&{5}##","params":["名称1","15640052113","名称2","15640052116","名称3","15640052117"],"is_cover":false}'
      console.log(inst_param_json)
      this.time = moment().format(("YYYY-MM-DD HH:mm:SS"));
      this.user_pwd_md5 = md5(this.userPass)

      paramPut.method = 'jimi.open.instruction.send'
      paramPut.timestamp = this.time
      paramPut.app_key = this.appKey
      paramPut.sign_method = this.sign_method
      paramPut.v = this.v
      paramPut.format = this.format
      paramPut.access_token = this.accessToken
      paramPut.imei = this.imeiStr
      paramPut.inst_param_json = inst_param_json
      let ordered = {}
      Object.keys(paramPut).sort().forEach(function (key){
          ordered[key] = paramPut[key]
      })
      let str = Object.keys(ordered).map(function(key){
          return "" + key + ordered[key]
      }).join("")
      let md5Secret = md5 (this.appSecret + str + this.appSecret)
      let upper = md5Secret.toUpperCase()

      axios.post('https://cors-anywhere.herokuapp.com/http://open.aichezaixian.com/route/rest',null,{params:{
        sign:upper,
        timestamp:this.time,
        v:this.v,
        app_key:this.appKey,
        method:"jimi.open.instruction.send",
        format:this.format,
        sign_method:this.sign_method,
        access_token:this.accessToken,
        imei:this.imeiStr,
        inst_param_json:inst_param_json
      }}).then(res=>{
        console.log(res.data)
        this.familyModal = false
      }).catch(err=>{
        console.log(err.response)
        this.familyModal = false
      })
    },

    instructionResult(){
      var md5 = require('md5');
      var moment= require('moment') 
      let paramPut = {}
      this.time = moment().format(("YYYY-MM-DD HH:mm:SS"));
      this.user_pwd_md5 = md5(this.userPass)

      paramPut.method = 'jimi.open.instruction.result'
      paramPut.timestamp = this.time
      paramPut.app_key = this.appKey
      paramPut.sign_method = this.sign_method
      paramPut.v = this.v
      paramPut.format = this.format
      paramPut.access_token = this.accessToken
      paramPut.imei = this.imeiStr
      let ordered = {}
      Object.keys(paramPut).sort().forEach(function (key){
          ordered[key] = paramPut[key]
      })
      let str = Object.keys(ordered).map(function(key){
          return "" + key + ordered[key]
      }).join("")
      let md5Secret = md5 (this.appSecret + str + this.appSecret)
      let upper = md5Secret.toUpperCase()
      getData({
        sign:upper,
        timestamp:this.time,
        v:this.v,
        app_key:this.appKey,
        method:"jimi.open.instruction.result",
        format:this.format,
        sign_method:this.sign_method,
        access_token:this.accessToken,
        imei:this.imeiStr,
      }).then(res=>{
        console.log(res.data)
      }).catch(err=>{
        console.log(err.response)
      })
    },
    
    getDeviceTrack(){
      console.log(this.trackData)
      console.log(this.TimeViewSam(this.trackData.begin_time))
      var md5 = require('md5');
      var moment= require('moment') 
      let paramPut = {}
      this.time = moment().format(("YYYY-MM-DD HH:mm:SS"))
      this.user_pwd_md5 = md5(this.userPass)

      paramPut.method = 'jimi.device.track.list'
      paramPut.timestamp = this.time
      paramPut.app_key = this.appKey
      paramPut.sign_method = this.sign_method
      paramPut.v = this.v
      paramPut.format = this.format
      paramPut.access_token = this.accessToken
      paramPut.imei = this.imeiStr
      paramPut.begin_time = this.TimeViewSam(this.trackData.begin_time)
      paramPut.end_time = this.TimeViewSam(this.trackData.end_time)
      paramPut.map_type = 'BAIDU'
      let ordered = {}
      Object.keys(paramPut).sort().forEach(function (key){
          ordered[key] = paramPut[key]
      })
      let str = Object.keys(ordered).map(function(key){
          return "" + key + ordered[key]
      }).join("")
      let md5Secret = md5 (this.appSecret + str + this.appSecret)
      let upper = md5Secret.toUpperCase()
      getData({
        sign:upper,
        timestamp:this.time,
        v:this.v,
        app_key:this.appKey,
        method:"jimi.device.track.list",
        format:this.format,
        sign_method:this.sign_method,
        access_token:this.accessToken,
        imei:this.imeiStr,
        begin_time:this.TimeViewSam(this.trackData.begin_time),
        end_time:this.TimeViewSam(this.trackData.end_time),
        map_type:'BAIDU'
      }).then(res=>{
        console.log(res.data)
        res.data.result.map(data=>{
          let el = {}
          el.lng = data.lng
          el.lat = data.lat
          this.trackPath.push(el)
          this.trackModal = false
        })
        // this.trackPath = res.data
        console.log(this.trackPath)
      }).catch(err=>{
        console.log(err.response)
      })
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