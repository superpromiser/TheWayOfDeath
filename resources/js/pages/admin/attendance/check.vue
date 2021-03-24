<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="checkData"
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
                      {{lang.cancel}}
                    </v-btn>
                    <v-btn
                      color="blue darken-1"
                      text
                      :loading="isCreatingSchool"
                      @click="save"
                    >
                      {{lang.save}}
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="headline">{{lang.confirmSentence}}</v-card-title>
                  <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="closeDelete">{{lang.cancel}}</v-btn>
                  <v-btn color="blue darken-1" text @click="deleteItemConfirm" :loading="isDeleteSchool">{{lang.ok}}</v-btn>
                  <v-spacer></v-spacer>
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
              class="ma-2"
              @click="showSchoolIntroduce(item.introduce)"
            >
              查看学校介绍
            </v-btn>
            <router-link :to="{path:`/admin/school/${item.id}/manager`}">
              <v-btn
                outlined
                small
                color="indigo"
                class="ma-2"
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

import cityListJson from '!!raw-loader!../cityLaw.txt';
import lang from '~/helper/lang.json'
export default {

  data: () => ({
    lang,
    dialog: false,
    dialogDelete: false,
    indroduceDialog : false,
    headers: [
      { text: '项目', value: 'checkType', align: 'start'},
      { text: '姓名', value: 'name', sortable: false },
      { text: '性别', value: 'gender', sortable: false },
      { text: '年龄', value: 'age', sortable: false },
      { text: '家庭住址', value: 'familyAddress', sortable: false },
      { text: '主要症状', value: 'signal', sortable: false },
      { text: '发病时间', value: 'startTime', sortable: false },
      { text: '诊断', value: 'solution', sortable: false },
      { text: '诊断医院', value: 'solutionHospital', sortable: false },
      { text: '联系电话', value: 'phoneNumber', sortable: false },
      { text: '操作', value: 'actions', sortable: false },
    ],
    checkData: [],
    checkDataRaw : [],
    editedIndex: -1,
    editedItem: {
      checkType: '',
      studentId: 0,
      signal: '',
      startTime: null,
      solution: '',
      solutionHospital: '',
    },
      
    defaultItem: {
      checkType: '',
      studentId: 0,
      signal: '',
      startTime: null,
      solution: '',
      solutionHospital: '',
    },
    provinceListJsonArr:[],
    madeJsonFromString : [],
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
      // this.isLoadingSchoolData = true;
      // this.isLoadingSchoolData = false;
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
        this.editedIndex = this.checkData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.checkData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      async deleteItemConfirm () {
        let payload = {
          id : this.editedItem.id
        }
        // this.isDeleteSchool = true;
        // this.isDeleteSchool = false;
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
        //update checkData
        if (this.editedIndex > -1) {
          // this.isCreatingSchool = true;
          // this.isCreatingSchool = false;
          console.log("Updatethis.editedItem", this.editedItem);
          Object.assign(this.checkData[this.editedIndex], this.editedItem)
        } 
        //save checkData
        else {
          console.log("Savethis.editedItem", this.editedItem);
          this.checkData.push(this.editedItem);
          this.isCreatingSchool = true;
          this.isCreatingSchool = false;
        }
        this.close()
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

    },
  }
</script>
<style>

</style>