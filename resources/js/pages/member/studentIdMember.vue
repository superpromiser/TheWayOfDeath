<template>
    <v-container class="pa-0">
         <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class=" left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>学号</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                <v-btn
                    tile
                    dark
                    color="#49d29e"
                    :loading="isSubmit"
                    @click="submit"
                >
                    {{ lang.submit }}
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
        <div v-else class="px-10">
            <v-row class="py-5">
                <v-col cols="9">
                    学生姓名
                </v-col>
                <v-col cols="3">
                    <span class="text-center">学号</span>
                </v-col>
            </v-row>
            <v-divider light class="thick-border"></v-divider>
            <div v-for="member in userList" :key="member.id">
                <v-row class="py-5">
                    <v-col cols="9">
                        {{member.name}}
                    </v-col>
                    <v-col cols="3">
                        <v-text-field class="member-chk" label="" hide-details dense solo v-model="member.studentId" :value="member.studentId"></v-text-field>
                    </v-col>
                </v-row>
                <v-divider light class="thick-border"></v-divider>
            </div>
        </div>
    </v-container>
</template>

<script>
import {getLessonUserList} from '~/api/user';
import {createStudentIdUser} from '~/api/group'
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        userList:[],
        lang,
        isSubmit:false,
        search:'',
        isLoading:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        
    },
    created(){
        this.isLoading = true
        getLessonUserList({
            lessonId:this.currentPath.params.lessonId,
        }).then(res=>{
            console.log(res.data)
            this.userList = res.data 
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
        })
    },
    methods:{
        async submit(){
            let newUserList = []
            this.userList.map(user=>{
                let el = {}
                el.id = user.id
                el.studentId = user.studentId
                newUserList.push(el)
            })
            console.log('submt',newUserList)
            this.isSubmit = true
            await createStudentIdUser({userList:newUserList}).then(res=>{
                this.isSubmit = false
                this.$router.push({name:'classSpace.member'})
            }).catch(err=>{
                console.log(err.response)
                this.isSubmit = false
            })
        }
    }
}
</script>

<style>

</style>