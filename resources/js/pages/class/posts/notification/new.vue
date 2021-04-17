<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/icon/通知 拷贝.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.notification}}</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow">
            <v-col cols="12" sm="6" md="4">
                <v-text-field
                    class="mo-glow-v-text mt-0 pt-0"
                    color="#7879ff"
                    v-model="notificationData.title"
                    label="标题"
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
                            class="mo-glow-v-text mt-0 pt-0"
                            color="#7879ff"
                            v-model="notificationData.signName"
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
                                        hide-details
                                        color="#7879ff"
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
            <v-col cols="12">
                <QuestionItem :Label="lang.contentPlaceFirst" :emoji="false" :contact="false"  ref="child" @contentData="loadContentData"></QuestionItem>
            </v-col>
        </v-row>
        <v-snackbar
            timeout="3000"
            v-model="requiredText"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
        <quick-menu @clickDraft="something" @clickPublish="publishcampusData" :isPublishing="isCreating"></quick-menu>
    </v-container>
    <v-container class="pa-0" v-else>
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
                    <h2>{{lang.notification}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        dark
                        color="#49d29e"
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
                        v-model="notificationData.title"
                        label="标题"
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
                                v-model="notificationData.signName"
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
                <v-col cols="12">
                    <QuestionItem :Label="lang.contentPlaceFirst" :emoji="false" :contact="false"  ref="child" @contentData="loadContentData"></QuestionItem>
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
import lang from '~/helper/lang.json'
import quickMenu from '~/components/quickMenu'

import {createNotification} from '~/api/notification'

export default {
    components: {
        QuestionItem,
        quickMenu
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
        notificationData:{
            title:'',
            signName: '',
            description:null,
            schoolId:null,
            classId:null
            // viewList:[],
            // postShow:[],
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
        this.notificationData.signName = this.user.name;
        this.notificationData.schoolId = this.currentPath.params.schoolId;
        this.notificationData.classId = this.currentPath.params.lessonId;
    },

    methods: {
        selectedLesson(val){
            //console.log(val)
        },  
        loadContentData(data){
            if(data.text === ''){
                this.notificationData.description = null;
                return this.$snackbar.showMessage({content: this.lang.requiredText, color: "error"})
            }
            this.notificationData.description = data;
        },

        upImgUrl(value) {
            this.notificationData.imgUrl = value;
            //console.log(this.notificationData.imgUrl);
        },
        clearedImg(){
            this.notificationData.imgUrl = ''
            //console.log(this.notificationData.imgUrl);
        },

        async publishcampusData(){
            this.$refs.child.emitData();
            if(this.notificationData.description == null){
                return this.$snackbar.showMessage({content: this.lang.requiredText, color: "error"})
            }
            this.isCreating = true;
            //console.log("notificationData", this.notificationData);
            await createNotification(this.notificationData).then(res=>{
                //console.log(res.data)
                this.isCreating = false;
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:"classSpace.news"})
                }
            }).catch(err=>{
                //console.log(err.response)
                this.isCreating = false
            })

            
        },
        closeChooseSignNameDialog () {
            this.chooseSignNameDialog = false
        },

        chooseSignName(){
            if(this.indexOfSignName == 0){
                this.notificationData.signName = this.user.name;
            }
            else{
                this.notificationData.signName = this.signNameItems[this.indexOfSignName - 2].text;
            }
            this.chooseSignNameDialog = false
        },
        selectedLesson(val){
            this.notificationData.viewList = val;
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

        }
    }
}
</script>

<style>

</style>