<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/icon/布告栏 拷贝.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.bulletin}}</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow mt-5">
            <v-col cols="12" sm="6" md="4">
                <v-select
                    solo
                    class="mo-glow-v-select"
                    :items="typeItem"
                    :menu-props="{ top: false, offsetY: true }"
                    item-text="label"
                    v-model="bulletinboardData.type"
                    label="栏目"
                    hide-details
                ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <QuestionItem class="" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
            </v-col>
        </v-row>
        <quick-menu @clickDraft="something" @clickPublish="publishcampusData" :isPublishing="isCreating"></quick-menu>
    </v-container>
    <v-container v-else class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
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
                    <v-img :src="`${baseUrl}/asset/img/icon/布告栏 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.bulletin}}</h2>
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
                tile
                color="#49d29e"
                @click="publishcampusData"
                :loading="isCreating"
                class="mr-md-8"
            >
                提交
            </v-btn>
            </template>
        </v-banner>
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
                this.requiredText = true;
                this.bulletinboardData.content = null;
                return;
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