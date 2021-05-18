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
          <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="primary" size="48">
              <span class="white--text headline">{{contentData.users.name[0]}}</span>
          </v-avatar>
          <v-avatar v-else
            size="48"
          >
            <v-img :src="contentData.users.avatar"></v-img>
          </v-avatar>
          <div class="ml-2 d-flex flex-column">
            <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.questionnaire}}  </p>
            <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(contentData.created_at)}} 转发</span> {{contentData.users.name}}</p>
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
              <v-avatar v-else size="120" color="primary" > 
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
            <!-- <template v-slot:[`item.birthday`]="{ item }">
              {{TimeViewYMD(item.familyAddress)}}
            </template> -->
            <template v-slot:[`item.gender`]="{ item }">
              {{transGender(item.gender)}}
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="allowItem(item)"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="denyItem(item)"
                >
                    mdi-delete
                </v-icon>
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
          color="primary"
      ></v-progress-circular>
    </div>
    <div v-else>
      <v-col cols="12" class="d-flex align-center hover-cursor-point">
        <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="primary" size="60" class="ma-5">
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
            <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
            <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
            <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
            <p class="mb-0">{{contentData.users.name}}</p>
          </div>
        </div>
        <div class="ml-auto mr-5">
          <v-menu offset-y >
            <template v-slot:activator="{ attrs, on }">
              <v-btn icon color="primary" v-bind="attrs" v-on="on" >
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
              <img v-if="item.avatar !== '/'" :src="`${baseUrl}${item.avatar}`" alt="ManagerAvatar" class="school-manager-img">
              <v-avatar v-else size="120" color="primary" > 
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
            <!-- <template v-slot:[`item.birthday`]="{ item }">
              {{TimeViewYMD(item.familyAddress)}}
            </template> -->
            <template v-slot:[`item.gender`]="{ item }">
              {{transGender(item.gender)}}
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="allowItem(item)"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="denyItem(item)"
                >
                    mdi-delete
                </v-icon>
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
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
import {getAnswerList, } from '~/api/regname'
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
            let actionItem = { text: '操作', value: 'actions', sortable: false }
            this.headers.push(actionItem)

            let payload = {
                id: this.regNameData.id
            }

            await getAnswerList(payload)
            .then((res) => {
                res.data.answer.map(item=>{
                  this.answerDataList.push(JSON.parse(item.answer))
                })
                this.isLoadingContents = false
            }).catch((err) => {
                console.log(err)
                this.isLoadingContents = false
            });
        }
    },

    methods: {
      allowItem(item){
        console.log('allow',item)
      },
      denyItem(item){
        console.log('deny',item)
      },
      updateFooterInfo(){

      }
    },
  }
</script>
<style>

</style>