<template>
<v-container v-if="$isMobile()" class="pa-0">
        <v-container v-if="isPosting == true" class="pa-0 h-100 bg-white mb-16 pb-3" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="navToBackCustom" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.announcement}}</p>
                <v-btn @click="publishcampusData" :loading="isCreating" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0 mo-glow bg-white">
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        color="#7879ff"
                        v-model="announcementData.title"
                        label="公告标题"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
                            persistent
                            v-model="chooseSignNameDialog"
                            max-width="500px"
                             
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    color="#7879ff"
                                    v-model="announcementData.signName"
                                    label="落款名称"
                                    hide-details
                                    class="mt-0 pt-0"
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
                                        <v-list-item v-if="newSignFlag">
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
                                <v-card-actions class="justify-end">
                                    <v-btn
                                        color="deep-purple lighten-2"
                                        text
                                        @click="closeChooseSignNameDialog"
                                    >
                                        {{lang.cancel}}
                                    </v-btn>

                                    <v-btn
                                        color="deep-purple lighten-2"
                                        text
                                        @click="chooseSignName"
                                    >
                                        {{lang.ok}}
                                    </v-btn>

                                </v-card-actions>
                            </v-card>
                    </v-dialog>
                </v-col>
                <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-between">
                    <span>签名反馈</span>
                    <v-switch
                        v-model="announcementData.scopeFlag"
                        color="#7879ff"
                        hide-details
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
            </v-row>
            <QuestionItem Label="" :emoji="true" :isAnnouncement="true" :isShareView="true" :item="announcementData.content[0]" ref="child" @contentData="loadContentData"></QuestionItem>
            <v-btn @click="templateList" rounded color="#E0E0E0" small elevation="0" class="position-absolute font-color-gray-dark-btn" style="bottom: 54px; left: 12px;"> <v-icon left>mdi-buffer</v-icon>模板</v-btn>
            <v-menu top offset-y :close-on-content-click="true" :content-class="publishSpecUserList !== null&&publishSpecUserList.length > 0 ? 'box-shadow-none publish-type-menu-with-btn': 'box-shadow-none publish-type-menu'" tile min-width="90">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn v-bind="attrs" v-on="on" rounded color="#E0E0E0" small elevation="0" class="position-absolute font-color-gray-dark-btn" style="bottom: 54px; right: 12px;"> <v-icon left>mdi-earth</v-icon>
                        {{announcementData.publishType=="pub"? '公开' : announcementData.publishType=="pvt"? '私密' : publishSpecUserList == null ? '部分看见' : `部分看见(${publishSpecUserList.length})`}}
                    </v-btn>
                </template>
                <div class="pa-3 text-right">
                    <v-radio-group class="mt-0 pt-0" v-model="announcementData.publishType" @change="selectPublishType" mandatory dense hide-details >
                        <v-radio name="announcementData.publishType" color="#7879ff" label="公开" value="pub" ></v-radio>
                        <v-radio name="announcementData.publishType" color="#7879ff" label="私密" value="pvt" ></v-radio>
                        <v-radio name="announcementData.publishType" color="#7879ff" label="部分看见" value="spec" ></v-radio>
                    </v-radio-group>
                    <v-btn v-if="publishSpecUserList !== null&&publishSpecUserList.length > 0" elevation="0" small text color="#7879ff" @click="changeSelectedUserList">重选名单</v-btn>
                </div>
            </v-menu>
        </v-container>
        <v-container class="pa-0 ma-0" v-else>
            <router-view></router-view>
        </v-container>
    </v-container>
    <v-container v-else class="pa-0">
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
                        <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
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
                                        <v-list-item v-if="newSignFlag" class="justify-end">
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
                                <v-card-actions class="justify-end">
                                   
                                    <v-btn
                                        color="deep-purple lighten-2"
                                        text
                                        @click="closeChooseSignNameDialog"
                                    >
                                        {{lang.cancel}}
                                    </v-btn>
                                     <v-btn
                                        color="deep-purple lighten-2"
                                        text
                                        @click="chooseSignName"
                                    >
                                        {{lang.ok}}
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
                            v-model="announcementData.publishType"
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


