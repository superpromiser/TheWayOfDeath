<template>
    <v-container class="ma-0 pa-0" v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="" >
                    <v-img :src="`${baseUrl}/asset/img/appIcon/家校互动/作业.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.homework}}</h2>
            </v-col>
        </v-row>
        <v-container v-if="showRule == false">
            <v-row class="ma-0">
                <v-col cols="12">
                    <v-text-field
                        v-model="homeworkData.subjectName"
                        color="#7879ff"
                        label="科目"
                        clearable
                        hide-details
                        class="mt-0 pt-0"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-select
                        :items="homeworkType"
                        label="类型"
                        item-text="label"
                        item-value="value"
                        color="#7879ff"
                        hide-details
                        class="mt-0 pt-0"
                        v-model="homeworkData.homeworkType"
                        :menu-props="{ top: false, offsetY: true }"
                    ></v-select>
                </v-col>
                <v-col cols="12" class="d-flex align-center justify-space-between" @click="setRule">
                    <p class="mb-0">发布规则</p>
                    <div class="d-flex align-center">
                        <span>即使发布</span>
                        <v-icon right> mdi-chevron-right </v-icon>
                    </div>
                </v-col>
            </v-row>
            <v-row class="ma-0">
                <v-col cols="12" class="mb-16">
                    <QuestionItem Label="作业内容" :emoji="true" :contact="true"  ref="child" @contentData="loadContentData"></QuestionItem>
                </v-col>
            </v-row>
        </v-container>
        <div v-else>
            <router-view></router-view>
        </div>
        <quick-menu v-if="showRule == false" @clickDraft="something" @clickPublish="submit" :isPublishing="isSubmit"></quick-menu>
    </v-container>
    <v-container v-else>
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
                    <h2>{{lang.homework}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        text
                        color="primary"
                        @click="templateList"
                    >
                        可用模板 0， 草稿 0
                    </v-btn>
                    <v-btn
                        dark
                        tile
                        color="#49d29e"
                        class="mx-2"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        {{lang.submit}}
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
                </v-col>
            </v-row>
        </v-container>
        <div v-if="showRule == false">
            <v-row class="mt-1 align-center">
                <v-col cols="6">
                    <p class="">科目</p>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="homeworkData.subjectName"
                        solo
                        label="科目"
                        clearable
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="mt-1 align-center">
                <v-col cols="6">
                    <p class="">类型</p>
                </v-col>
                <v-col cols="6">
                    <v-select
                        :items="homeworkType"
                        label=""
                        item-text="label"
                        item-value="value"
                        solo
                        v-model="homeworkData.homeworkType"
                    ></v-select>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="mt-1 align-center hover-cursor-point" @click="setRule">
                <v-col cols="6">
                    <p class="">发布规则</p>
                </v-col>
                <v-col cols="6" class="text-right">
                    <span>即使发布</span>
                    <v-icon
                        right  
                    >
                        mdi-chevron-right
                    </v-icon>
                        
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <QuestionItem Label="作业内容" :emoji="true" :contact="true"  ref="child" @contentData="loadContentData"></QuestionItem>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {getHomeworkData,createHomeworkData} from '~/api/homework'
import quickMenu from '~/components/quickMenu'
export default {
    components:{
        QuestionItem,
        quickMenu,
    },
    data:()=>({
        lang,
        isSubmit:false,
        isDraft:false,
        tempCnt:0,
        draftCnt:0,
        baseUrl:window.Laravel.base_url,
        homeworkData:{
            subjectName:'',
            homeworkType:'offline',
            content:null,
            deadline:'',
            monitorName:'',
            parentCheck:false,
        },
        homeworkType:[
            {
                label:'常规作业',
                value:'常规作业'
            },
            {
                label:'在线作业',
                value:'在线作业'
            },
            {
                label:'在线测试',
                value:'在线测试'
            }
        ],
        showRule:false
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name == 'posts.Chomework'){
                    this.showRule = false
                }
                if(val.query.rule){
                    console.log(val.query.rule)
                    this.homeworkData.deadline = val.query.rule.deadline
                    this.homeworkData.monitorName = val.query.rule.monitorName
                    this.homeworkData.parentCheck = val.query.rule.parentCheck

                    // this.homeworkData = val.query.rule
                    // console.log(this.homeworkData)
                }
            },
            deep:true
        }
    },
    created(){
        this.$router.push({name:'posts.Chomework'})
    },
    methods:{
        submit(){
            console.log("submit")
            this.$refs.child.emitData()
            if(this.homeworkData.content == null){
                return this.$snackbar.showMessage({content: "请输入问卷。", color: "error"})
            }
            if(this.homeworkData.subjectName == ''){
                return this.$snackbar.showMessage({content: "请输入问卷。", color: "error"})             
            }
            this.isSubmit = true
            
            console.log("this.homeworkData",this.homeworkData)

            createHomeworkData({
                schoolId:this.currentPath.params.schoolId,
                lessonId:this.currentPath.params.lessonId,
                subjectName:this.homeworkData.subjectName,
                homeworkType:this.homeworkData.homeworkType,
                content:this.homeworkData.content,
                deadline:this.homeworkData.deadline,
                monitorName:this.homeworkData.monitorName,
                parentCheck:this.homeworkData.parentCheck,
            }).then(res=>{
                this.isSubmit = false
                console.log(res.data)
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'classSpace.news'})
                }
                
            }).catch(err=>{
                console.log(err.response)
                this.isSubmit = false
            })
        },
        templateList(){
            console.log("go to template list")
        },
        saveDraft(){
            console.log("save draft")
        },
        setRule(){
            this.showRule = true
            console.log('setRule')
            this.$router.push({name:'Chomework.setRule'});
        },
        loadContentData(data){
            console.log(data)
            if(data.text == ''){
                this.homeworkData.content = []
                return
            }
            this.homeworkData.content = data
        },

        something(){

        }
    }
}
</script>

<style>

</style>