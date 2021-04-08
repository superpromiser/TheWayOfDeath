<template>
    <v-container>
        <div class="divider"></div>
        <v-row class="my-10 float-right">
            <v-col cols="12">
                <v-btn
                    color="primary"
                    @click="submit"
                >
                    {{lang.submit}}
                </v-btn>
            </v-col>
        </v-row>
        <div class="divider"></div>
        <v-row v-for="(user,idx) in userList" :key="user.id" class="d-flex justify-space-between align-center">
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
            <div class="divider"></div>
        </v-row>
    </v-container>
</template>

<script>
import {getLessonUserList} from '~/api/user'
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        rating:null,
        userList:[],
        lang
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        getLessonUserList({lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            res.data.map(user=>{
                let item = {}
                item.name = user.name
                item.id = user.id
                item.rating = 0
                item.schoolId = user.schoolId
                item.lessonId = user.lessonId
                this.userList.push(item)
            })
            // this.userList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        submit(){
            console.log(this.userList)
        }
    }
}
</script>

<style>

</style>