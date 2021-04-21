<template>
  <v-container>
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
  </v-container>
</template>

<script>
import {authTokenGet, } from '~/api/fence'
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
    userPass:'',
    user_pwd_md5:'VVuFiyVd6uaGfCj',
    expires_in:7200,
    v:'1.0',
    appKey:'8FB345B8693CCD0078950C62F0A8C431',
    imeiStr:'',
    userDeviceList:[],
    fenceModal:false,
    fenceCheckFlag:null,
    realTrackingFlag:false,
    baseUrl:window.Laravel.base_url,
  }),
  methods:{
    addPoint(e){
        if(!this.isAdding){
            return;
        }
        const {lng,lat} = e.Ag;
        this.addPolygonPoint(lng,lat)
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
      let appSecret = "0aedd5165f824284b57c918595a8cac4";
      let md5Secret = md5 (appSecret + str + appSecret)
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
          // this.$store.commit('setAccessToken',this.accessToken)
          // this.$store.commit('setRefreshToken',this.refreshToken)
          // this.getUserDeviceList()
          this.isLoading = false
      }).catch(err=>{
          console.log('error',err.response)
          this.isLoading = false
      })
    },
  }

}
</script>

<style>
.map {
  width: 100%;
  height: 78vh;
}
</style>