<template>
    <v-container>
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
           <div class="d-flex align-center justify-space-between">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <p class="mb-0">学号</p>
                <v-btn
                    tile
                    dark
                    color="green lighten-1"
                    :loading="isSubmit"
                    @click="submit"
                    >
                    {{ lang.submit }}
                </v-btn>
            </div>
        </v-banner>
        <v-banner>
            <v-row>
                <v-col cols="9">
                    学生姓名
                </v-col>
                <v-col cols="3">
                    <span class="text-center">学号</span>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner v-for="member in userList" :key="member.id">
            <v-row>
                <v-col cols="9">
                    {{member.name}}
                </v-col>
                <v-col cols="3">
                    <v-text-field class="member-chk" label="place holder" style="height:33px;"></v-text-field>
                </v-col>
            </v-row>
        </v-banner>
    </v-container>
</template>

<script>
import {getStudentIdUser} from '~/api/group';
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        userList:[],
        lang,
        isSubmit:false,
        search:''
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        
    },
    created(){
        getStudentIdUser({
            schoolId:this.currentPath.params.schoolId,
            lessonId:this.currentPath.params.lessonId
        }).then(res=>{
            console.log(res.data)
            res.data.map(user=>{
                this.userList.push(user.members)
            }) 
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        submit(){
            console.log('submt')
        }
    }
}
</script>

<style>

</style>