<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="schoolData"
          :loading="isLoadingSchoolData"
          loading-text="正在要求学习资料... 等一下"
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar
                flat
            >
              <v-toolbar-title><strong>学校</strong></v-toolbar-title>
              <v-divider
              class="mx-4"
              inset
              vertical
              ></v-divider>
              <v-spacer></v-spacer>
              <v-dialog
              v-model="dialog"
              max-width="500px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                  color="primary"
                  dark
                  class="mb-2"
                  v-bind="attrs"
                  v-on="on"
                  >
                  添加
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.schoolName"
                          label="机构名称"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.code"
                          label="组织机构代码"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.phoneNum"
                          label="固定电话"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.zipCode"
                          label="邮编"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.head"
                          label="学校负责人"
                          ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row class=" align-center">
                        <v-col cols="12" md="4" sm="6" class="d-flex justify-center">
                          <img v-if="editedItem.imgUrl == ''" :src="`${baseUrl}/asset/img/icon/schoolGrayImage2.png`" alt="SchoolIcon" style="width:127px; height: 127px;">
                          <img v-else-if="editedItem.imgUrl !== ''" :src="editedItem.imgUrl" alt="" style="width:127px; height: 127px;">
                        </v-col>
                        <v-col cols="12" md="8" sm="6">
                          <UploadImage @upImgUrl="upImgUrl" @clearedImg="clearedImg" uploadLabel="上传学校图片" />
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="madeJsonFromString"
                            item-text="label"
                            v-model="editedItem.address.province"
                            @change="selectedProvinceOfResidenceAddress(editedItem.address.province)"
                            label="--省--"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="willBeCityDataOfResidenceAddress"
                            item-text="label"
                            v-model="editedItem.address.city"
                            :disabled="willBeCityDataOfResidenceAddress.length === 0"
                            label="--市--"
                            @change="selectedCityOfResidenceAddress(editedItem.address.city)"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="willBeRegionDataOfResidenceAddress"
                            item-text="label"
                            v-model="editedItem.address.region"
                            :disabled="willBeRegionDataOfResidenceAddress.length === 0" 
                            @change="selectedRegionOfResidenceAddress(editedItem.address.region)"
                            label="--区--"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.address.detail"
                          :disabled="willBeRegionDataOfResidenceAddress.length === 0"
                          label="详細地址"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                          <v-text-field
                          v-model="editedItem.introduce"
                          label="学校简介"
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
                      @click="close"
                    >
                      取消
                    </v-btn>
                    <v-btn
                      color="blue darken-1"
                      text
                      :loading="isCreatingSchool"
                      @click="save"
                    >
                      保存
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                  <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="deleteItemConfirm" :loading="isDeleteSchool">OK</v-btn>
                  <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog
                v-model="indroduceDialog"
                max-width="500px"
              >
                <v-card>
                  <v-card-title class="title">
                    School Introduce
                  </v-card-title>
                  <v-card-text
                  >
                    {{ schoolIntroduceData }}
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="primary"
                      @click="indroduceDialog = false"
                    >
                      Ok
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:[`item.imgUrl`]="{ item }">
            <img :src="`${baseUrl}${item.imgUrl}`" alt="Logo" class="school-table-img">
          </template>
          <template v-slot:[`item.introduce`]="{ item }">
            <v-btn
              outlined
              small
              color="indigo"
              @click="showSchoolIntroduce(item.introduce)"
            >
              查看学校介绍
            </v-btn>
            <router-link :to="{path:`/admin/school/${item.id}/manager`}">
              <v-btn
                outlined
                small
                class="mt-3"
                color="indigo"
              >
                查看经理数据
              </v-btn>
            </router-link>
          </template>
          <template v-slot:[`item.actions`]="{ item }">
              <v-icon
                  small
                  class="mr-2"
                  @click="editItem(item)"
              >
                  mdi-pencil
              </v-icon>
              <v-icon
                  small
                  @click="deleteItem(item)"
              >
                  mdi-delete
              </v-icon>
          </template>
          <template v-slot:no-data>
            <p>没有学习资料</p>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

