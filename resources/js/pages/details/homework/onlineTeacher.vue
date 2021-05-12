<template>
    <v-container class="pa-0">
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
                    <h2>答案详情</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <!-- <v-btn
                        dark
                        tile
                        color="#F19861"
                        @click="viewDetail"
                    >
                        查看详情
                    </v-btn> -->
                </v-col>
            </v-row>
        </v-container>
        <div v-if="homeworkCheck == false" class="px-10 mt-5">
            <v-row v-for="(user,idx) in userList" :key="user.id" class=" ma-0">
                <v-col class="d-flex justify-space-between align-center hover-cursor-point" cols="12" @click="selUser(user)">
                    <span class="pl-2">
                        {{idx + 1}}.
                        {{user.name}}
                    </span>
                    <v-icon>mdi-chevron-right</v-icon>
                </v-col>
                <v-divider class="thick-border"></v-divider>
            </v-row>
        </div>
        <div v-else class="mt-5">
            <router-view :studentName='studentName'></router-view>
        </div>
    </v-container>
</template>

<script>
import AttachItemViewer from '~/components/attachItemViewer';
import QuestionItem from '~/components/questionItem'
import lang from '~/helper/lang.json'
import {createTeacherAnswer} from '~/api/homeworkResult'
import {getLessonUserList} from '~/api/user'
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
        content:null,
        userList:[],
        homeworkCheck:false,
        studentName:''
    }),
    computed:{
        currentPath(){
            return this.$route;
        }
    },
    async created(){
        await getLessonUserList({lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            res.data.map(user=>{
                let item = {}
                item.name = user.name
                item.userId = user.id
                item.rating = 0
                item.schoolId = this.currentPath.params.schoolId
                item.lessonId = user.lessonId
                item.homeworkId = this.contentData.homework.id
                item.postId = this.contentData.id
                item.homeworkType = '常规作业'
                this.userList.push(item)
            })
            // this.userList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
        // console.log('onlineTeacher',this.contentData)
        // this.studentAnswer = JSON.parse(this.contentData.homework_result.content)
        // this.teacherAnswer = JSON.parse(this.contentData.homework_result.teacherAnswer)
        // this.rating = parseInt(this.contentData.homework_result.rating)
        // if(this.teacherAnswer != null){
        //     this.alreadyAnswer = true
        // }
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name == 'details.homeworkonlineTeacher'){
                    this.homeworkCheck = false
                }
            },
            deep:true
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
        },
        selUser(user){
            console.log(user)
            this.studentName = user.name
            this.homeworkCheck = true
            this.$router.push({name:"details.homworkResult.onlineTeacher.selUser",params:{userId:user.userId}})
        }
    }
}
</script>

<style>

</style>