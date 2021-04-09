<template>
    <v-container>
        <div class="category">答卷</div>
        <div v-if="alreadyAnswer == false">
            <QuestionItem Label='答卷' ref="child" @contentData="loadContentData"></QuestionItem>
            <v-row class="float-right">
                <v-col cols="12">
                    <v-btn
                        color="primary"
                        @click="submit"
                        :loading="isSubmit"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </div>
        <div v-else>
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
        answerData:null
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
            if(res.data != null){
                this.alreadyAnswer = true
                this.answerData = JSON.parse(res.data.content)
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