import cityListJson from '!!raw-loader!./cityLaw.txt';
import UploadImage from '~/components/UploadImage';
import { createSchool, updateSchool, getSchool, deleteSchool } from '~/api/school'
export default {
  components:{
    UploadImage,
    
  },

  data: () => ({
    dialog: false,
    dialogDelete: false,
    indroduceDialog : false,
    headers: [
      { text: '号码', value: 'id', align: 'start'},
      { text: '图标图像', value: 'imgUrl', sortable: false },
      { text: '机构名称', value: 'schoolName', sortable: false },
      { text: '组织机构代码', value: 'code' },
      { text: '固定电话', value: 'phoneNum' },
      { text: '邮编', value: 'zipCode' },
      { text: '学校负责人', value: 'head', sortable: false },
      { text: '学校地址', value: 'address', sortable: false },
      { text: '学校简介', value: 'introduce', sortable: false },
      { text: '行动', value: 'actions', sortable: false },
    ],
    schoolData: [],
    schoolListRaw : [],
    editedIndex: -1,
    editedItem: {
      id: 0,
      imgUrl: '',
      schoolName: '',
      code: 0,
      phoneNum: 0,
      zipCode: 0,
      head: '',
      address : {
        province : null,
        city : null, 
        region : null,
        detail : '',
      },
      introduce: '',
    },
      
    defaultItem: {
      id: 0,
      imgUrl: '',
      schoolName: '',
      code: 0,
      phoneNum: 0,
      zipCode: 0,
      head: '',
      address : {
        province : null,
        city : null, 
        region : null,
        detail : '',
      },
      introduce: '',
    },
    provinceListJsonArr:[],
    madeJsonFromString : [],
    willBeCityDataOfResidenceAddress : [],
    willBeRegionDataOfResidenceAddress : [],
    baseUrl:window.Laravel.base_url,
    isCreatingSchool : false,
    isLoadingSchoolData : false,
    isDeleteSchool : false,
    schoolIntroduceData : '',
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? '新增学校' : '编辑学校'
    },
  },

    async created(){
      this.provinceListJsonArr = cityListJson.split("#");
      for (let i = 0; i < this.provinceListJsonArr.length; i++) {
          let provinceObj = {
              value : 1,
              label : "",
              city : []
          }
          let province = this.provinceListJsonArr[i].split("$")[0];
          provinceObj.value = province.split("-")[0];
          provinceObj.label = province.split("-")[1];
          this.madeJsonFromString.push(provinceObj);
          let TArea = this.provinceListJsonArr[i].split("$")[1].split("|");
          for(let j = 0 ; j < TArea.length ; j++){
              let cityObj = {
                  value : 1,
                  label : "",
                  region : []
              }
              let cityArr = TArea[j].split(",");
              cityObj.value = cityArr[0].split("-")[0];
              cityObj.label = cityArr[0].split("-")[1];
              for( let k = 1 ; k < cityArr.length ; k++){
                  let regionObj = {
                      value : 1, 
                      label : "",
                  }
                  regionObj.value = cityArr[k].split("-")[0];
                  regionObj.label = cityArr[k].split("-")[1];
                  cityObj.region.push(regionObj);
              }
              this.madeJsonFromString[i].city.push(cityObj);
          }


      }
      this.isLoadingSchoolData = true;
      getSchool()
      .then((res) => {
        this.schoolData = res.data;
        for(let i = 0 ; i < this.schoolData.length ; i++){
          let clonedVal = JSON.parse(JSON.stringify(this.schoolData[i]));
          this.schoolListRaw.push(clonedVal); 
          this.schoolData[i].address = this.convertAddress(this.schoolData[i].address);
        }
        this.isLoadingSchoolData = false;
      }).catch((err) => {
        console.log(err);
        this.isLoadingSchoolData = false;
      });
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    methods: {

      editItem (item) {
        this.editedIndex = this.schoolData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.editedItem.address = JSON.parse(this.schoolListRaw[this.editedIndex].address)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.schoolData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      async deleteItemConfirm () {
        let payload = {
          id : this.editedItem.id
        }
        this.isDeleteSchool = true;
        await deleteSchool(payload)
        .then((res) => {
          if(res.data.msg == 1){
            this.schoolData.splice(this.editedIndex, 1)
          }
          this.isDeleteSchool = false;
        }).catch((err) => {
          console.log(err)
          this.isDeleteSchool = false;
        });
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      async save () {
        //update schoolData
        if (this.editedIndex > -1) {
          this.isCreatingSchool = true;
          await updateSchool(this.editedItem)
          .then((res) => {
            this.isCreatingSchool = false;
            if(res.data.msg == 1){
              let clonedVal = Object.assign({}, this.editedItem);
              clonedVal.address = JSON.stringify(clonedVal.address);
              this.schoolListRaw.push(clonedVal);
              this.editedItem.address = this.convertAddress(JSON.stringify(this.editedItem.address))
              Object.assign(this.schoolData[this.editedIndex], this.editedItem)
            }
          }).catch((err) => {
            this.isCreatingSchool = false;
            console.log(err)            
          });
        } 
        //save schoolData
        else {
          this.isCreatingSchool = true;
          await createSchool(this.editedItem)
          .then((res) => {
            this.isCreatingSchool = false;
            this.editedItem.id = res.data.id;
            //push data to schoolDataLaw
            let clonedItem = JSON.parse(JSON.stringify(this.editedItem))
            clonedItem.address = JSON.stringify(clonedItem.address)
            this.schoolListRaw.push(clonedItem);
            //push data to used schoolData
            this.editedItem.address = this.convertAddress(JSON.stringify(this.editedItem.address))
            this.schoolData.push(this.editedItem);
          }).catch((err) => {
            console.log(err)
            this.isCreatingSchool = false;
          });
        }
        this.close()
      },

      selectedProvinceOfResidenceAddress(val){
        for( let i = 0 ; i < this.madeJsonFromString.length ; i++){
          if( val == this.madeJsonFromString[i].value ){
            this.willBeCityDataOfResidenceAddress = this.madeJsonFromString[i].city;
            this.willBeRegionDataOfResidenceAddress = [];
            this.editedItem.address.city = null;
            this.editedItem.address.region = null;
          }
        }
      },
      selectedCityOfResidenceAddress(val){
        if (val != undefined){
          for( let i = 0 ; i < this.willBeCityDataOfResidenceAddress.length ; i++){
            if( val == this.willBeCityDataOfResidenceAddress[i].value){
              this.willBeRegionDataOfResidenceAddress = this.willBeCityDataOfResidenceAddress[i].region;
            }
          }
        }
      },
      selectedRegionOfResidenceAddress(val){
      },

      upImgUrl(value) {
        this.editedItem.imgUrl = value;
        console.log(this.editedItem.imgUrl);
      },
      clearedImg(){
        this.editedItem.imgUrl = ''
        console.log(this.editedItem.imgUrl);
      },
      convertAddress(address){
        address = JSON.parse(address);
        let province = '';
        let city = '';
        let region = '';
        for(let i = 0 ; i < this.madeJsonFromString.length ; i++){
          if( address.province == this.madeJsonFromString[i].value ){
            province = this.madeJsonFromString[i].label;
            for(let j = 0 ; j < this.madeJsonFromString[i].city.length ; j++){
              if( address.city == this.madeJsonFromString[i].city[j].value ){
                city = this.madeJsonFromString[i].city[j].label;
                for(let k = 0 ; k < this.madeJsonFromString[i].city[j].region.length ; k++){
                  if( address.region == this.madeJsonFromString[i].city[j].region[k].value ){
                    region = this.madeJsonFromString[i].city[j].region[k].label;
                  }
                }
              }
            }
          }
        }
        return province + ' ' + city + ' ' + region + ' ' + address.detail;
      },

      showSchoolIntroduce (introduce){
        this.schoolIntroduceData = introduce;
        this.indroduceDialog = true;
      },

      // navigateToManagerData(id){
        
      // }
    },
  }
</script>
<style>

</style>