<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="checkData"
          :loading="isLoadingSchoolData"
          loading-text="正在加载..."
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar
                flat
            >
              <v-toolbar-title><strong>晨午检</strong></v-toolbar-title>
              <v-divider
              class="mx-4"
              inset
              vertical
              ></v-divider>
              <v-spacer></v-spacer>
              <div class="d-flex align-center">
                
                <v-menu
                    ref="checkAttendanceDateMenu"
                    v-model="checkAttendanceDateMenu"
                    :close-on-content-click="false"
                    :return-value.sync="checkAttendanceDate"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                          solo
                          v-model="checkAttendanceDate"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                          hide-details
                          class="mr-4"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="checkAttendanceDate"
                      no-title
                      scrollable
                      @change="onSelectCheckAttendanceDate"
                      locale="zh-cn"
                    >
                    </v-date-picker>
                </v-menu>
                <v-select
                  solo
                  v-model="checkAttendanceType"
                  :items="checkAttendanceTypeItem"
                  item-text="label"
                  item-value="value"
                  @change="selectedCheckAttendanceTypeItem"
                  :menu-props="{ top: false, offsetY: true }"
                  label="姓名"
                  hide-details
                  :disabled="checkAttendanceDate == ''"
                  class="mr-4"
                ></v-select>
              </div>
              <v-dialog
              v-model="dialog"
              max-width="800px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                  color="#7879ff"
                  dark
                  tile
                  class="mb-2 mr-4"
                  v-bind="attrs"
                  v-on="on"
                  >
                    <v-icon left>
                      mdi-plus
                    </v-icon>
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
                        <v-col cols="12" sm="6">
                          <v-select
                            solo
                            v-model="editedItem.checkType"
                            :items="checkTypeItem"
                            item-text="label"
                            item-value="value"
                            @change="selectedCheckType"
                            :menu-props="{ top: false, offsetY: true }"
                            label="项目"
                            hide-details
                        ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6">
                          <v-select
                            solo
                            v-model="editedItem.studentId"
                            :items="studentList"
                            item-text="name"
                            item-value="id"
                            @change="selectedStudent"
                            :menu-props="{ top: false, offsetY: true }"
                            label="姓名"
                            hide-details
                        ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6">
                          <v-select
                            solo
                            v-model="editedItem.signal"
                            :items="signalItem"
                            item-text="label"
                            item-value="value"
                            @change="selectedSignal"
                            :menu-props="{ top: false, offsetY: true }"
                            label="主要症状"
                            hide-details
                        ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6">
                          <v-datetime-picker 
                              label="发病时间" 
                              v-model="editedItem.startTime"
                              :okText='lang.ok'
                              :clearText='lang.cancel'
                          > </v-datetime-picker>
                        </v-col>
                        <v-col cols="12" sm="6">
                          <v-select
                            solo
                            v-model="editedItem.reason"
                            :items="reasonItem"
                            item-text="label"
                            item-value="value"
                            @change="selectedReason"
                            :menu-props="{ top: false, offsetY: true }"
                            label="诊断"
                            hide-details
                        ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6">
                          <v-text-field
                            v-model="editedItem.hospital"
                            label="诊断医院"
                            hide-details
                            solo
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
              <v-btn
                color="#f19861"
                dark
                tile
                class="mb-2"
                >
                发布
              </v-btn>
            </v-toolbar>
          </template>
          <template v-slot:[`item.imgUrl`]="{ item }">
            <img :src="`${baseUrl}${item.imgUrl}`" alt="Logo" class="school-table-img">
          </template>
          <template v-slot:[`item.startTime`]="{ item }">
            {{TimeView(item.startTime)}}
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
import { mapGetters } from 'vuex';
import { getStudentBylessonId } from '~/api/user'
import cityListJson from '!!raw-loader!../cityLaw.txt';
import lang from '~/helper/lang.json'
import {getCheckInData,createCheckInData,updateCheckInData,deleteCheckInData} from '~/api/checkIn'
export default {
  data: () => ({
    lang,
    dialog: false,
    dialogDelete: false,
    indroduceDialog : false,
    checkAttendanceDateMenu: false,
    checkAttendanceDate: new Date().toISOString().substr(0, 10),
    checkAttendanceType: '晨检',
    checkAttendanceTypeItem: [
      {
        label: "晨检",
        value: "晨检"
      },
      {
        label: "午检",
        value: "午检"
      },
    ],
    headers: [
      { text: '项目', value: 'checkType', align: 'start'},
      { text: '姓名', value: 'name', sortable: false },
      { text: '性别', value: 'gender', sortable: false },
      { text: '年龄', value: 'age', sortable: false },
      { text: '家庭住址', value: 'familyAddress', sortable: false },
      { text: '主要症状', value: 'signal', sortable: false },
      { text: '发病时间', value: 'startTime', sortable: false },
      { text: '诊断', value: 'reason', sortable: false },
      { text: '诊断医院', value: 'hospital', sortable: false },
      { text: '联系电话', value: 'phoneNumber', sortable: false },
      { text: '操作', value: 'actions', sortable: false },
    ],
    checkTypeItem: [
      {
        label: "因病缺席",
        value: "因病缺席"
      },
      {
        label: "体征异常",
        value: "体征异常"
      },
    ],
    signalItem: [
      {
        label: "发热",
        value: "发热"
      },
      {
        label: "咽痛",
        value: "咽痛"
      },
      {
        label: "咳嗽",
        value: "咳嗽"
      },
      {
        label: "皮疹",
        value: "皮疹"
      },
      {
        label: "腹泻",
        value: "腹泻"
      },
      {
        label: "呕吐",
        value: "呕吐"
      },
      {
        label: "黄疸",
        value: "黄疸"
      },
      {
        label: "腮腺肿大",
        value: "腮腺肿大"
      },
      {
        label: "结膜红肿",
        value: "结膜红肿"
      },
      {
        label: "伤害",
        value: "伤害"
      },
      {
        label: "输入症状",
        value: "输入症状"
      },
    ],
    reasonItem: [
      {
        label: "未就诊",
        value: "未就诊"
      },
      {
        label: "心脏病",
        value: "心脏病"
      },
      {
        label: "急性出血性结膜炎(红眼病)",
        value: "急性出血性结膜炎(红眼病)"
      },
      {
        label: "结核",
        value: "结核"
      },
      {
        label: "上呼吸道感染",
        value: "上呼吸道感染"
      },
      {
        label: "流感样病例",
        value: "流感样病例"
      },
      {
        label: "手足口病",
        value: "手足口病"
      },
      {
        label: "流行性腮腺炎",
        value: "流行性腮腺炎"
      },
      {
        label: "耳鼻喉疾病",
        value: "耳鼻喉疾病"
      },
      {
        label: "神经衰弱",
        value: "神经衰弱"
      },
      {
        label: "气管炎/肺炎",
        value: "气管炎/肺炎"
      },
      {
        label: "胃肠道疾病",
        value: "胃肠道疾病"
      },
      {
        label: "泌尿系疾病",
        value: "泌尿系疾病"
      },
      {
        label: "伤害",
        value: "伤害"
      },
      {
        label: "水痘",
        value: "水痘"
      },
      {
        label: "风疹",
        value: "风疹"
      },
      {
        label: "麻疹",
        value: "麻疹"
      },
      {
        label: "牙病",
        value: "牙病"
      },
      {
        label: "眼病",
        value: "眼病"
      },
      {
        label: "肝炎",
        value: "肝炎"
      },
      {
        label: "其它传染病",
        value: "其它传染病"
      },
    ],
    checkData: [],
    checkDataRaw : [],
    editedIndex: -1,
    editedItem: {
      checkType: '',
      studentId: 0,
      signal: '',
      startTime: null,
      reason: '',
      hospital: '',
    },
      
    defaultItem: {
      checkType: '',
      studentId: 0,
      signal: '',
      startTime: null,
      reason: '',
      hospital: '',
    },
    provinceListJsonArr:[],
    madeJsonFromString : [],
    baseUrl:window.Laravel.base_url,
    isCreatingSchool : false,
    isLoadingSchoolData : false,
    isDeleteSchool : false,
    studentList : [],
  }),

  computed: {
    ...mapGetters({
      user : 'auth/user',
    }),
    formTitle () {
      return this.editedIndex === -1 ? '新增' : '编辑'
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
      if(this.user.lessonId == 0 || this.user.gradeId == 0){
        return ;
      }
      let payload = {
        lessonId: this.user.lessonId,
        gradeId: this.user.gradeId,
      }
      await getStudentBylessonId(payload)
      .then((res) => {
        this.studentList = res.data;
        this.studentList.map( x => {
          x.familyAddress = this.convertAddress(x.familyAddress);
        })
        console.log(")))))", this.studentList)
      }).catch((err) => {
        console.log(err)
      });

      getCheckInData({checkInDate:this.checkAttendanceDate}).then(res=>{
        console.log('++++++++',res.data)
        res.data.map(checkData=>{
          let clonedEditedItem = Object.assign({}, checkData);
          let selectedStudentData = {};
          this.studentList.map( x =>{
            if(x.id == checkData.studentId){
              selectedStudentData = x;
            }
          })
          clonedEditedItem["name"] = selectedStudentData.name;
          clonedEditedItem["gender"] = this.convertGender(selectedStudentData.gender);
          clonedEditedItem["age"] = this.calcAge(new Date(selectedStudentData.birthday));
          clonedEditedItem["familyAddress"] = selectedStudentData.familyAddress;
          clonedEditedItem["phoneNumber"] = selectedStudentData.phoneNumber;
          // console.log("clonedEditedItem",clonedEditedItem)
          this.checkData.push(clonedEditedItem);
        })
        
      })
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
        this.checkData.splice(this.editedIndex, 1)
        this.closeDelete()
        // this.isDeleteSchool = true;
        // this.isDeleteSchool = false;
      },

      close () {
        this.dialog = false
        this.editedItem.checkType = '';
        this.editedItem.signal = '';
        this.editedItem.startTime = '';
        this.editedItem.reason = '';
        this.editedItem.hospital = '';
        this.editedItem.studentId = 0;
        this.editedIndex = -1
        // this.$nextTick(() => {
        //   this.editedItem =  JSON.parse(JSON.stringify(this.defaultItem))
        // })
        console.log("************", this.editedItem, this.defaultItem)
      },

      closeDelete () {
        this.dialogDelete = false
        this.editedItem.checkType = '';
        this.editedItem.signal = '';
        this.editedItem.startTime = '';
        this.editedItem.reason = '';
        this.editedItem.hospital = '';
        this.editedItem.studentId = 0;
        this.editedIndex = -1
      },

      async save () {
        //update checkData
        if (this.editedIndex > -1) {
          // this.isCreatingSchool = true;
          // this.isCreatingSchool = false;
          console.log("Updatethis.editedItem", this.editedItem);
          let clonedEditedItem = Object.assign({}, this.editedItem);
          let selectedStudentData = {};
          this.studentList.map( x =>{
            if(x.id == this.editedItem.studentId){
              selectedStudentData = x;
            }
          })
          clonedEditedItem["name"] = selectedStudentData.name;
          clonedEditedItem["gender"] = this.convertGender(selectedStudentData.gender);
          clonedEditedItem["age"] = this.calcAge(new Date(selectedStudentData.birthday));
          clonedEditedItem["familyAddress"] = selectedStudentData.familyAddress;
          clonedEditedItem["phoneNumber"] = selectedStudentData.phoneNumber;
          Object.assign(this.checkData[this.editedIndex], clonedEditedItem)
        } 
        //save checkData
        else {
          let payload = Object.assign({},this.editedItem);
          payload.checkInDate = this.checkAttendanceDate
          payload.checkAttendanceType = this.checkAttendanceType
          console.log("payload",payload)
          await createCheckInData(payload).then(res=>{
            console.log(res.data)
          }).catch(err=>{
            console.log(err.response)
          })
          let clonedEditedItem = Object.assign({}, this.editedItem);
          let selectedStudentData = {};
          this.studentList.map( x =>{
            if(x.id == this.editedItem.studentId){
              selectedStudentData = x;
            }
          })
          clonedEditedItem["name"] = selectedStudentData.name;
          clonedEditedItem["gender"] = this.convertGender(selectedStudentData.gender);
          clonedEditedItem["age"] = this.calcAge(new Date(selectedStudentData.birthday));
          clonedEditedItem["familyAddress"] = selectedStudentData.familyAddress;
          clonedEditedItem["phoneNumber"] = selectedStudentData.phoneNumber;
          // console.log("clonedEditedItem",clonedEditedItem)
          this.checkData.push(clonedEditedItem);
          // this.isCreatingSchool = true;
          // creatxxx()
          // .then((res) => {
          //   if(res.data.mag == 1)
          //   this.checkData.push(clonedEditedItem);
          // }).catch((err) => {
          //   console.log(err)
          // });
          // this.isCreatingSchool = false;
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

      selectedCheckType( val ){
        this.editedItem.checkType = val;
      },

      selectedStudent( val ){
        this.editedItem.studentId = val;
      },

      selectedReason( val ){
        this.editedItem.reason = val;
      },

      selectedSignal( val ){
        this.editedItem.signal = val;
      },

      convertGender( val ){
        if(val == 'F'){
          return "女";
        }
        else if(val == 'M') {
          return "男";
        }
      },

      calcAge(val){
        var diff_ms = Date.now() - val.getTime();
        var age_dt = new Date(diff_ms); 
      
        return Math.abs(age_dt.getUTCFullYear() - 1970);
      },

      onSelectCheckAttendanceDate(val){          
        this.$refs.checkAttendanceDateMenu.save(val);
        this.checkAttendanceDate = val;
        this.checkData = []
        getCheckInData({checkInDate:this.checkAttendanceDate}).then(res=>{
        console.log('++++++++',res.data)
        res.data.map(checkData=>{
          let clonedEditedItem = Object.assign({}, checkData);
          let selectedStudentData = {};
          this.studentList.map( x =>{
            if(x.id == checkData.studentId){
              selectedStudentData = x;
            }
          })
          clonedEditedItem["name"] = selectedStudentData.name;
          clonedEditedItem["gender"] = this.convertGender(selectedStudentData.gender);
          clonedEditedItem["age"] = this.calcAge(new Date(selectedStudentData.birthday));
          clonedEditedItem["familyAddress"] = selectedStudentData.familyAddress;
          clonedEditedItem["phoneNumber"] = selectedStudentData.phoneNumber;
          // console.log("clonedEditedItem",clonedEditedItem)
          this.checkData.push(clonedEditedItem);
        })
        
      })
      },

      selectedCheckAttendanceTypeItem(val){
        this.checkAttendanceType = val;
      }

    },
  }
</script>
<style>

</style>