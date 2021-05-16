<template>
    <v-container class="pa-0">
        <div v-if="isPosting == true">
            <v-container class="px-10 z-index-2 banner-custom">
                <v-row>
                    <v-col cols="6" md="4" class="d-flex align-center position-relative">
                        <a @click="$router.go(-1)">
                            <v-icon size="70" class="left-24p">
                                mdi-chevron-left
                            </v-icon>
                        </a>
                    </v-col>
                    <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                        <h2>{{lang.announcement}}</h2>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex align-center justify-end">
                        <v-btn
                            text
                            color="#999999"
                            @click="templateList"
                        >
                            可用模板 {{templateCnt}}， 草稿 {{draftCnt}}
                        </v-btn>
                        
                        <v-btn
                            tile
                            dark
                            color="#F19861"
                            :loading="isDraft"
                            @click="saveDraft"
                        >
                            {{lang.saveDraft}}
                        </v-btn>
                        <v-btn
                            dark
                            color="#7879ff"
                            @click="publishcampusData"
                            tile
                            class="mx-2"
                            :loading="isCreating"
                        >
                            提交
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
            <v-container class="pa-10">
                <v-row>
                    <v-col cols="12" sm="6" md="4">
                        <v-text-field
                            solo
                            v-model="announcementData.title"
                            label="公告标题"
                            hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-dialog
                            persistent
                            v-model="chooseSignNameDialog"
                            max-width="500px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    solo
                                    v-model="announcementData.signName"
                                    label="落款名称"
                                    hide-details
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-card >
                                <v-card-title>落款名称</v-card-title>
                                <v-list>
                                    <v-list-item-group
                                        v-model="indexOfSignName"
                                        mandatory
                                        color="indigo"
                                    >
                                        <v-list-item >
                                            <v-list-item-icon>
                                                <v-icon > mdi-account</v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content>
                                                <v-list-item-title> {{user.name}}</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-divider></v-divider>
                                        <v-list-item v-for="(item, i) in signNameItems" :key="i">
                                            <v-list-item-icon>
                                                <v-icon v-text="item.icon"></v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content>
                                                <v-list-item-title v-text="item.text"></v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item @click="newSignFlag = !newSignFlag">
                                            <v-list-item-icon>
                                                <v-icon>
                                                    mdi-plus
                                                </v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title v-text="lang.addOption"></v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item v-if="newSignFlag" class="text-right">
                                            <v-text-field
                                                v-model="newSignName"
                                                solo
                                                label="公告标题"
                                            ></v-text-field>
                                            <v-btn
                                                color="deep-purple lighten-2"
                                                text
                                                @click="addNewName"
                                            >
                                                {{lang.ok}}
                                            </v-btn>
                                        </v-list-item>
                                    </v-list-item-group>
                                </v-list>
                                <v-card-actions>
                                    <v-btn
                                        color="deep-purple lighten-2"
                                        text
                                        @click="chooseSignName"
                                    >
                                        {{lang.ok}}
                                    </v-btn>

                                    <v-btn
                                        color="deep-purple lighten-2"
                                        text
                                        @click="closeChooseSignNameDialog"
                                    >
                                        {{lang.cancel}}
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-col>
                    <!-- <v-col cols="12" sm="6" md="4">
                        <v-select
                            solo
                            multiple
                            chips
                            :menu-props="{ top: false, offsetY: true }"
                            :items="returnSchoolTree(currentPath.params.schoolId)"
                            item-text="lessonName"
                            item-value="lessonId"
                            @change="selectedLesson"
                            label="展示范围"
                            hide-details
                        ></v-select>
                    </v-col> -->
                    <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                        <span>签名反馈</span>
                        <v-switch
                            v-model="announcementData.scopeFlag"
                            color="primary"
                            hide-details
                            inset
                            class="pt-0 mt-0"
                        ></v-switch>
                    </v-col>
                    <v-col cols="12">
                        <QuestionItem Label="分享内容" :emoji="true" :item="announcementData.content[0]" ref="child" @contentData="loadContentData"></QuestionItem>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="8" md="10"></v-col>
                    <v-col cols="4" class="justify-end" md="2">
                        <v-select
                            :items='viewList'
                            item-text="label"
                            item-value="value"
                            v-model="viewType"
                            @change="selViewList"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import QuestionItem from '~/components/questionItem'
import UploadImage from '~/components/UploadImage'
import lang from '~/helper/lang.json'
import { VueEditor } from "vue2-editor";


import {createAnouncement,getLessonUsers} from '~/api/anouncement'

