<template>
    <v-container v-if="$isMobile()" class="ma-0 pa-0 h-100">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.schoolStory}}</p>
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
                            <v-icon size="70" class="left-24p">
                                mdi-chevron-left
                            </v-icon>
                        </a>
                    </v-col>
                    <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                        <h2>{{lang.schoolStory}}</h2>
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
                            dark
                            tile
                            color="#F19861"
                            :loading="isDraft"
                            @click="saveDraft"
                        >
                            {{lang.saveDraft}}
                        </v-btn>
                        <v-btn
                            dark
                            tile
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
                <QuestionItem Label="内容" :emoji="true" ref="child" @contentData="loadContentData" :item="shareData.content[0]"></QuestionItem>
            </v-container>
            <v-row class="px-10">
                <v-col cols="8" md="10"></v-col>
                <v-col cols="4" class="justify-end" md="2">
                    <v-select
                        :items='viewList'
                        item-text="label"
                        item-value="value"
                        v-model="shareData.publishType"
                        @change="selPublishType"
                    ></v-select>
                </v-col>
            </v-row>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {createSchoolStory,createTemplate,getTemplateCnt} from '~/api/schoolStory'
import quickMenu from '~/components/quickMenu'
import {mapGetters} from 'vuex'
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
            content:[{
                    text:'',
                    imgUrl:[],
                    otherUrl:[],
                    videoUrl:[]
                },],
            publishType:'pub'
        },
        isSuccessed:false,
        templateCnt:0,
        draftCnt:0,
        isPosting:false,
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
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            specUsers:'member/specUsers'
        })
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name == 'posts.schoolStory'){
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
    created(){
        if(this.currentPath.name == 'posts.schoolStory'){
            this.isPosting = true
        }
        this.shareData.schoolId = this.currentPath.params.schoolId
        getTemplateCnt({schoolId:this.currentPath.params.schoolId}).then(res=>{
            this.templateCnt = res.data.templateCnt
            this.draftCnt = res.data.draftCnt
        }).catch(err=>{
            console.log(err.response)
        })
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
            if(this.shareData.publishType == 'spec'){
                if(this.$isMobile()){
                    // this.$set(this.shareData, 'specUsers', this.publishSpecUserList);
                }
                else{
                   this.$set(this.shareData,'specUsers',this.specUsers)
                }
            }
            console.log(this.shareData)
            // return
            this.isSubmit = true
            await createSchoolStory(this.shareData).then(res=>{
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
            this.shareData.content = [];
            this.shareData.content.push(data)
        },
        something(){

        },
        templateList(){
            this.isPosting = false
            this.$router.push({name:'schoolStory.templateList'})
        },
        selPublishType(){
            if(this.shareData.publishType == 'spec'){
                this.isPosting = false
                this.$router.push({name:'schoolStory.contacts'});
            }
        }
    }
}
</script>

<style>

</style>