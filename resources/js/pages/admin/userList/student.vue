<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="schoolManagerData"
          :loading="isLoadingSchoolData"
          loading-text="正在加载..."
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar
                flat
            >
              <v-toolbar-title><strong>学生名单</strong></v-toolbar-title>
              <v-divider
              class="mx-4"
              inset
              vertical
              ></v-divider>
              <v-spacer></v-spacer>
              <v-dialog
              v-model="dialog"
              persistent
              max-width="500px"
              eager
              >
                <template v-slot:activator="{ on, attrs }" class="align-center">
                  <v-btn
                  color="#7879ff"
                  dark
                  class="ml-2"
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
                            label="人员姓名"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-text-field
                            v-model="editedItem.phoneNumber"
                            class="max-length-11-staff-input"
                            label="电话号码"
                            :counter="11"
                            ></v-text-field>
                        </v-col>
                        <!-- <v-col cols="12" sm="6" md="4" >
                            <v-text-field
                                v-model="editedItem.password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :type="show1 ? 'text' : 'password'"
                                label="密码"
                                @click:append="show1 = !show1"
                            ></v-text-field>
                        </v-col> -->
                        <v-col cols="12" sm="6" md="4" >
                            <v-select
                            :menu-props="{ top: false, offsetY: true }"
                            :items="genderItems"
                            item-text="label"
                            item-value="value"
                            v-model="editedItem.gender"
                            label="性別"
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-autocomplete
                              v-model="editedItem.nation"
                              :items="nationItem"
                              label="民族"
                            ></v-autocomplete>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-text-field
                            v-model="editedItem.cardNum"
                            class="max-length-18-staff-input"
                            label="身份证号"
                            :counter="18"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-select
                                :menu-props="{ top: false, offsetY: true }"
                                :items="classSelectionItem"
                                item-text="lessonName"
                                item-value="lessonId"
                                v-model="editedItem.lessonId"
                                @change="selectedLesson"
                                label="班级"
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-text-field
                            v-model="editedItem.imei"
                            label="IMEI"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                            <v-menu
                                ref="menu2"
                                v-model="menu2"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      v-model="editItem.birthday"
                                      label="出生日期"
                                      prepend-icon="mdi-calendar"
                                      readonly
                                      v-bind="attrs"
                                      v-on="on"
                                    ></v-text-field>
                                </template>

                                <v-date-picker
                                ref="picker"
                                v-model="editItem.birthday"
                                :max="new Date().toISOString().substr(0, 10)"
                                min="1950-01-01"
                                locale="zh-cn"
                                @change="selectedBirthday"
                              ></v-date-picker>
                            </v-menu>
                        </v-col>
                      </v-row>
                      <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                    v-model="editedItem.fatherName"
                                    label="家长姓名"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                    v-model="editedItem.fatherPhone"
                                    counter="11"
                                    class="max-length-11-staff-input-father-phone"
                                    label="家长电话"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-select
                                :menu-props="{ top: false, offsetY: true }"
                                :items="fatherJobItem"
                                item-text="label"
                                item-value="value"
                                v-model="editedItem.fatherJob"
                                label="家长身份"
                                ></v-select>
                            </v-col>
                      </v-row>
                      <v-row class=" align-center">
                        <v-col cols="12" md="4" sm="6" class="d-flex justify-center">
                            <v-avatar v-if="editedItem.name !== '' && editedItem.avatar == '/'" color="primary" size="127" tile>
                                <span class="white--text headline">{{editedItem.name[0]}}</span>
                            </v-avatar>
                            <img v-else-if="editedItem.name == '' && editedItem.avatar == '/'" :src="`${baseUrl}/asset/img/icon/anonymous_avatar.png`" alt="UserAvatar" style="width:127px; height: 127px;">
                            <img v-else-if="editedItem.avatar !== '/'" :src="editedItem.avatar" alt="" style="width:127px; height: 127px;">
                        </v-col>
                        <v-col cols="12" md="8" sm="6">
                            <UploadImage @upImgUrl="upImgUrl" @clearedImg="clearedImg" uploadLabel="上传图片" />
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :menu-props="{ top: false, offsetY: true }"
                            :items="madeJsonFromString"
                            item-text="label"
                            v-model="editedItem.familyAddress.province"
                            @change="selectedProvinceOfFamilyAddress(editedItem.familyAddress.province)"
                            label="--省--"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="willBeCityDataOfFamilyAddress"
                            :menu-props="{ top: false, offsetY: true }"
                            item-text="label"
                            v-model="editedItem.familyAddress.city"
                            :disabled="willBeCityDataOfFamilyAddress.length === 0"
                            label="--市--"
                            @change="selectedCityOfFamilyAddress(editedItem.familyAddress.city)"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="willBeRegionDataOfFamilyAddress"
                            :menu-props="{ top: false, offsetY: true }"
                            item-text="label"
                            v-model="editedItem.familyAddress.region"
                            :disabled="willBeRegionDataOfFamilyAddress.length === 0" 
                            @change="selectedRegionOfFamilyAddress(editedItem.familyAddress.region)"
                            label="--区--"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.familyAddress.detail"
                          :disabled="willBeRegionDataOfFamilyAddress.length === 0"
                          label="详細地址"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                          <v-text-field
                          v-model="editedItem.introduce"
                          label="个人介绍"
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
          <template v-slot:[`item.avatar`]="{ item }">
            <img v-if="item.avatar !== '/'" :src="`${baseUrl}${item.avatar}`" alt="ManagerAvatar" class="school-manager-img">
            <v-avatar v-else size="120" color="primary" > 
              <span> {{item.name[0]}} </span>
            </v-avatar>
          </template>
          <template v-slot:[`item.gender`]="{ item }">
            <span v-if="item.gender == 'M'"> 男 </span>
            <span v-else> 女 </span>
          </template>
          <template v-slot:[`item.fatherJob`]="{ item }">
            <span v-if="item.fatherJob == 'farmer'"> 农民 </span>
            <span v-else-if="item.fatherJob == 'worker'"> 工人 </span>
            <span v-else-if="item.fatherJob == 'developer'"> 开发商 </span>
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
import lang from '~/helper/lang.json';
import { mapGetters } from 'vuex'
import cityListJson from '!!raw-loader!../cityLaw.txt';
import UploadImage from '~/components/UploadImage';
import { getSchoolTree } from '~/api/school'
import { createStudent, updateStudent, getStudent, deleteUser } from '~/api/user'

