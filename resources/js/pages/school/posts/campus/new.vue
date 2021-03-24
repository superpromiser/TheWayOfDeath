<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/动态 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.campus}}</h2>
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
                color="green lighten-1"
                :loading="isCreating"
                @click="publishcampusData"
                tile
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
                        v-model="campusData.camposeCategory"
                        label="栏目"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="campusData.title"
                        label="标题"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <UploadImage @upImgUrl="upImgUrl" @clearedImg="clearedImg" :solo="true" uploadLabel="模板封面" />
                </v-col>
                <v-col cols="12">
                    <vue-editor v-model="campusData.content" placeholder="公告内容"></vue-editor>
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


import {createCampus} from '~/api/campus'

export default {
    components: {
        VueEditor,
        QuestionItem,
        UploadImage,
    },

    data: () => ({
        lang,
        menu: false,
        requiredText:false,
        baseUrl: window.Laravel.base_url,
        typeItem : [
            { 
                label : "校园新闻", 
                value : "校园新闻" 
            },
            { 
                label : "日读一刻", 
                value : "日读一刻" 
            },
            { 
                label : "体育健儿", 
                value : "体育健儿" 
            },
            { 
                label : "办学理念", 
                value : "办学理念" 
            },
            { 
                label : "校园文化", 
                value : "校园文化" 
            },
            { 
                label : "学校荣誉", 
                value : "学校荣誉" 
            },
            { 
                label : "校园运动会", 
                value : "校园运动会" 
            },
            
        ],
        campusData:{
            camposeCategory: '',
            title:'',
            imgUrl:'',
            content:'',
            schoolId:null,
        },
        isCreating:false
    }),

    computed: {
       currentPath(){
           return this.$route
       }
    },

    created() {
        this.campusData.schoolId = this.currentPath.params.schoolId
    },

    methods: {
        selectedLesson(val){
            //console.log(val)
        },  
        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true
                this.campusData.content = []
                return;
            }
            this.campusData.content.push(data);
        },

        upImgUrl(value) {
            this.campusData.imgUrl = value;
            //console.log(this.campusData.imgUrl);
        },
        clearedImg(){
            this.campusData.imgUrl = ''
            //console.log(this.campusData.imgUrl);
        },

        async publishcampusData(){
            this.isCreating = true
            //console.log("campusData", this.campusData);
            await createCampus(this.campusData).then(res=>{
                //console.log(res)
                this.isCreating = false
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                this.isCreating = false
                //console.log(err.response)
            })
        },
    }
}
</script>

<style>

</style>