<template>
    <v-container v-if="$isMobile()" class="pa-0">
        <v-container v-if="isPosting == true" class="pa-0 h-100 bg-white mb-16 pb-3 pt-12" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
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
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        color="#7879ff"
                        multiple
                        small-chips
                        :items="returnSchoolTree(currentPath.params.schoolId)"
                        :menu-props="{ top: false, offsetY: true }"
                        item-text="lessonName"
                        item-value="lessonId"
                        @change="selectedLesson"
                        label="展示范围"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-select>
                </v-col>
                <!-- <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-between">
                    <span>签名反馈</span>
                    <v-switch
                        v-model="announcementData.scopeFlag"
                        color="#7879ff"
                        hide-details
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col> -->
            </v-row>
            <QuestionItem Label="" :emoji="true" :isAnnouncement="true" :isShareView="true" :item="announcementData.content[0]" ref="child" @contentData="loadContentData"></QuestionItem>
            <v-btn @click="tempList" rounded color="#E0E0E0" small elevation="0" class="position-absolute font-color-gray-dark-btn" style="bottom: 54px; left: 12px;"> <v-icon left>mdi-buffer</v-icon>模板</v-btn>
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
                                @click="tempList"
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
                    <v-col cols="12" sm="6" md="4">
                        <v-select
                            solo
                            multiple
                            chips
                            :items="returnSchoolTree(currentPath.params.schoolId)"
                            :menu-props="{ top: false, offsetY: true }"
                            item-text="lessonName"
                            item-value="lessonId"
                            @change="selectedLesson"
                            label="展示范围"
                            hide-details
                        ></v-select>
                    </v-col>
                    <!-- <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                        <span>签名反馈</span>
                        <v-switch
                            v-model="announcementData.scopeFlag"
                            color="#7879ff"
                            hide-details
                            inset
                            class="pt-0 mt-0"
                        ></v-switch>
                    </v-col> -->
                    <v-col cols="12">
                        <QuestionItem Label="分享内容" :emoji="true" :item="announcementData.content[0]" ref="child" @contentData="loadContentData"></QuestionItem>
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
// import quickMenu from 'vue-quick-menu'
import quickMenu from '~/components/quickMenu'


import {createAnouncement,getTemplateCnt,createTemplate} from '~/api/anouncement'

export default {
    middleware:['auth','post'],
    components: {
        VueEditor,
        QuestionItem,
        UploadImage,
        quickMenu
    },

    watch: {
      chooseSignNameDialog (val) {
        val || this.closeChooseSignNameDialog()
      },
      currentPath:{
            handler(val){
                if(val.name == 'posts.announcement'){
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
            viewList:[],
            scopeFlag:false,
            content:[],
            schoolId:null,
        },
        newSignFlag:false,
        newSignName:'',
        isCreating:false,
        isDraft:false,
        isPosting:false,
        draftCnt:0,
        templateCnt:0

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
        if(this.currentPath.name == 'posts.announcement'){
            this.isPosting = true
        }
        this.announcementData.schoolId = this.currentPath.params.schoolId
        getTemplateCnt({schoolId:this.currentPath.params.schoolId}).then(res=>{
            this.draftCnt = res.data.draftCnt
            this.templateCnt = res.data.templateCnt
        })
    },

    methods: {
        async saveDraft(){
            this.$refs.child.emitData()
            let draftData = {}
            draftData.tempType = 2
            draftData.content = this.announcementData.content
            draftData.schoolId = this.currentPath.params.schoolId
            if(this.currentPath.params.lessonId){
                draftData.lessonId = this.currentPath.params.lessonId
            }
            let currentTime = this.TimeView(new Date());
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
        tempList(){
            this.$router.push({name:'anouncement.templateList'});
            this.isPosting = false
        },
        selectedLesson(val){
            //console.log(val)
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
            if(this.announcementData.content.length == 0){
                    return this.$snackbar.showMessage({content: this.lang.announcement+this.lang.requireContent, color: "error"})
                }
            if(this.announcementData.title.trim() == ''){
                    return this.$snackbar.showMessage({content: this.lang.announcement+this.lang.requireTitle, color: "error"})
            }
            if(this.announcementData.viewList.length == 0){
                    return this.$snackbar.showMessage({content: this.lang.announcement+this.lang.requireMember, color: "error"})
            }
            this.isCreating = true
            console.log("announcementData", this.announcementData);
            // return
            await createAnouncement(this.announcementData).then(res=>{
                //console.log(res)
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
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
        something(){
            console.log("draft");
        }
    }
}
</script>

<style>

</style>