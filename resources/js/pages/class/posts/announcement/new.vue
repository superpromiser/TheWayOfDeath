<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <v-avatar
                    class="ma-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/公告 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.announcement}}</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                text
                color="primary"
            >
                可用模板 0， 草稿 0
            </v-btn>
            <v-btn
                dark
                color="#49d29e"
                @click="publishcampusData"
                tile
                class="mr-md-8"
                :loading="isCreating"
            >
                提交
            </v-btn>
            </template>
        </v-banner>
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
                        v-model="chooseSignNameDialog"
                        max-width="500px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                solo
                                v-model="announcementData.signName"
                                label="公告标题"
                                hide-details
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-card >
                            <v-card-title>公告标题</v-card-title>
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
                <v-col cols="12" sm="6" md="4">
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
                </v-col>
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
                    <vue-editor v-model="announcementData.content" placeholder="公告内容"></vue-editor>
                </v-col>
            </v-row>
            
        </v-container>
        <v-snackbar
            timeout="3000"
            v-model="requiredText"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import QuestionItem from '~/components/questionItem'
import UploadImage from '~/components/UploadImage'
import lang from '~/helper/lang.json'
import { VueEditor } from "vue2-editor";


import {createAnouncement} from '~/api/anouncement'

export default {
    components: {
        VueEditor,
        QuestionItem,
        UploadImage,
    },

    watch: {
      chooseSignNameDialog (val) {
        val || this.closeChooseSignNameDialog()
      },
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
            content:''
        },
        newSignFlag:false,
        newSignName:'',
        isCreating:false,
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
        
    },

    methods: {
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
            this.isCreating = true
            //console.log("announcementData", this.announcementData);
            await createAnouncement(this.announcementData).then(res=>{
                //console.log(res)
                this.$router.push({name:'schoolSpace.news'})
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
        }
    }
}
</script>

<style>

</style>