export default {
    middleware:['post','auth'],
    components: {
        VueEditor,
        QuestionItem,
        UploadImage,
    },

    watch: {
      chooseSignNameDialog (val) {
        val || this.closeChooseSignNameDialog()
      },
      currentPath:{
            handler(val){
                if(val.name == 'posts.Cannouncement'){
                    this.isPosting = true
                }
                if(val.query.tempData){
                    this.isPosting = true
                    console.log("JSON.parse(val.query.tempData)",JSON.parse(val.query.tempData))
                    this.announcementData.content = JSON.parse(val.query.tempData)
                }
            },
            deeper:true
        }
    },

    data: () => ({
        lang,
        menu: false,
        requiredText:false,
        chooseSignNameDialog: false,
        baseUrl: window.Laravel.base_url,
        indexOfSignName: 0,
        signNameItems : [
        ],
        announcementData:{
            title:'',
            signName:'',
            showList:[],
            scopeFlag:false,
            content:[],
            schoolId:null,
            lessonId:null,
        },
        newSignFlag:false,
        newSignName:'',
        isCreating:false,
        isDraft:false,
        viewList:[
            {
                label:'公开',
                value:'pub'
            },
            {
                label:'私密',
                value:'prv'
            },
            {
                label:'部分可见',
                value:'spec'
            },
        ],
        viewType:'pub',
        userList:[],
        isPosting:false,
        templateCnt:0,
        draftCnt:0,

    }),

    computed: {
       ...mapGetters({
           user: 'auth/user',
       }),
        currentPath(){
            return this.$route
        }
    },

    created() {
        this.announcementData.schoolId = this.currentPath.params.schoolId
        this.announcementData.lessonId = this.currentPath.params.lessonId
        if(this.currentPath.name == 'posts.Cannouncement'){
            this.isPosting = true
        }
        getLessonUsers({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            res.data.map(data=>{
                this.$set(data,'isChecked',false)
            })
            this.userList = res.data
            console.log(this.userList)
        })
    },

    methods: {
        selectedLesson(val){
            //console.log(val)
        },  
        saveDraft(){

        },
        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true
                this.announcementData.content = []
                return;
            }
            this.announcementData.content.push(data);
        },

        upImgUrl(value) {
            this.announcementData.imgUrl = value;
            //console.log(this.announcementData.imgUrl);
        },
        clearedImg(){
            this.announcementData.imgUrl = ''
            //console.log(this.announcementData.imgUrl);
        },

        async publishcampusData(){
            this.$refs.child.emitData()
            if(this.viewType == 'pub'){
                this.announcementData.showList = null
            }else if(this.viewType == 'prv'){
                this.announcementData.showList = []
                this.announcementData.showList.push(this.user.id)
            }else{
                this.announcementData.showList = []
                this.userList.map(user=>{
                    if(user.isChecked == true){
                        this.announcementData.showList.push(user.id)
                    }
                })
            }
            
            // console.log(this.announcementData)
            // return
            if(this.announcementData.content.length == 0){
                    return this.$snackbar.showMessage({content: this.lang.announcement+this.lang.requireContent, color: "error"})
                }
            if(this.announcementData.title.trim() == ''){
                    return this.$snackbar.showMessage({content: this.lang.announcement+this.lang.requireTitle, color: "error"})
            }
            // if(this.announcementData.viewList.length == 0){
            //         return this.$snackbar.showMessage({content: this.lang.announcement+this.lang.requireMember, color: "error"})
            // }
            this.isCreating = true
            //console.log("announcementData", this.announcementData);
            await createAnouncement(this.announcementData).then(res=>{
                //console.log(res)
                this.$router.push({name:'classSpace.news'})
            }).catch(err=>{
                this.isCreating = false
                //console.log(err.response)
            })
            
        },
        closeChooseSignNameDialog () {
            this.chooseSignNameDialog = false
        },

        chooseSignName(){
            if(this.indexOfSignName == 0){
                this.announcementData.signName = this.user.name;
            }
            else{
                this.announcementData.signName = this.signNameItems[this.indexOfSignName - 2].text;
            }
            this.chooseSignNameDialog = false
        },
        selectedLesson(val){
            this.announcementData.viewList = val;
        },
        addNewName(){
            this.newSignFlag = false;
            this.signNameItems.push({
                icon: 'mdi-account-group-outline',
                text:this.newSignName
            })
            //console.log(this.signNameItems)
        },
        selViewList(){
            console.log(this.viewType)
        },
        templateList(){
            this.isPosting = false
            this.$router.push({name:'Cannouncement.templateList'})
        }
    }
}
</script>

<style>

</style>