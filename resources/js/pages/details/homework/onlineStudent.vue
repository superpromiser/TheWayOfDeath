<template>
    <v-container>
        <!-- <div class="category">答卷</div> -->
        <v-container class="px-10 z-index-2 banner-custom mb-15">
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
                        color="primary"
                        @click="submit"
                        :loading="isSubmit"
                        :disabled="alreadyAnswer"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <div v-if="alreadyAnswer == false">
            <QuestionItem Label='答卷' ref="child" @contentData="loadContentData"></QuestionItem>
        </div>
        <div v-else>
            <div class="category mt-15">答卷内容</div>
            <v-row>
                <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ answerData.text }}</p>
                </v-col>
                <v-col v-if="checkIfAttachExist(answerData)">
                    <AttachItemViewer :items="answerData" />
                </v-col>
            </v-row>
            <div class="category mt-15">批改详情</div>
            <v-row v-if="homeworkResult.teacherAnswer != null">
                    <v-col cols="12" class="pb-0">
                    <p class="text-wrap mb-0"><read-more more-str="全文" :text="homeworkResult.teacherAnswer.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" class="py-0" v-if="checkIfAttachExist(homeworkResult.teacherAnswer)">
                    <AttachItemViewer :items="homeworkResult.teacherAnswer" />
                </v-col>
            </v-row>
            <v-col class="d-flex justify-space-between align-center" cols="12" v-if="homeworkResult.rating != null">
                <p class="pl-2">
                </p>
                <v-rating
                    half-increments
                    hover
                    background-color="orange lighten-3"
                    color="orange"
                    length="5"
                    size="50"
                    value="0"
                    v-model="homeworkResult.rating"
                    readonly
                ></v-rating>
            </v-col>
        </div>
    </v-container>
</template>

<script>
import QuestionItem from '~/components/questionItem'
import lang from '~/helper/lang.json'
import {getHomeworkResult,createHomeworkResult} from '~/api/homework'
import AttachItemViewer from '~/components/attachItemViewer';
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
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
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
                if(res.data.teacherAnswer != null){
                    res.data.teacherAnswer = JSON.parse(res.data.teacherAnswer)
                }
                this.homeworkResult = res.data
            }
        }).catch(err=>{
            console.log(err.response)
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
                this.$router.push({name:'classSpace.news'})
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