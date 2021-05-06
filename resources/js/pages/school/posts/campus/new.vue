<template>
    <v-container v-if="$isMobile()" class="ma-0 pa-0 h-100">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.campus}}</p>
                <v-btn @click="submit" :loading="isCreating" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0 mo-glow">
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        class="mo-glow-v-select mt-0 pt-0"
                        color="#7879ff"
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
                        class="mo-glow-v-text mt-0 pt-0"
                        color="#7879ff"
                        v-model="campusData.title"
                        label="标题"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <UploadImage @upImgUrl="upImgUrl" @clearedImg="clearedImg" :solo="false" uploadLabel="模板封面" />
                </v-col>
                <v-col cols="12">
                    <v-row class="ma-0 mo-glow">
                        <v-col cols="12" class="pa-0">
                            <v-textarea
                                class="v-textarea-cus-border-0 v-textarea-px-0 mt-0 pt-0"
                                auto-grow
                                color="#7879ff"
                                clear-icon="mdi-close-circle"
                                label="输入内容"
                                v-model="campusData.content"
                                hide-details
                                rows="5"
                                solo
                                ref="textarea"
                            ></v-textarea>
                            <vue-editor v-model="campusData.content" placeholder="公告内容"></vue-editor>
                        </v-col>
                    </v-row>
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
        </v-container>
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
                    <h2>{{lang.campus}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <!-- <v-btn
                        text
                        color="primary"
                        @click="selContent('template')"
                    >
                        可用模板 {{tempCnt}}， 草稿 {{draftCnt}}
                    </v-btn> -->
                    <v-btn
                        tile
                        dark
                        color="#7879ff"
                        class="mx-2"
                        :loading="isCreating"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>
                    <!-- <v-btn
                        tile
                        dark
                        color="#F19861"
                        :loading="isDraft"
                        @click="saveDraft"
                    >
                        {{lang.saveDraft}}
                    </v-btn> -->
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
import quickMenu from '~/components/quickMenu'


import {createCampus} from '~/api/campus'

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
        isCreating:false,
        isDraft:false,
        isSubmit:false,
        tempCnt:0,
        draftCnt:0,
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
                this.campusData.content = []
                return this.$snackbar.showMessage({content: this.lang.campus+this.lang.requireContent, color: "error"})
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

        async submit(){
            this.isCreating = true
            //console.log("campusData", this.campusData);
            
            await createCampus(this.campusData).then(res=>{
                //console.log(res)
                this.isCreating = false
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

        saveDraft(){

        },

        something(){

        }
    }
}
</script>

<style>

</style>