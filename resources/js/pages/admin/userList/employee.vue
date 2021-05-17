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
              <v-toolbar-title><strong>员工名单</strong></v-toolbar-title>
              <v-divider
              class="mx-4"
              inset
              vertical
              ></v-divider>
              <v-spacer></v-spacer>
              <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
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
              <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'"  persistent v-model="dialogDelete" max-width="500px">
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
              <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
                persistent
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
          <template v-slot:[`item.id`]="{ item }">
              {{schoolManagerData.indexOf(item)+1}}
          </template>
          <template v-slot:no-data>
            <p>暂无</p>
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
import { createEmployee, updateEmployee, getEmployeeList, deleteUser } from '~/api/user'

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
      { text: '民族', value: 'nation', sortable: false },
      { text: '身份证号', value: 'cardNum'},
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
        avatar : '/'
    },
      
    defaultItem: {
        name:'',
        phoneNumber:'',
        // password:'',
        gender:null,
        cardNum : '',
        nation : '',
        avatar : '/',
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
      
      this.isLoadingSchoolData = true;
      getEmployeeList()
      .then((res) => {
        console.log('employee list===',res.data)
        this.schoolManagerData = res.data;
        this.isLoadingSchoolData = false;
      }).catch((err) => {
        //console.log(err);
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
      menu2 (val) {
        val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
      },
    },

    methods: {

      editItem (item) {
        
        this.editedIndex = this.schoolManagerData.indexOf(item)
        this.editedItem = Object.assign({}, item)
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
        
        //update schoolManagerData
        if (this.editedIndex > -1) {
          this.isCreatingSchool = true;
          await updateEmployee(this.editedItem)
          .then((res) => {
            this.isCreatingSchool = false;
            if(res.data.msg == 1){
              //update schoolManagerData LAW
              
            }
          }).catch((err) => {
            this.isCreatingSchool = false;
            //console.log(err)            
          });
        } 
        //save schoolManagerData
        else {
            this.isCreatingSchool = true;
            await createEmployee(this.editedItem)
            .then((res) => {
                //console.log(res.data);
                //console.log("this.schoolManagerListRaw", this.schoolManagerListRaw)
                this.isCreatingSchool = false;
                this.editedItem.id = res.data.id;

                //push data to schoolManagerDataLaw
                this.schoolManagerData.push(this.editedItem);
            }).catch((err) => {
                //console.log(err)
                this.isCreatingSchool = false;
            });
        }
        this.close()
      },


      upImgUrl(value) {
        this.editedItem.avatar = value;
        //console.log(this.editedItem.avatar);
      },
      clearedImg(){
        this.editedItem.avatar = '/'
        //console.log(this.editedItem.avatar);
      },
    },
  }
</script>
<style>

</style>