<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="schoolManagerData"
          :loading="isLoadingSchoolData"
          loading-text="正在要求学习资料... 等一下"
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar
                flat
            >
              <v-toolbar-title><strong>经理名单</strong></v-toolbar-title>
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
                            v-model="editedItem.name"
                            label="机构名称"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-text-field
                            v-model="editedItem.phoneNumber"
                            label="组织机构代码"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-text-field
                                v-model="editedItem.password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :type="show1 ? 'text' : 'password'"
                                label="固定电话"
                                @click:append="show1 = !show1"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-select
                            :items="genderItems"
                            item-text="label"
                            item-value="value"
                            v-model="editedItem.gender"
                            label="邮编"
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-text-field
                            v-model="editedItem.nation"
                            label="学校负责人"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-text-field
                            v-model="editedItem.cardNum"
                            label="学校负责人"
                            ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row class=" align-center">
                        <v-col cols="12" md="4" sm="6" class="d-flex justify-center">
                            <v-avatar v-if="editedItem.name !== '' && editedItem.imgUrl == ''" color="primary" size="127" tile>
                                <span class="white--text headline">{{editedItem.name[0]}}</span>
                            </v-avatar>
                            <img v-else-if="editedItem.name == '' && editedItem.imgUrl == ''" :src="`${baseUrl}/asset/img/icon/anonymous_avatar.png`" alt="UserAvatar" style="width:127px; height: 127px;">
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
                            v-model="editedItem.familyAddress.province"
                            @change="selectedProvinceOfResidenceAddress(editedItem.familyAddress.province)"
                            label="--省--"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="willBeCityDataOfResidenceAddress"
                            item-text="label"
                            v-model="editedItem.familyAddress.city"
                            :disabled="willBeCityDataOfResidenceAddress.length === 0"
                            label="--市--"
                            @change="selectedCityOfResidenceAddress(editedItem.familyAddress.city)"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="willBeRegionDataOfResidenceAddress"
                            item-text="label"
                            v-model="editedItem.familyAddress.region"
                            :disabled="willBeRegionDataOfResidenceAddress.length === 0" 
                            @change="selectedRegionOfResidenceAddress(editedItem.familyAddress.region)"
                            label="--区--"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.familyAddress.detail"
                          :disabled="willBeRegionDataOfResidenceAddress.length === 0"
                          label="详細地址"
                          ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="madeJsonFromString"
                            item-text="label"
                            v-model="editedItem.residenceAddress.province"
                            @change="selectedProvinceOfResidenceAddress(editedItem.residenceAddress.province)"
                            label="--省--"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="willBeCityDataOfResidenceAddress"
                            item-text="label"
                            v-model="editedItem.residenceAddress.city"
                            :disabled="willBeCityDataOfResidenceAddress.length === 0"
                            label="--市--"
                            @change="selectedCityOfResidenceAddress(editedItem.residenceAddress.city)"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="willBeRegionDataOfResidenceAddress"
                            item-text="label"
                            v-model="editedItem.residenceAddress.region"
                            :disabled="willBeRegionDataOfResidenceAddress.length === 0" 
                            @change="selectedRegionOfResidenceAddress(editedItem.residenceAddress.region)"
                            label="--区--"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.residenceAddress.detail"
                          :disabled="willBeRegionDataOfResidenceAddress.length === 0"
                          label="详細地址"
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
import { createSchoolManager, updateSchoolManager, getSchoolManager, deleteSchoolManager } from '~/api/school'
export default {
  components:{
    UploadImage,
    
  },

  data: () => ({
    dialog: false,
    dialogDelete: false,
    indroduceDialog : false,
    show1: false,
    rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 8 || 'Min 8 characters',
    },
    headers: [
      { text: '号码', value: 'id', align: 'start', },
      { text: '人员姓名', value: 'name', sortable: false },
      { text: '用户头像', value: 'imgUrl', sortable: false },
      { text: '电话号码', value: 'phoneNumber' },
      { text: '性別', value: 'gender' },
      { text: '民族', value: 'nation' },
      { text: '身份证号', value: 'cardNum', sortable: false },
      { text: '学校地址', value: 'familyAddress', sortable: false },
      { text: '学校地址', value: 'residenceAddress', sortable: false },
      { text: '行动', value: 'actions', sortable: false },
    ],
    genderItems:[
        { 
            label : "男", 
            value : "M" 
        },
        { 
            label : "女", 
            value : "F" 
        },
        
    ],
    schoolManagerData: [],
    schoolManagerListRaw : [],
    editedIndex: -1,
    editedItem: {
        name:'',
        phoneNumber:'',
        password:'',
        gender:null,
        nation : '',
        cardNum : '',
        familyAddress : {
            province : null,
            city : null, 
            region : null,
            detail : '',
        },
        residenceAddress : {
            province : null,
            city : null, 
            region : null,
            detail : '',
        },
        imgUrl : '',
    },
      
    defaultItem: {
        name:'',
        phoneNumber:'',
        password:'',
        gender:null,
        nation : '',
        cardNum : '',
        familyAddress : {
            province : null,
            city : null, 
            region : null,
            detail : '',
        },
        residenceAddress : {
            province : null,
            city : null, 
            region : null,
            detail : '',
        },
        imgUrl : '',
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
    schoolId : null,
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? '新增学校' : '编辑学校'
    },
    currentPath(){
        return this.$route
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
      this.schoolId = this.currentPath.params.id;
      let payload = {
        params : {
            id:this.schoolId
        }   
      }
      getSchoolManager(payload)
      .then((res) => {
        this.schoolManagerData = res.data.managerList;
        for(let i = 0 ; i < this.schoolManagerData.length ; i++){
          let clonedVal = JSON.parse(JSON.stringify(this.schoolManagerData[i]));
          this.schoolManagerListRaw.push(clonedVal); 
          this.schoolManagerData[i].address = this.convertAddress(this.schoolManagerData[i].address);
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
        this.editedIndex = this.schoolManagerData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.editedItem.address = JSON.parse(this.schoolManagerListRaw[this.editedIndex].address)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.schoolManagerData.indexOf(item)
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
            this.schoolManagerData.splice(this.editedIndex, 1)
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
        //update schoolManagerData
        if (this.editedIndex > -1) {
          this.isCreatingSchool = true;
          await updateSchool(this.editedItem)
          .then((res) => {
            this.isCreatingSchool = false;
            if(res.data.msg == 1){
              this.editedItem.address = this.convertAddress(JSON.stringify(this.editedItem.address))
              Object.assign(this.schoolManagerData[this.editedIndex], this.editedItem)
            }
          }).catch((err) => {
            this.isCreatingSchool = false;
            console.log(err)            
          });
        } 
        //save schoolManagerData
        else {
          this.isCreatingSchool = true;
          await createSchool(this.editedItem)
          .then((res) => {
            console.log(res.data);
            this.isCreatingSchool = false;
            this.editedItem.id = res.data.id;
            this.editedItem.address = this.convertAddress(JSON.stringify(this.editedItem.address))
            this.schoolManagerData.push(this.editedItem);
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