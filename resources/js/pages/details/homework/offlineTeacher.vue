<template>
    <v-container>
        <div v-if="alreadyAnswer == false">
            <v-divider class="thick-border"></v-divider>
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex justify-end">
                    <v-btn
                        color="primary"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
            <v-divider class="thick-border"></v-divider>
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
                        value="0"
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
                        value="0"
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
        rating:null,
        userList:[],
        lang,
        alreadyAnswer:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        console.log('-------------',this.contentData)
        await getOfflineTeacherAnswer({
            postId:this.contentData.id
        }).then(res=>{
            console.log(res.data)
            this.alreadyAnswer = true
            this.userList = res.data
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
                    item.homeworkType = '分为常规作业'
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
                    return this.$snackbar.showMessage({content: "请输入问卷。", color: "error"})
                }
            })
            console.log(this.userList)
            createOfflineTeacherAnswer({ratingList:this.userList}).then(res=>{
                console.log(res.data)
            }).catch(err=>{
                console.log(err.response)
            })
            // create
        }
    }
}
</script>

<style>

</style>