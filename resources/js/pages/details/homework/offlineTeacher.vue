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
                    <h2>{{homeworkData.homeworkType}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        dark
                        tile
                        color="#7879ff"
                        @click="submit"
                        :disabled="alreadyAnswer"
                        :loading="isSubmit"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <div v-if="alreadyAnswer == false">
            <v-row v-for="(user,idx) in userList" :key="user.id" class=" ma-0">
                <v-col class="d-flex justify-space-between align-center" cols="12">
                    <p class="pl-2">
                        {{idx + 1}}.
                        {{user.name}}
                    </p>
                    <v-rating
                        half-increments
                        hover
                        background-color="orange lighten-3"
                        color="orange"
                        length="5"
                        size="50"
                        v-model="user.rating"
                    ></v-rating>
                </v-col>
                <v-divider class="thick-border"></v-divider>
            </v-row>
        </div>
        <div v-else>
            <v-row v-for="(user,idx) in userList" :key="user.id">
                <v-col class="d-flex justify-space-between align-center" cols="12">
                    <p class="pl-2">
                        {{idx + 1}}.
                        {{user.user.name}}
                    </p>
                    <v-rating
                        half-increments
                        hover
                        background-color="orange lighten-3"
                        color="orange"
                        length="5"
                        size="50"
                        v-model="user.rating"
                        readonly
                    ></v-rating>
                </v-col>
                <v-divider class="thick-border"></v-divider>
            </v-row>
        </div>
    </v-container>
</template>

<script>
import {getLessonUserList} from '~/api/user'
import lang from '~/helper/lang.json'
import {getOfflineTeacherAnswer, createOfflineTeacherAnswer} from '~/api/homeworkResult'
export default {
    props:{
        contentData:{
            type:Object,
            required:true
        }
    },
    data:()=>({
        rating:true,
        userList:[],
        lang,
        alreadyAnswer:false,
        homeworkData:null,
        isSubmit:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        console.log('-------------',this.contentData)
        this.homeworkData = this.contentData.homework
        await getOfflineTeacherAnswer({
            postId:this.contentData.id
        }).then(res=>{
            console.log(res.data)
            if(res.data.length > 0){
                this.alreadyAnswer = true
                this.userList = res.data
            }
        }).catch(err=>{
            console.log(err.response)
        })
        if(this.alreadyAnswer == false){
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
        }
    },
    methods:{
        submit(){
            this.userList.map(user=>{
                if(user.rating == 0){
                    this.rating = false
                    return this.$snackbar.showMessage({content: "请输入问卷。", color: "error"})
                }
            })
            console.log(this.userList)
            if(this.rating == false){
                return
            }
            this.isSubmit = true
            createOfflineTeacherAnswer({ratingList:this.userList}).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                this.$router.push({name:'classSpace.news'})
            }).catch(err=>{
                this.isSubmit = false
                console.log(err.response)
            })
            // create
        }
    }
}
</script>

<style>

</style>