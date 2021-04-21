<template>
  <v-container>
    <v-row class="justify-center align-center z-index-2 banner-custom position-relative">
        <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
            mdi-chevron-left
        </v-icon>
        <h2 class="py-7">{{lang.regname}}</h2>
    </v-row>
    <v-row class="pl-10 pt-0">
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
    <v-divider light></v-divider>
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
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
import {getAnswerList, } from '~/api/regname'
import AttachItemViewer from '~/components/attachItemViewer';
  export default {
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
        ]
    }),

    components:{
        AttachItemViewer,
    },

    computed: {
        ...mapGetters({
            contentData: 'content/postDetail',
            user: 'auth/user'
        }),
    },

    watch: {
    },

    async created () {
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
            }).catch((err) => {
                console.log(err)
            });
        }
    },

    methods: {
      allowItem(item){
        console.log('allow',item)
      },
      denyItem(item){
        console.log('deny',item)
      }
    },
  }
</script>
<style>

</style>