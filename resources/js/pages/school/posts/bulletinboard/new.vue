<template>
    <v-container v-if="$isMobile()" class="ma-0 pa-0 h-100">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3 pt-12" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.bulletin}}</p>
                <v-btn @click="publishcampusData" :loading="isCreating" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0 mo-glow">
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        color="#7879ff"
                        class="mo-glow-v-select mt-0 pt-0"
                        :items="typeItem"
                        :menu-props="{ top: false, offsetY: true }"
                        item-text="label"
                        v-model="bulletinboardData.type"
                        label="栏目"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4" class="mb-16">
                    <QuestionItem class="" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
    <v-container v-else class="pa-0">
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
                    <h2>{{lang.bulletin}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <!-- <v-btn
                        text
                        color="#7879ff"
                    >
                        可用模板 0， 草稿 0
                    </v-btn>
                    <v-btn
                        tile
                        dark
                        color="#F19861"
                        :loading="isDraft"
                        @click="saveDraft"
                    >
                        {{lang.saveDraft}}
                    </v-btn> -->
                    <v-btn
                        dark
                        tile
                        color="#7879ff"
                        @click="publishcampusData"
                        :loading="isCreating"
                        class="mx-2"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        :items="typeItem"
                        :menu-props="{ top: false, offsetY: true }"
                        item-text="label"
                        v-model="bulletinboardData.type"
                        label="栏目"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" >
                    <QuestionItem class="mt-10" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
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
import quickMenu from '~/components/quickMenu'


import {createBulletinBoard} from '~/api/bulletinBoard'

export default {
    middleware:['auth','post'],
    components: {
        VueEditor,
        QuestionItem,
        UploadImage,
        quickMenu
    },

    data: () => ({
        lang,
        menu: false,
        requiredText:false,
        baseUrl: window.Laravel.base_url,
        typeItem : [
            { 
                label : "互问互答", 
                value : "互问互答" 
            },
            { 
                label : "拼团报名", 
                value : "拼团报名" 
            },
            { 
                label : "公共区域", 
                value : "公共区域" 
            },
            { 
                label : "旧物漂流", 
                value : "旧物漂流" 
            },
            { 
                label : "诚意推荐", 
                value : "诚意推荐" 
            },
            { 
                label : "寻物启事", 
                value : "寻物启事" 
            },
            { 
                label : "失物招领", 
                value : "失物招领" 
            },
        ],

        bulletinboardData:{
            // title:'',
            type:'',
            content:null,
            schoolId:null
        },
        isCreating:false,
        isDraft:false,
    }),

    computed: {
       currentPath(){
           return this.$route
       }
    },

    created() {
        this.bulletinboardData.schoolId = this.currentPath.params.schoolId
    },

    methods: {
        saveDraft(){

        },
        selectedLesson(val){
            //console.log(val)
        },  
        clearedImg(){
            this.bulletinboardData.imgUrl = ''
            //console.log(this.bulletinboardData.imgUrl);
        },

        async publishcampusData(){
            this.$refs.child.emitData()
            if(this.bulletinboardData.content == null){
                return
            }
            this.isCreating = true
            //console.log("bulletinboardData", this.bulletinboardData);
            await createBulletinBoard(this.bulletinboardData).then(res=>{
                //console.log(res.data)
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                //console.log(err.response)
            })
        },

        loadContentData(data){
            if(data.text === ''){
                this.bulletinboardData.content = null;
                return this.$snackbar.showMessage({content: this.lang.requiredText, color: "error"})
            }
            this.bulletinboardData.content = data
        },

        something(){

        }
    }
}
</script>

<style>

</style>