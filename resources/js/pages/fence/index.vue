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
            color="#7879ff"
            @click="selContent('template')"
          >
              可用模板 {{tempCnt}}， 草稿 {{draftCnt}}
          </v-btn> -->
          <v-btn @click="fetchHole">
            test            
          </v-btn>
          <v-btn
              tile
              dark
              color="#7879ff"
              class="mx-2"
              @click="addFence"
              :disabled="isSelected == true"
          >
              <span v-if="isAdding == false">添加</span>
              <span v-else>加...</span> 
          </v-btn>
          <v-btn
              tile
              dark
              class="mx-2"
              color="#F19861"
              :disabled="isSelected == false"
              @click="familyModal = true"
          >
              亲情号码
          </v-btn>
          <v-btn
              tile
              dark
              color="#4AD2A0"
              :disabled="isSelected == false"
              @click="trackModal = true"
          >
              轨迹回放
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
    <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
      <v-progress-circular
          indeterminate
          color="#7879ff"
      ></v-progress-circular>
    </div>
    <v-row v-else>
      <v-col cols="3">
        <div v-for="user in userDeviceList" :key="user.imei">
          <v-row class="hover-cursor-point pa-3" :class="{'selDevice':user.active}" @click="selDevice(user)">
            <v-col>
              {{user.imei}}
              ({{user.name}})
            </v-col>
          </v-row>
          <v-divider light class="thick-border"></v-divider>
        </div>
      </v-col>
      <v-col cols="9">
        <baidu-map class="map" :center="{lng:centerLng,lat:centerLat}" :zoom="15" :scroll-wheel-zoom="true" @click="addPoint" @rightclick="removePoint">
          <div v-for="(polygonPathData,i) in allPolygonPath" :key="i">
              <bm-polygon :path="polygonPathData.location" fill-color="red" stroke-color="blue" :stroke-opacity="0.5" :stroke-weight="2" @click="selPolygon(polygonPathData,i)" :editing="isAdding" @lineupdate="updatePolygonPath"/>
          </div>
          <bm-polygon :path="polygonPath" fill-color="red" stroke-color="blue" :stroke-opacity="0.5" :stroke-weight="2"  :editing="isAdding"  @lineupdate="updatePolygonPath"/>
          <bm-polyline :path="trackPath" stroke-color="red" :stroke-opacity="0.5" :stroke-weight="2"></bm-polyline>
          <div v-for="user in userDeviceList" :key="user.imei">
            <bm-marker :position="{lng: user.lng, lat: user.lat}" @infowindowopen="userInfo(e)" animation="BMAP_ANIMATION_BOUNCE">
            </bm-marker>
          </div>
          <!-- <bm-marker :position="{lng: userlng, lat: userlat}" :dragging="true" animation="BMAP_ANIMATION_BOUNCE">
          </bm-marker> -->
          <bm-control>
              
          </bm-control>
          <bm-local-search :keyword="keyword" :auto-viewport="true" :forceLocal="true" :panel="false" :selectFirstResult="true" location="沈阳"></bm-local-search>
          <bm-geolocation anchor="BMAP_ANCHOR_BOTTOM_RIGHT" :showAddressBar="true" :autoLocation="true"></bm-geolocation>
        </baidu-map>
      </v-col>
    </v-row>
    <!-- fence modal -->
    <v-row justify="center">
      <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
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
      <v-dialog eager :overlay-opacity="$isMobile()? '0': '0.4'" 
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
                <v-col cols="12" md="6">
                  <v-text-field
                    label="姓名1*"
                    required
                    v-model="familyData.name1"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    label="号码1*"
                    required
                    class="max-length-11-staff-input"
                    v-model="familyData.phone1"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="6">
                  <v-text-field
                    label="姓名2*"
                    required
                    v-model="familyData.name2"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    label="号码2*"
                    class="max-length-11-staff-input"
                    v-model="familyData.phone2"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="6">
                  <v-text-field
                    label="姓名3*"
                    required
                    v-model="familyData.name3"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    label="号码3*"
                    class="max-length-11-staff-input"
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
      <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
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
import {getData,getFence,createFence,deleteFence,createInstruction} from '~/api/fence'
import {getRoleUsers} from '~/api/user'
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
        studentList:[],
    },
    lang,
    familyModal:false,
    familyData:{
      name1:'',
      phone1:'',
      name2:'',
      phone2:'',
      name3:'',
      phone3:'',
    },
    trackModal:false,
    trackData:{
      begin_time:'',
      end_time:''
    },
    allPolygonPath:[],
    polygonPath: [],
    isLoading:false,
    isSaving:false,
    isAdding:false,
    isChecking:false,
    isEditing:false,
    isDeleting:false,
    isSelected:false,
    selUserInfo:null,
    centerLng:123.474976,
    centerLat:41.695735,
    userlng:123.474976,
    userlat:41.695735,
    keyword:'',
    fenceCheck:'',
    selectedIdx:null,
    isNew:true,
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
      authToken:'fence/authToken',
      user:'auth/user'
    })
  },

  async created(){
    this.isLoading = true
    await getRoleUsers().then(res=>{
      console.log('userList',res.data)
      let lngMin = 123474900;
      let lngMax = 123499999;
      let latMin = 41695000;
      let latMax = 41699999;
      res.data.map(user=>{
        user.lng = (Math.floor(Math.random() * (lngMax - lngMin + 1)) + lngMin)/1000000;
        user.lat = (Math.floor(Math.random() * (latMax - latMin + 1)) + latMin)/1000000;
      })
      this.userDeviceList = res.data
    }).catch(err=>{
      console.log(err.response)
      this.isLoading = false
    })
    await getFence().then(res=>{
      console.log(res.data)
      this.allPolygonPath = res.data
    }).catch(err=>{
      console.log(err.response)
      this.isLoading = false
    })
    this.isLoading = false
  },
  mounted(){
    var ele_11 = $('.max-length-11-staff-input')
    ele_11.find('input').attr("maxlength","11")
  },
  methods:{
    getDeviceLocationList(){
      let lngMin = 123474900;
      let lngMax = 123499999;
      let latMin = 41695000;
      let latMax = 41699999;
        
      this.userDeviceList.map(user=>{
        user.lng = (Math.floor(Math.random() * (lngMax - lngMin + 1)) + lngMin)/1000000;
        user.lat = (Math.floor(Math.random() * (latMax - latMin + 1)) + latMin)/1000000;
      })
    },
    addFence(){
      if(this.isAdding == true){
        if(this.polygonPath.length < 3){
          return this.$snackbar.showMessage({content:'test',color:'error'})
        }
        this.fenceModal = true
      }
      this.isAdding = !this.isAdding
    },
    addPoint(e){
        if(!this.isAdding){
            return;
        }
        const {lng,lat} = e.Ag;
        this.addPolygonPoint(lng,lat)
    },
    removePoint(e){
      // this.isAdding = false
      // const {lng,lat} = e.Ag
      // let item ={}
      // item.lng = lng
      // item.lat = lat
      // console.log(item)
      // console.log(this.polygonPath)
      // let index = this.polygonPath.indexOf(item)
      // console.log(index)
      this.polygonPath = []
      this.isAdding = false
    },
    removePolygon(e){
      console.log(e.type,e.target)
    },
    addPolygonPoint (lng,lat) {
        this.polygonPath.push({lng: lng, lat: lat})
    },
    
    async saveFence(){
      this.fenceData.location = this.polygonPath
      this.userDeviceList.map(user=>{
        this.fenceData.studentList.push(user.id)
      })
      console.log(this.fenceData)
      // return
      this.isSaving = true
      await createFence(this.fenceData).then(res=>{
        console.log(res.data)
        this.isSaving = false
        this.allPolygonPath.push(res.data)
        this.fenceModal = false
        this.polygonPath = []
      }).catch(err=>{
        console.log(err.response)
        this.isSaving = false
      })
    },
    // drawNewpolygon(e){
    //     if(this.polygonPath.length < 3){
    //       return
    //     }
    //     this.fenceModal = true
    // },
    selPolygon(fence,index){
      console.log(index)
       this.allPolygonPath.map(polygon=>{
         polygon.editing = 0
       })
       fence.editing = 1
      console.log(this.allPolygonPath)
      // return this.$snackbar.showMessage({content:fence.fenceName,color:'success'})
    },
    updatePolygonPath (e) {
        this.polygonPath = e.target.getPath()
    },
    
    selDevice(device){
      for(let i=0;i<this.userDeviceList.length;i++){
          delete this.userDeviceList[i].active
      }
      if(this.selUserInfo != null){
        if(this.selUserInfo.id == device.id){
          this.selUserInfo = null
          this.isSelected = false
        }else{
          this.$set(device,'active',true)
          this.selUserInfo = device
          console.log(this.selUserInfo)
          this.isSelected = true  
        }
      }
      else{
        this.$set(device,'active',true)
        this.selUserInfo = device
        console.log(this.selUserInfo)
        this.isSelected = true
      }
      // this.realTracking()
      // this.getFenceData();
      // this.getDeviceLocationList()
    },

    userInfo(e){
      console.log(e)
    },

    fetchHole(){
        console.log('checkFence',this.allPolygonPath)
        this.getDeviceLocationList()
        var BMap = require('bmaplib').BMap;
        var BMapLib = require('bmaplib').BMapLib;
        var pts = []
        if(this.allPolygonPath.length == 0){
            return this.$$snackbar.showMessage({content:'电子围栏不存在。',color:'error'})
        }
        for(let i =0; i<this.allPolygonPath.length;i++){
            for(let j=0;j<this.allPolygonPath[i].location.length;j++){
                var pt = new BMap.Point(this.allPolygonPath[i].location[j].lng, this.allPolygonPath[i].location[j].lat);
                pts.push(pt)
            }
        }
        var ply = new BMap.Polygon(pts);
        this.userDeviceList.map(user=>{
          let pt =new BMap.Point(user.lng,user.lat );
          let result = BMapLib.GeoUtils.isPointInPolygon(pt, ply);
          if(result == false){
            console.log(user.name,'outside')
          }else{
            console.log(user.name,'inside')
          }
        })
        let vm = this
        setTimeout(function() {
          vm.fetchHole()
        }, 3000);
    },
    realTracking(){
    },

    async instructionSend(){
      console.log(this.familyData)
      if(this.familyData.name1.trim() == '' || this.familyData.name2.trim() == '' || this.familyData.name3.trim() == ''){
        return this.$snackbar.showMessage({content:this.lang.requiredName,color:'error'})
      }
      if(this.familyData.phone1.length != 11 ||this.familyData.phone2.length != 11 || this.familyData.phone3.length != 11 ){
        return this.$snackbar.showMessage({content:this.lang.requireCorrectPhoneNumber,color:'error'})
      }
      this.isSaving = true
      await createInstruction({userId:this.selUserInfo.id,imei:this.selUserInfo.imei,familyData:this.familyData}).then(res=>{
        console.log(res.data)
        this.isSaving = false
        this.familyModal = false
      }).catch(err=>{
        console.log(err.response)
        this.isSaving = false
      })
    },

    getDeviceTrack(){
      
    }


  },
  

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