export default {
  components:{
    UploadImage,
    
  },

  data: () => ({
    lang,
    dialog: false,
    dialogDelete: false,
    indroduceDialog : false,
    show1: false,
    rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 8 || 'Min 8 characters',
    },
    headers: [
      { text: '序号', value: 'id', align: 'start', },
      { text: '人员姓名', value: 'name', sortable: false },
      { text: '用户头像', value: 'avatar', sortable: false },
      { text: '电话号码', value: 'phoneNumber' },
      { text: '性別', value: 'gender', sortable: false },
      { text: '民族', value: 'imei', sortable: false },
      { text: '身份证号', value: 'cardNum'},
      { text: '家长姓名', value: 'fatherName', sortable: false },
      { text: '家长电话', value: 'fatherPhone', sortable: false },
      { text: '家长身份', value: 'fatherJob', sortable: false },
      { text: '家庭地址', value: 'familyAddress', sortable: false },
      { text: '操作', value: 'actions', sortable: false },
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
    fatherJobItem:[
        { 
            label : "农民", 
            value : "farmer" 
        },
        { 
            label : "工人", 
            value : "worker" 
        },
        { 
            label : "开发商", 
            value : "developer" 
        },
        
    ],
    date: new Date().toISOString().substr(0, 10),
    menu2 : false,
    schoolManagerData: [],
    schoolManagerListRaw : [],
    editedIndex: -1,
    editedItem: {
        name:'',
        phoneNumber:'',
        // password:'',
        gender:null,
        cardNum : '',
        nation : '',
        familyAddress : {
            province : null,
            city : null, 
            region : null,
            detail : '',
        },
        avatar : '/',
        lessonId : null,
        gradeId : null,
        fatherName : '',
        fatherPhone : '',
        fatherJob : null,
        birthday : '',
        imei : '',
        introduce: ''
    },
      
    defaultItem: {
        name:'',
        phoneNumber:'',
        // password:'',
        gender:null,
        cardNum : '',
        nation : '',
        familyAddress : {
            province : null,
            city : null, 
            region : null,
            detail : '',
        },
        avatar : '/',
        lessonId : null,
        gradeId : null,
        fatherName : '',
        fatherPhone : '',
        fatherJob : null,
        birthday : '',
        imei : '',
        introduce: ''
    },
    provinceListJsonArr:[],
    madeJsonFromString : [],
    willBeCityDataOfFamilyAddress : [],
    willBeRegionDataOfFamilyAddress : [],
    baseUrl:window.Laravel.base_url,
    isCreatingSchool : false,
    isLoadingSchoolData : false,
    isDeleteSchool : false,
    schoolIntroduceData : '',
    schoolId : null,
    managerSchoolData : {},
    classSelectionItem : [],
    nationItem:[
      '汉族',
      '蒙古族',
      '回族',
      '藏族',
      '维吾尔族',
      '苗族',
      '彝族',
      '壮族',
      '布依族',
      '朝鲜族',
      '满族',
      '侗族',
      '瑶族',
      '白族',
      '土家族',
      '哈尼族',
      '哈萨克族',
      '傣族',
      '黎族',
      '傈僳族',
      '佤族',
      '畲族',
      '高山族',
      '拉祜族',
      '水族',
      '东乡族',
      '纳西族',
      '景颇族',
      '柯尔克孜族',
      '土族',
      '达斡尔族',
      '仫佬族',
      '羌族',
      '布朗族',
      '撒拉族',
      '毛南族',
      '仡佬族',
      '锡伯族',
      '阿昌族',
      '普米族',
      '塔吉克族',
      '怒族',
      '乌孜别克族',
      '俄罗斯族',
      '鄂温克族',
      '德昂族',
      '保安族',
      '裕固族',
      '京族',
      '塔塔尔族',
      '独龙族',
      '鄂伦春族',
      '赫哲族',
      '门巴族',
      '珞巴族',
      '基诺族',
      '其他',
      '外国血统中国籍人士'
    ],
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? '新增学生' : '编辑学生'
    },
    currentPath(){
        return this.$route
    },
    ...mapGetters({
        user : 'auth/user'
    }),
  },

  mounted(){
    var ele_11 = $('.max-length-11-staff-input')
    var ele_11_father_phone = $('.max-length-11-staff-input-father-phone')
    var ele_18 = $('.max-length-18-staff-input')
    ele_11.find('input').attr("maxlength","11")
    ele_11_father_phone.find('input').attr("maxlength","11")
    ele_18.find('input').attr("maxlength","18")
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
      getStudent()
      .then((res) => {
        this.schoolManagerData = res.data;
        for(let i = 0 ; i < this.schoolManagerData.length ; i++){
            let clonedVal = Object.assign({}, this.schoolManagerData[i])
            this.schoolManagerListRaw.push(clonedVal); 
            this.schoolManagerData[i].familyAddress = this.convertAddress(this.schoolManagerData[i].familyAddress);
        }
        this.isLoadingSchoolData = false;
      }).catch((err) => {
        //console.log(err);
        this.isLoadingSchoolData = false;
      });
      getSchoolTree()
      .then((res) => {
            res.data.map( x => { 
                if( x.id == this.user.schoolId){
                    this.managerSchoolData = x;
                }
            })
            // classSelectionItem
            this.managerSchoolData.grades.map( grade => {
                let gradeObj = {
                    header : grade.gradeName,
                }
                this.classSelectionItem.push(gradeObj)
                grade.lessons.map( lesson => {
                    let lessonObj = {
                        lessonId : lesson.id,
                        gradeId : grade.id,
                        lessonName : lesson.lessonName,
                    }
                    this.classSelectionItem.push(lessonObj)
                } )
                let dividerObj = {
                    divider : true
                }
                this.classSelectionItem.push(dividerObj)
            })
      }).catch((err) => {
          //console.log(err)
      });
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
      menu2 (val) {
        val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
      },
    },

    methods: {

      editItem (item) {
        let faddress = item.familyAddress.split(" ");
        let findex = this.madeJsonFromString.findIndex(item=>item.label == faddress[0])
        this.willBeCityDataOfFamilyAddress = this.madeJsonFromString[findex].city;
        let fcityIndex = this.willBeCityDataOfFamilyAddress.findIndex(item=>item.label == faddress[1])
        this.willBeRegionDataOfFamilyAddress = this.willBeCityDataOfFamilyAddress[fcityIndex].region
        
        this.editedIndex = this.schoolManagerData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.editedItem.password = ''
        this.editedItem.familyAddress = JSON.parse(this.schoolManagerListRaw[this.editedIndex].familyAddress)
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
        await deleteUser(payload)
        .then((res) => {
          if(res.data.msg == 1){
            this.schoolManagerData.splice(this.editedIndex, 1)
          }
          this.isDeleteSchool = false;
        }).catch((err) => {
          //console.log(err)
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
        //name
        // debugger
        if(this.editedItem.name.trim() == ''){
          return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
        }
        //phone number
        if(this.editedItem.phoneNumber.trim() == ''){
          return this.$snackbar.showMessage({content: this.lang.requireCorrectPhoneNumber, color: "error"})
        }
        if(/^\d*$/.test(this.editedItem.phoneNumber) == false){
          return this.$snackbar.showMessage({content: this.requireCorrectPhoneNumber, color: 'error'});
        }
        if(this.editedItem.phoneNumber.length !== 11 ){
          return this.$snackbar.showMessage({content: this.requireCorrectPhoneNumber, color: 'error'});
        }
        //password
        // if(this.editedItem.password.trim() == ''){
        //   return this.$snackbar.showMessage({content: this.lang.requirePassword, color: "error"})
        // }
        //gender
        if(this.editedItem.gender == null){
          return this.$snackbar.showMessage({content: this.lang.requireGender, color: "error"})
        }
        //nation
        if(this.editedItem.nation == ''){
          return this.$snackbar.showMessage({content: this.lang.requireNation, color: "error"})
        }
        //cardnumber
        if(this.editedItem.cardNum.toString().trim() == ''){
          return this.$snackbar.showMessage({content: this.lang.requireCardNumber, color: "error"})
        }
        if(/^\d*$/.test(this.editedItem.cardNum) == false){
          return this.$snackbar.showMessage({content: this.lang.requireCorrectCardNumber, color: 'error'});
        }
        if(this.editedItem.cardNum.toString().length !== 18 ){
          return this.$snackbar.showMessage({content: this.lang.requireCorrectCardNumber, color: 'error'});
        }
        //lessonId
        if(this.editedItem.lessonId == null){
          return this.$snackbar.showMessage({content: this.lang.requireLessonId, color: "error"})
        }
        //imei
        if(this.editedItem.imei.trim() == ''){
          return this.$snackbar.showMessage({content: this.lang.requireImei, color: "error"})
        }
        //birthday
        if(this.editedItem.birthday.trim() == ''){
          return this.$snackbar.showMessage({content: this.lang.requireBirthday, color: "error"})
        }
        //father infos
        if(this.editedItem.fatherName.trim() == ''){
          return this.$snackbar.showMessage({content: this.lang.requireFatherName, color: "error"})
        }
        if(this.editedItem.fatherJob == null){
          return this.$snackbar.showMessage({content: this.lang.requireFatherJob, color: "error"})
        }
        if(this.editedItem.fatherPhone.trim() == ''){
          return this.$snackbar.showMessage({content: this.lang.requireFatherPhone, color: "error"})
        }
        if(/^\d*$/.test(this.editedItem.fatherPhone) == false){
          return this.$snackbar.showMessage({content: this.lang.requireCorrectPhoneNumber, color: 'error'});
        }
        if(this.editedItem.fatherPhone.length !== 11 ){
          return this.$snackbar.showMessage({content: this.lang.requireCorrectPhoneNumber, color: 'error'});
        }
        //family address
        if(this.editedItem.familyAddress.city == null || 
          this.editedItem.familyAddress.province == null ||
          this.editedItem.familyAddress.region == null ||
          this.editedItem.familyAddress.detail.trim() == '' 
          ){
          return this.$snackbar.showMessage({content: this.lang.requireFamilyAddress, color: "error"})
        }
        //introduce
        if(this.editedItem.introduce.trim() == ''){
          return this.$snackbar.showMessage({content: this.lang.requireIntroduce, color: "error"})
        }
        //update schoolManagerData
        if (this.editedIndex > -1) {
          this.isCreatingSchool = true;
          await updateStudent(this.editedItem)
          .then((res) => {
            this.isCreatingSchool = false;
            if(res.data.msg == 1){
              //update schoolManagerData LAW
              let clonedVal = Object.assign({}, this.editedItem);
              clonedVal.familyAddress = JSON.stringify(clonedVal.familyAddress);
              this.schoolManagerListRaw.push(clonedVal);
              //update schoolManagerData
              this.editedItem.familyAddress = this.convertAddress(JSON.stringify(this.editedItem.familyAddress))
              Object.assign(this.schoolManagerData[this.editedIndex], this.editedItem)
            }
          }).catch((err) => {
            this.isCreatingSchool = false;
            //console.log(err)            
          });
        } 
        //save schoolManagerData
        else {
            this.isCreatingSchool = true;
            await createStudent(this.editedItem)
            .then((res) => {
                //console.log(res.data);
                //console.log("this.schoolManagerListRaw", this.schoolManagerListRaw)
                this.isCreatingSchool = false;
                this.editedItem.id = res.data.id;

                //push data to schoolManagerDataLaw
                let clonedItem = Object.assign({}, this.editedItem);
                clonedItem.familyAddress = JSON.stringify(clonedItem.familyAddress)
                this.schoolManagerListRaw.push(clonedItem);

                //push data to used schoolManagerData
                this.editedItem.familyAddress = this.convertAddress(JSON.stringify(this.editedItem.familyAddress))
                this.schoolManagerData.push(this.editedItem);
            }).catch((err) => {
                //console.log(err)
                this.isCreatingSchool = false;
            });
        }
        this.close()
      },

        selectedProvinceOfFamilyAddress(val){
            for( let i = 0 ; i < this.madeJsonFromString.length ; i++){
                if( val == this.madeJsonFromString[i].value ){
                    this.willBeCityDataOfFamilyAddress = this.madeJsonFromString[i].city;
                    this.editedItem.familyAddress.city = null;
                    this.willBeRegionDataOfFamilyAddress = [];
                    this.editedItem.familyAddress.region = null;
                }
            }
            
        },
        selectedCityOfFamilyAddress(val){
            if (val != undefined){
                for( let i = 0 ; i < this.willBeCityDataOfFamilyAddress.length ; i++){
                    if( val == this.willBeCityDataOfFamilyAddress[i].value){
                        this.willBeRegionDataOfFamilyAddress = this.willBeCityDataOfFamilyAddress[i].region;
                    }
                }
            }
        },
        selectedRegionOfFamilyAddress(val){

        },

      upImgUrl(value) {
        this.editedItem.avatar = value;
        //console.log(this.editedItem.avatar);
      },
      clearedImg(){
        this.editedItem.avatar = '/'
        //console.log(this.editedItem.avatar);
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

        selectedLesson(val){
            this.editedItem.lessonId = val;
            this.classSelectionItem.map( x => {
                if( val == x.lessonId){
                    this.editedItem.gradeId = x.gradeId;
                }
            } )
        },

        selectedBirthday(val){
            this.$refs.menu2.save(val)
            this.editedItem.birthday = val;
        }
    },
  }
</script>
<style>

</style>