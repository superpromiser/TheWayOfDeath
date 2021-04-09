<template>
    <v-container>
        <div class="category">答卷内容</div>
        <v-row>
            <v-col cols="12">
                <p class="mb-0 d-flex align-center"> 
                </p>
                <p class="text-wrap pl-3 mb-0 mt-3">{{ studentAnswer.text }}</p>
            </v-col>
            <v-col v-if="checkIfAttachExist(studentAnswer)">
                <AttachItemViewer :items="studentAnswer" />
            </v-col>
        </v-row>
        <div class="category">批改洋情</div>
        <v-row v-if="teacherAnswer == null" class="ma-0">
            <QuestionItem Label='答卷' ref="child" @contentData="loadContentData" class="my-10"></QuestionItem>
        </v-row>
        <v-row v-else>
            <v-col cols="12">
                <p class="mb-0 d-flex align-center"> 
                </p>
                <p class="text-wrap pl-3 mb-0 mt-3">{{ teacherAnswer.text }}</p>
            </v-col>
            <v-col v-if="checkIfAttachExist(teacherAnswer)">
                <AttachItemViewer :items="teacherAnswer" />
            </v-col>
        </v-row>
        <div class="category">成绩评价</div>
        <v-row class="d-flex justify-space-between align-center pl-2 mt-3">
            <p class="pl-2">
                {{contentData.users.name}}
            </p>
            <v-rating
                half-increments
                hover
                background-color="orange lighten-3"
                color="orange"
                length="5"
                size="50"
                value="0"
                v-model="rating"
            ></v-rating>
        </v-row>
        <v-row class="float-right">
            <v-col cols="12">
                <v-btn
                    color="primary"
                    @click="submit"
                    :disabled="alreadyAnswer"
                    :loading="isSubmit"
                >
                    {{lang.submit}}
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import AttachItemViewer from '~/components/attachItemViewer';
import QuestionItem from '~/components/questionItem'
import lang from '~/helper/lang.json'
import {createTeacherAnswer} from '~/api/homeworkResult'
export default {
    props:{
        contentData:{
            type:Object,
            required:true
        }
    },
    components:{
        AttachItemViewer,
        QuestionItem
    },
    data:()=>({
        studentAnswer:null,
        teacherAnswer:null,
        rating:null,
        alreadyAnswer:false,
        isSubmit:false,
        lang,
        content:null
    }),
    created(){
        console.log('onlineTeacher',this.contentData)
        this.studentAnswer = JSON.parse(this.contentData.homework_result.content)
        this.teacherAnswer = JSON.parse(this.contentData.homework_result.teacherAnswer)
        this.rating = parseInt(this.contentData.homework_result.rating)
        if(this.teacherAnswer != null){
            this.alreadyAnswer = true
        }
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
            console.log('submit')
            this.$refs.child.emitData()
            if(this.content == null){
                return this.$snackbar.showMessage({content: "请输入问卷。", color: "error"})
            }
            if(this.rating == null){
                return this.$snackbar.showMessage({content: "请输入问卷。", color: "error"})
            }

            await createTeacherAnswer({
                teacherAnswer:this.content,
                rating:this.rating,
                id:this.contentData.homework_result.id
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