<template>
    <v-container v-if="$isMobile()" class="ma-0 pa-0 h-100">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.safeStudy}}</p>
                <v-btn @click="submit" :loading="isSubmit" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0 mo-glow">
                <v-col cols="12">
                    <QuestionItem :Label="lang.contentPlaceFirst" :emoji="true" ref="child" @contentData="loadContentData"></QuestionItem>
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
            <v-snackbar
            timeout="3000"
                v-model="isSuccessed"
                color="success"
                absolute
                top
                >
                {{lang.successText}}
            </v-snackbar>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
        <div v-if="isPosting == true">
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
                    <h2>{{lang.safeStudy}}</h2>
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
                <QuestionItem :Label="lang.contentPlaceFirst" :emoji="true" ref="child" :item="shareData.content[0]" @contentData="loadContentData"></QuestionItem>
            </v-container>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {createSafeStudy,getTemplateCnt,createTemplate} from '~/api/safeStudy'
import quickMenu from '~/components/quickMenu'
export default {
    components:{
        QuestionItem,
        quickMenu,
    },

    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        isSubmit:false,
        isDraft:false,
        requiredText:false,
        shareData:{
            schoolId:null,
            lessonId:null,
            content:[]
        },
        isSuccessed:false,
        isPosting:false,
        draftCnt:0,
        templateCnt:0
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        getTemplateCnt({schoolId:this.currentPath.params.schoolId}).then(res=>{
            console.log("res.data",res.data)
            this.templateCnt = res.data.templateCnt
            this.draftCnt = res.data.draftCnt
        }).catch(err=>{
            console.log(err.response)
        })
        this.shareData.schoolId = this.currentPath.params.schoolId
        if(this.currentPath.name == 'posts.safeStudy'){
            this.isPosting = true
        }
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name == 'posts.safeStudy'){
                    this.isPosting = true
                }
                if(val.query.tempData){
                    console.log(JSON.parse(val.query.tempData))
                    this.shareData.content = JSON.parse(val.query.tempData)
                }
            },
            deeper:true
        }
    },
    methods:{
        async saveDraft(){
            this.$refs.child.emitData()
            let draftData = {}
            draftData.tempType = 2
            draftData.content = this.contentData
            draftData.schoolId = this.currentPath.params.schoolId
            if(this.currentPath.params.lessonId){
                draftData.lessonId = this.currentPath.params.lessonId
            }
            let currentTime = Date.now();
            draftData.title = 'title-' + currentTime
            draftData.description = 'description-' + currentTime
            console.log(draftData)
            if(this.shareData.content.length == 0){
                return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
            }
            draftData.content = this.shareData.content
            this.isDraft = true
            await createTemplate(draftData).then(res=>{
                console.log(res.data)
                this.isDraft = false
                this.draftCnt ++ 
            }).catch(err=>{
                console.log(err.response)
                this.isDraft = false
            })
        },
        async submit(){
            this.$refs.child.emitData()
            if(this.shareData.content.length == 0){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            //console.log(this.shareData)
            this.isSubmit = true
            await createSafeStudy(this.shareData).then(res=>{
                console.log(res)
                this.isSubmit = false
                this.isSuccessed = true;
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                //console.log(err.response)
                this.isSubmit = false
            })
        },

        loadContentData(data){
            if(data.text === ''){
                this.shareData.content = [];
                return this.$snackbar.showMessage({content: this.lang.requiredText, color: "error"})
            }
            this.shareData.content.push(data)
        },
        templateList(){
            this.$router.push({name:"safeStudy.templateList"})
            this.isPosting = false
        }
    }
}
</script>

<style>

</style>