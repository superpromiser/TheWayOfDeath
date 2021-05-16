<template>
    <v-container class="pa-0">
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class=" left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.voting}}模板</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        tile
                        dark
                        color="#7879ff"
                        class="mx-2"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newTemplateData.tempTitle"
                        label="模板名称"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newTemplateData.description"
                        label="说明"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" v-for="index in initialCnt" :key="index" class="mt-3">
                    <QuestionItem class="" :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
                    <v-divider class="thick-border" light></v-divider>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import AttachItemViewer from '~/components/attachItemViewer'
import UploadImage from '~/components/UploadImage';
import QuestionItem from '~/components/questionItem'
import {createTemplate} from '~/api/voting'
export default {
    middleware:'auth',
    components: {
        QuestionItem,
        AttachItemViewer,
        UploadImage
    },
    data:()=>({
        isSubmit:false,
        lang,
        baseUrl:window.Laravel.base_url,
        newTemplateData:{
            imgUrl:'',
            tempTitle:'',
            tempType:1,
            description:'',
            content:[],
            schoolId:null,
            lessonId:null,
        },
        initialCnt:4,
    }),
    computed:{
        currentPath(){
            return this.$route;
        }
    },
    created(){
        this.newTemplateData.schoolId = this.currentPath.params.schoolId
        this.newTemplateData.lessonId = this.currentPath.params.lessonId
    },
    methods:{
        async submit(){
            for(let index = 1;  index <= this.initialCnt; index++){
                this.$refs[index][0].emitData()
            }
            if(this.newTemplateData.content.length < 4){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            console.log(this.newTemplateData)
            this.isSubmit = true
            createTemplate(this.newTemplateData).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                this.$router.push({name:'Cvoting.templateList'})
            }).catch(err=>{
                this.isSubmit = false
                console.log(err.response)
            })
        },
        upImgUrl(value) {
            this.newTemplateData.imgUrl = value;
        },
        clearedImg(){
            this.newTemplateData.imgUrl = ''
        },
        loadContentData(data){
            if(data.text === ''){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            this.newTemplateData.content.push(data);
        },
    },
}
</script>

<style>

</style>