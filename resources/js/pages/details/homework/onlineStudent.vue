<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white mb-16 pb-10-px pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{contentData.homework.homeworkType}}</p>
                <v-btn @click="submit" :disabled="alreadyAnswer" :loading="isSubmit" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-container v-if="alreadyAnswer == false" class="pa-0">
                <QuestionItem Label='答卷' ref="child" @contentData="loadContentData"></QuestionItem>
            </v-container>
            <v-container v-else class="pa-0">
                <v-row class="category ma-0">答卷内容</v-row>
                <v-row class="ma-0">
                    <v-col cols="12">
                        <p class="mb-0 d-flex align-center"> 
                        </p>
                        <p class="text-wrap pl-3 mb-0 w-100">{{ answerData.text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(answerData)">
                        <AttachItemViewer :items="answerData" />
                    </v-col>
                </v-row>
                <v-row class="category mt-15 ma-0">批改详情</v-row>
                <v-row v-if="homeworkResult.teacherAnswer != null" class="ma-0">
                        <v-col cols="12" class="pb-0">
                        <p class="text-wrap mb-0"><read-more more-str="全文" :text="homeworkResult.teacherAnswer.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                    </v-col>
                    <v-col cols="12" class="py-0" v-if="checkIfAttachExist(homeworkResult.teacherAnswer)">
                        <AttachItemViewer :items="homeworkResult.teacherAnswer" />
                    </v-col>
                </v-row>
                <v-row class="category mt-15 ma-0">成绩评价</v-row>
                <v-col class="d-flex justify-space-between align-center" cols="12" v-if="homeworkResult.rating != null">
                    <p class="mb-0">
                        {{user.name}} 成绩评价
                    </p>
                    <v-rating
                        half-increments
                        hover
                        background-color="orange lighten-3"
                        color="orange"
                        length="5"
                        size="25"
                        value="0"
                        v-model="homeworkResult.rating"
                        readonly
                    ></v-rating>
                </v-col>
            </v-container>
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
                    <h2>{{contentData.homework.homeworkType}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        color="#7879ff"
                        dark
                        @click="submit"
                        :loading="isSubmit"
                        :disabled="alreadyAnswer"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="primary"
            ></v-progress-circular>
        </div>
        <div v-else>
            <div v-if="alreadyAnswer == false" class="px-10 mt-5">
                <QuestionItem Label='答卷' ref="child" @contentData="loadContentData"></QuestionItem>
            </div>
            <div v-else class="mt-5">
                <div class="category px-0">答卷内容</div>
                <v-row class="px-10">
                    <v-col cols="12">
                        <p class="mb-0 d-flex align-center"> 
                        </p>
                        <p class="text-wrap pl-3 mb-0">{{ answerData.text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(answerData)">
                        <AttachItemViewer :items="answerData" />
                    </v-col>
                </v-row>
                <div class="category mt-15 px-0">批改详情</div>
                <v-row v-if="homeworkResult.teacherAnswer != ''" class="px-10">
                        <v-col cols="12" class="pb-0">
                        <p class="text-wrap mb-0"><read-more more-str="全文" :text="homeworkResult.teacherAnswer.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                    </v-col>
                    <v-col cols="12" class="py-0" v-if="checkIfAttachExist(homeworkResult.teacherAnswer)">
                        <AttachItemViewer :items="homeworkResult.teacherAnswer" />
                    </v-col>
                </v-row>
                <div class="category mt-15 px-0">成绩评价</div>
                <v-col class="d-flex justify-space-between align-center px-10" cols="12" v-if="homeworkResult.rating != null">
                    <p class="">
                        {{user.name}} 成绩评价
                    </p>
                    <v-rating
                        half-increments
                        hover
                        background-color="orange lighten-3"
                        color="orange"
                        length="5"
                        size="25"
                        value="0"
                        v-model="homeworkResult.rating"
                        readonly
                    ></v-rating>
                </v-col>
            </div>
        </div>
    </v-container>
</template>

<script>
import QuestionItem from '~/components/questionItem'
import lang from '~/helper/lang.json'
import {getHomeworkResult,createHomeworkResult} from '~/api/homework'
import AttachItemViewer from '~/components/attachItemViewer';
import {mapGetters} from 'vuex'
export default {
    components:{
        QuestionItem,
        AttachItemViewer
    },
    props:{
        contentData:{
            type:Object,
            required:true,
        }
    },
    data:()=>({
        lang,
        isSubmit:false,
        content:null,
        alreadyAnswer:false,
        answerData:null,
        homeworkResult:null,
        isLoading:false
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            user:'auth/user'
        })
    },
    async created(){
        this.isLoading = true
        console.log("this.contentData",this.contentData)
        await getHomeworkResult({
            schoolId:this.currentPath.params.schoolId,
            lessonId:this.currentPath.params.lessonId,
            homeworkId:this.contentData.homework.id
        }).then(res=>{
            console.log(res.data)
            if(res.data != ''){
                this.alreadyAnswer = true
                this.answerData = JSON.parse(res.data.content)
                if(res.data.teacherAnswer != ''){
                    res.data.teacherAnswer = JSON.parse(res.data.teacherAnswer)
                }
                this.homeworkResult = res.data
            }
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
        })
    },
    methods:{
        checkIfAttachExist(data){
            let count = 0;
            count = count + data.imgUrl.length + data.videoUrl.length + data.otherUrl.length;
            if( count == 0 ) {
                return false;
            }
            else{
                return true;
            }
        },
        async submit(){
            console.log('submit',this.$refs.child)
            this.$refs.child.emitData()
            if(this.content == null){
                return this.$snackbar.showMessage({content: "请输入问卷。", color: "error"})
            }
            this.isSubmit = true
            await createHomeworkResult({
                homeworkId:this.contentData.homework.id,
                content:this.content,
                homeworkType:this.contentData.homework.homeworkType,
                schoolId:this.currentPath.params.schoolId,
                lessonId:this.currentPath.params.lessonId,
                postId:this.contentData.id
            }).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                if(this.$isMobile()){
                    this.$router.push({name: 'home'})
                }
                else{
                    this.$router.push({name:'classSpace.news'})
                }
            }).catch(err=>{
                console.log(err.response)
                this.isSubmit = false
            })
        },
        loadContentData(data){
            console.log(data)
            if(data.text == ''){
                this.content = null
                return
            }
            this.content = data
        }

    }

}
</script>

<style>

</style>