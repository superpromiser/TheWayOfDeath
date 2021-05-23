<template>
  <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()" >
    <v-container class="pt-0 px-0 h-100 bg-white pt-12">
      <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
        <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
          mdi-chevron-left
        </v-icon>
        <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.regname}}</p>
      </v-row>
      <div class="cus-divider-light-gray-height"></div>
      <v-row class="ma-0">
        <v-col cols="12" class="d-flex">
          <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="#7879ff" size="48">
              <span class="white--text headline">{{contentData.users.name[0]}}</span>
          </v-avatar>
          <v-avatar v-else
            size="48"
          >
            <v-img :src="contentData.users.avatar"></v-img>
          </v-avatar>
          <div class="ml-2 d-flex flex-column">
            <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.questionnaire}}  </p>
            <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(contentData.created_at)}}  </span> {{contentData.users.name}}</p>
          </div>
        </v-col>
      </v-row>
      <v-row class="ma-0">
          <v-col cols="12" class="text-center">
              <h1>{{regNameData.title}}</h1>
          </v-col>
          <v-col cols="12" >
              <p class="text-wrap">{{regNameData.content[0].text}}</p>
          </v-col>
          <v-col cols="12" v-if="checkIfAttachExist(regNameData.content[0])">
              <AttachItemViewer :items="regNameData.content[0]" />
          </v-col>
      </v-row>
      <div class="cus-divider-light-gray-height"></div>
      <v-row class="ma-0">
        <v-col cols="12">
          <v-data-table
            :headers="headers"
            :items="answerDataList"
            sort-by="calories"
            class="elevation-1"
          >
            <!-- <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>My CRUD</v-toolbar-title>
                  <v-divider class="mx-4" inset vertical></v-divider>
                  <v-spacer></v-spacer>
                  <v-btn>something</v-btn>
              </v-toolbar>
            </template> -->
            <template v-slot:[`item.avatar`]="{ item }">
              <img v-if="item.avatar !== '/'" :src="`${baseUrl}${item.avatar}`" alt="ManagerAvatar" class="school-manager-img">
              <v-avatar v-else size="120" color="#7879ff" > 
                <span> {{item.name[0]}} </span>
              </v-avatar>
            </template>
            <template v-slot:[`item.phoneNumber`]="{ item }">
              {{pnEncrypt(item.phoneNumber)}}
            </template>
            <template v-slot:[`item.familyAddress`]="{ item }">
              {{convertAddress(item.familyAddress)}}
            </template>
            <template v-slot:[`item.fatherPhone`]="{ item }">
              {{pnEncrypt(item.fatherPhone)}}
            </template>
            <template v-slot:[`item.birthday`]="{ item }">
              {{TimeViewYMD(item.birthday)}}
            </template>
            <template v-slot:[`item.status`]="{ item }">
              <v-chip small v-if="item.status == 'deny'" class="ma-2" color="#eb5846" label text-color="white" >
                <v-icon left> mdi-cancel </v-icon> 拒绝
              </v-chip>
              <v-chip small v-else-if="item.status == 'allow'" class="ma-2" color="#49d29e"  label text-color="white" >
                <v-icon left> mdi-hand   </v-icon> 允许
              </v-chip>
              <v-chip small v-else-if="item.status == 'pending'" class="ma-2" color="#feb31a"  label text-color="white" >
                <v-icon left> mdi-clock-outline   </v-icon> 待办的
              </v-chip>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-tooltip bottom v-if="regNameData.checkFlag == 1 && (item.status == 'pending' || item.status == 'allow')">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="denyItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-cancel
                        </v-icon>
                    </template>
                    <span>否定</span>
                </v-tooltip>
                <v-tooltip bottom v-if="regNameData.checkFlag == 1 && (item.status == 'pending' || item.status == 'deny')">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="allowItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-hand
                        </v-icon>
                    </template>
                    <span>允许</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="deleteItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                    <span>删除</span>
                </v-tooltip>
            </template>
            <template v-slot:no-data>
              没有数据
            </template>
          </v-data-table>
          <!-- <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th v-for="(name,index) in regNameData.inputTypeList" :key="index">
                    {{name}}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(answer, answerIdx) in answerDataList" :key="answerIdx">
                  <td v-for="(item, itemIdx) in answer" :key="itemIdx">
                    {{item}}
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table> -->
        </v-col>
      </v-row>
      <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'"   persistent v-model="dialogDelete" max-width="500px">
        <v-card>
          <v-card-title class="headline">{{lang.confirmSentence}}</v-card-title>
          <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDelete">{{lang.cancel}}</v-btn>
          <v-btn color="blue darken-1" text @click="deleteItemConfirm" :loading="isDeleteAnswer">{{lang.ok}}</v-btn>
          <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
      <CommentView></CommentView>
    </v-container>
  </v-container>
  <v-container v-else>
    <v-row class="justify-center align-center z-index-2 banner-custom">
        <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
            mdi-chevron-left
        </v-icon>
        <h2 class="py-7">{{lang.regname}}</h2>
    </v-row>
    <div v-if="isLoadingContents == true" class="d-flex justify-center align-center py-16">
      <v-progress-circular
          indeterminate
          color="#7879ff"
      ></v-progress-circular>
    </div>
    <div v-else>
      <v-col cols="12" class="d-flex align-center hover-cursor-point">
        <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="#7879ff" size="60" class="ma-5">
              <span class="white--text headline">{{contentData.users.name[0]}}</span>
          </v-avatar>
          <v-avatar v-else
            class="ma-5"
            size="60"
          >
            <v-img :src="contentData.users.avatar"></v-img>
          </v-avatar>
        <div>
          <p class="font-weight-black fs-15 mb-3"> {{lang.regname}}  </p>
          <div class="d-flex align-center">
            <v-icon medium color="#7879ff" class="mr-2">mdi-clock-outline </v-icon>
            <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
            <v-icon medium color="#7879ff" class="mr-2">mdi-account </v-icon>
            <p class="mb-0">{{contentData.users.name}}</p>
          </div>
        </div>
        <div class="ml-auto mr-5">
          <v-menu offset-y >
            <template v-slot:activator="{ attrs, on }">
              <v-btn icon color="#7879ff" v-bind="attrs" v-on="on" >
                <v-icon size="30">mdi-chevron-down </v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item link >
                <v-list-item-title class="px-2" @click="fixTop(contentData)" v-if="contentData.fixTop == null">{{lang.toTop}}</v-list-item-title>
                <v-list-item-title class="px-2" @click="relaseTop(contentData.id)" v-else>{{lang.toRelase}}</v-list-item-title>
              </v-list-item>
              <v-list-item link >
                <v-list-item-title class="px-2" @click="postRemove(contentData)">{{lang.remove}}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </div>
      </v-col>
      <v-row class="pa-10">
          <v-col cols="12" class="text-center">
              <h1>{{regNameData.title}}</h1>
          </v-col>
          <v-col cols="12" >
              <p class="text-wrap">{{regNameData.content[0].text}}</p>
          </v-col>
          <v-col cols="12" v-if="checkIfAttachExist(regNameData.content[0])">
              <AttachItemViewer :items="regNameData.content[0]" />
          </v-col>
      </v-row>
      <div class="px-10">
        <v-divider light></v-divider>  
      </div>
      
      <v-row class="ma-0">
        <v-col cols="12" class="px-10">
          <v-data-table
            :headers="headers"
            :items="answerDataList"
            sort-by="calories"
            class="elevation-1"
          >
            <!-- <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>My CRUD</v-toolbar-title>
                  <v-divider class="mx-4" inset vertical></v-divider>
                  <v-spacer></v-spacer>
                  <v-btn>something</v-btn>
              </v-toolbar>
            </template> -->
            <template v-slot:[`item.avatar`]="{ item }">
              <img v-if="item.avatar !== '/'" :src="`${baseUrl}${item.avatar}`" alt="ManagerAvatar" class="reg-name-student-img">
              <v-avatar v-else size="60" color="#7879ff" > 
                <span> {{item.name[0]}} </span>
              </v-avatar>
            </template>
            <template v-slot:[`item.phoneNumber`]="{ item }">
              {{pnEncrypt(item.phoneNumber)}}
            </template>
            <template v-slot:[`item.familyAddress`]="{ item }">
              {{convertAddress(item.familyAddress)}}
            </template>
            <template v-slot:[`item.fatherPhone`]="{ item }">
              {{pnEncrypt(item.fatherPhone)}}
            </template>
            <template v-slot:[`item.birthday`]="{ item }">
              {{TimeViewYMD(item.birthday)}}
            </template>
            <template v-slot:[`item.gender`]="{ item }">
              {{transGender(item.gender)}}
            </template>
            <template v-slot:[`item.status`]="{ item }">
              <v-chip small v-if="item.status == 'deny'" class="ma-2" color="#eb5846" label text-color="white" >
                <v-icon left> mdi-cancel </v-icon> 拒绝
              </v-chip>
              <v-chip small v-else-if="item.status == 'allow'" class="ma-2" color="#49d29e"  label text-color="white" >
                <v-icon left> mdi-hand   </v-icon> 允许
              </v-chip>
              <v-chip small v-else-if="item.status == 'pending'" class="ma-2" color="#feb31a"  label text-color="white" >
                <v-icon left> mdi-clock-outline   </v-icon> 待办的
              </v-chip>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-tooltip bottom v-if="regNameData.checkFlag == 1 && (item.status == 'pending' || item.status == 'allow')">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="denyItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-cancel
                        </v-icon>
                    </template>
                    <span>否定</span>
                </v-tooltip>
                <v-tooltip bottom v-if="regNameData.checkFlag == 1 && (item.status == 'pending' || item.status == 'deny')">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="allowItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-hand
                        </v-icon>
                    </template>
                    <span>允许</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="deleteItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                    <span>删除</span>
                </v-tooltip>
            </template>
            <template v-slot:no-data>
              没有数据
            </template>
          </v-data-table>
          <!-- <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th v-for="(name,index) in regNameData.inputTypeList" :key="index">
                    {{name}}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(answer, answerIdx) in answerDataList" :key="answerIdx">
                  <td v-for="(item, itemIdx) in answer" :key="itemIdx">
                    {{item}}
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table> -->
        </v-col>
      </v-row>
      <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
      <CommentView></CommentView>
    </div>
    <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'"   persistent v-model="dialogDelete" max-width="500px">
      <v-card>
        <v-card-title class="headline">{{lang.confirmSentence}}</v-card-title>
        <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="closeDelete">{{lang.cancel}}</v-btn>
        <v-btn color="blue darken-1" text @click="deleteItemConfirm" :loading="isDeleteAnswer">{{lang.ok}}</v-btn>
        <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import cityListJson from '!!raw-loader!../../cityLaw.txt';
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
import {getAnswerList, updateStatus, deleteAnswer} from '~/api/regname'
import AttachItemViewer from '~/components/attachItemViewer';
import FooterPost from '~/components/contents/footerPost'
import CommentView from '~/pages/school/posts/comments/commentView';
  export default {
    components:{
      AttachItemViewer,
      FooterPost,
      CommentView
    },
    data: () => ({
        lang,
        dialog: false,
        regNameData: null,
        desserts: [
            
        ],
        baseUrl:window.Laravel.base_url,
        headers: [],
        answerDataList:[],
        provinceListJsonArr:[],
        madeJsonFromString : [],
        inputTypeItem:[
            {
                label: "姓名",
                value: "name"
            },
            {
                label: "头像",
                value: "avatar"
            },
            {
                label: "性别",
                value: "gender"
            },
            {
                label: "手机号码",
                value: "phoneNumber"
            },
            {
                label: "民族",
                value: "nation"
            },
            {
                label: "出生日期",
                value: "birthday"
            },
            {
                label: "家庭地址",
                value: "familyAddress"
            },
            {
                label: "身份证号",
                value: "cardNum"
            },
            {
                label: "父亲姓名",
                value: "fatherName"
            },
            {
                label: "父亲联系方式",
                value: "fatherPhone"
            },
            {
                label: "父亲工作单位",
                value: "fatherJob"
            },
        ],
        isLoadingContents:false,
        isDeleteAnswer: false,
        dialogDelete: false,
        deleteAnswerItem: null,
    }),
    computed: {
        ...mapGetters({
            contentData: 'content/postDetail',
            user: 'auth/user'
        }),
    },

    watch: {
    },

    async created () {
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
        this.isLoadingContents = true
        if(this.contentData == null){
            this.$router.push({name: 'schoolSpace.news'});
        }
        else{
            console.log("^^^", this.contentData);
            this.regNameData = this.contentData.regnames;
            this.regNameData.content = JSON.parse(this.regNameData.content);
            this.regNameData.inputTypeList = JSON.parse(this.regNameData.inputTypeList);
            this.regNameData.viewList = JSON.parse(this.regNameData.viewList);
            this.regNameData.inputTypeList.map(x=>{
              this.inputTypeItem.map( y=> {
                if( y.value == x){
                  let headerItem = {
                    text : y.label,
                    value : x,
                    sortable: false
                  }
                  this.headers.push(headerItem);
                }
              } )
            })
            let statusItem = {text: '审批状态', value: 'status', sortable: false}
            let actionItem = { text: '操作', value: 'actions', sortable: false }
            this.headers.push(statusItem)
            this.headers.push(actionItem)

            let payload = {
                id: this.regNameData.id
            }

            await getAnswerList(payload)
            .then((res) => {
                console.log("##################", res);
                res.data.answer.map(item=>{
                  item.answer = JSON.parse(item.answer);
                  item = {...item, ...item.answer}
                  this.answerDataList.push((item))
                })
                console.log("this.answerDataList", this.answerDataList);
                this.isLoadingContents = false
            }).catch((err) => {
                console.log(err)
                this.isLoadingContents = false
            });
        }
    },

    methods: {
      allowItem(item){
        this.updateStatus('allow', item);
      },
      denyItem(item){
        this.updateStatus('deny', item);
      },
      deleteItem(item){
        this.deleteAnswerItem = item;
        this.dialogDelete = true;
      },
      closeDelete(){
        this.deleteAnswerItem = null;
        this.dialogDelete = false;
      },
      async deleteItemConfirm(){
        let payload = {
          answerId: this.deleteAnswerItem.id
        }
        this.isDeleteAnswer = true;
        await deleteAnswer(payload)
        .then((res) => {
          this.answerDataList.map((answer, index) => {
            if(answer.id == this.deleteAnswerItem.id){
              this.answerDataList.splice(index, 1)
            }
          })
          this.isDeleteAnswer = false;
          this.dialogDelete = false;
          this.deleteAnswerItem = null;
        }).catch((err) => {
          this.isDeleteAnswer = false;
          this.dialogDelete = false;
          this.deleteAnswerItem = null;
        });
        this.isDeleteAnswer = false;
      },

      updateStatus(actionType, item){
        let payload = {
          action: actionType,
          answerId: item.id
        }
        updateStatus(payload)
        .then((res) => {
        }).catch((err) => {
        });
        item.status = actionType;
      },
      
      updateFooterInfo(){

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