import {createAnouncement,getTemplateCnt,createTemplate} from '~/api/anouncement'

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
            content:[
                {
                    text:'',
                    imgUrl:[],
                    otherUrl:[],
                    videoUrl:[]
                },
            ],
            schoolId:null,
            lessonId:null,
            publishType:'pub'
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
                value:'pvt'
            },
            {
                label:'部分可见',
                value:'spec'
            },
        ],
        userList:[],
        isPosting:false,
        templateCnt:0,
        draftCnt:0,

    }),

    computed: {
       ...mapGetters({
            user: 'auth/user',
            publishContent: 'mo/publishContent',
            publishSpecUserList: 'mo/publishSpecUserList',
            backWithoutSelect: 'mo/backWithoutSelect',
            backWithChange: 'mo/backWithChange',
            clickedChange: 'mo/clickedChange',
            specUsers:'member/specUsers',
       }),
        currentPath(){
            return this.$route
        }
    },

    created() {
        this.announcementData.schoolId = this.currentPath.params.schoolId
        this.announcementData.lessonId = this.currentPath.params.lessonId

        if(this.publishContent !== null){
            this.announcementData = this.publishContent;
        }
        if(this.backWithoutSelect == true){
            this.announcementData.publishType = 'pub';
        }
        if(this.currentPath.name == 'posts.Cannouncement'){
            this.isPosting = true
        }
        getTemplateCnt({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            this.templateCnt = res.data.templateCnt
            this.draftCnt = res.data.draftCnt
        })
    },

    methods: {
        selectedLesson(val){
            //console.log(val)
        },  
        saveDraft(){
            this.$refs.child.emitData()
            let draftData = {}
            draftData.tempType = 2
            draftData.content = this.announcementData.content
            draftData.schoolId = this.currentPath.params.schoolId
            if(this.currentPath.params.lessonId){
                draftData.lessonId = this.currentPath.params.lessonId
            }
            let currentTime = Date.now();
            draftData.title = 'title-' + currentTime
            draftData.description = 'description-' + currentTime
            console.log(draftData)
            if(this.announcementData.content.length == 0){
                return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
            }
            this.isDraft = true
            createTemplate(draftData).then(res=>{
                console.log(res.data)
                this.isDraft = false
                this.draftCnt ++ 
            }).catch(err=>{
                console.log(err.response)
                this.isDraft = false
            })
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
            }else if(this.viewType == 'pvt'){
                this.announcementData.showList = []
                this.announcementData.showList.push(this.user.id)
            }else{
                this.announcementData.showList = []
                if(this.$isMobile()){
                    this.announcementData.showList = this.publishSpecUserList
                }
                else{
                    this.announcementData.showList = this.specUsers
                }
            }

            if(this.announcementData.title.trim() == ''){
                    return this.$snackbar.showMessage({content: this.lang.announcement+this.lang.requireTitle, color: "error"})
            }
            if(this.announcementData.signName.trim() == ''){
                    return this.$snackbar.showMessage({content: this.lang.announcement+this.lang.requireSignName, color: "error"})
            }
            if(this.announcementData.content.length == 0){
                    return this.$snackbar.showMessage({content: this.lang.announcement+this.lang.requireContent, color: "error"})
                }
            
            this.isCreating = true
            await createAnouncement(this.announcementData).then(res=>{
                this.isCreating = false
                this.clearStore();
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'classSpace.news'})
                }
            }).catch(err=>{
                this.clearStore();
                this.isCreating = false
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
            if(this.announcementData.publishType == 'spec'){
                this.isPosting = false
                this.$router.push({name:'Cannouncement.contacts'})
            }
        },
        templateList(){
            this.isPosting = false
            this.$router.push({name:'Cannouncement.templateList'})
        },

        selectPublishType( val ){
            console.log(val, this.announcementData.content[0]);
            if(val == 'spec'){
                if(this.announcementData.content[0].text.trim() == ''){
                    this.announcementData.publishType = null;
                    return this.$snackbar.showMessage({content: this.lang.share+this.lang.requireContent, color: "error"})
                }
                this.$store.dispatch('mo/onPublishContent', this.announcementData);
                this.$store.dispatch('mo/onBackWithoutSelect', false);
                this.$router.push({name: 'member.selectMo'});
            }
            else{
                if(this.publishSpecUserList !== null){
                    this.$store.dispatch('mo/onPublishSpecUserList', null);
                }
                if(this.clickedChange == true){
                    this.$store.dispatch('mo/onClickedChange', false);
                }
            }
        },

        changeSelectedUserList(){
            this.$store.dispatch('mo/onClickedChange', true);
            this.$router.push({name: 'member.selectMo'});
        },

        navToBackCustom(){
            this.clearStore();
            this.$router.go(-1);
        },

        clearStore(){
            this.$store.dispatch('mo/onPublishContent', null);
            this.$store.dispatch('mo/onPublishSpecUserList', null);
            this.$store.dispatch('mo/onBackWithoutSelect', false);
            this.$store.dispatch('mo/onClickedChange', false);
            this.$store.dispatch('mo/onBackWithChange', false);
        }
    }
}
</script>

<style>

</style>