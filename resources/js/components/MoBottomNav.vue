<template>
    <div class="position-fixed mo-bottom-nav-con">
        <v-bottom-navigation
            v-model="value"
            :input-value="active"
            color="#7879ff"
            grow
            fixed
            class=" bg-secondary mo-bottom-nav"
        >
            <v-btn fab plain :ripple="false" class="mo-bottom-nav-btn-item ml-3" @click="navToFirst">
                <span>首页</span>
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-btn fab plain :ripple="false" class="mo-bottom-nav-btn-item mx-3 mr-auto" @click="navToSecond">
                <span>通讯录</span>
                <v-icon>mdi-account-group</v-icon>
            </v-btn>
           
            <v-btn fab plain :ripple="false" class="mo-bottom-nav-btn-item mx-3 ml-auto" @click="navToThird">
                <span>圈子</span>
                <v-icon>mdi-fire-hydrant</v-icon>
            </v-btn>
            <v-btn fab plain :ripple="false" class="mo-bottom-nav-btn-item mr-3" @click="navToFourth">
                <span>我的</span>
                <v-icon>mdi-account</v-icon>
            </v-btn>
        </v-bottom-navigation>

        <v-btn v-if="isNewPost" fab dark depressed class="position-absolute mo-bottom-nav-plut-btn" color="#7879ff" @click="$router.go(-1)" >
            <v-icon> mdi-minus </v-icon>
        </v-btn>
        <v-btn v-else fab dark depressed class="position-absolute mo-bottom-nav-plut-btn" color="#7879ff" @click="navToNewPost" >
            <v-icon> mdi-plus </v-icon>
        </v-btn>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    computed:{
        ...mapGetters({
            isSchoolSpace: 'mo/isSchoolSpace',
            selectedSchoolItem: 'mo/selectedSchoolItem',
            user: 'auth/user'
        }),
        currentPath(){
            return this.$route
        }

    },
    watch:{
        selectedSchoolItem: {
            handler(val){
            },
            deep: true
        },
        currentPath:{
            handler(val){
                if(val.name === "home"){
                    this.value = 0
                    this.isNewPost = false;
                }
                else if(val.name=="chatMobile" || val.name=="mochat.news" || val.name=="mochat.detail" || val.name=="mochat.contact"){
                    this.value = 1
                    this.isNewPost = false;
                }
                else if(val.name=="circle"){
                    this.value = 2
                    this.isNewPost = false;
                }
                else if(val.name=="profile.list"){
                    this.value = 3
                    this.isNewPost = false;
                }
                else if(val.name=="mo.newPost"){
                    this.isNewPost = true;
                    let btnList = document.getElementsByClassName('mo-bottom-nav-btn-item');
                    for(let i = 0; i < btnList.length; i++){
                        btnList[i].classList.remove('v-btn--active');
                    }
                }
                else{
                    this.isNewPost = false;
                    // this.value = -1
                    let btnList = document.getElementsByClassName('mo-bottom-nav-btn-item');
                    for(let i = 0; i < btnList.length; i++){
                        btnList[i].classList.remove('v-btn--active');
                    }
                }
            },
            deep: true
        }
    },
    data: ()=> ({
        active: true,
        sheet: false,
        value: 0,
        baseUrl: window.Laravel.base_url,
        isNewPost: false,
    }),

    
    
    created(){
        
    },
    methods:{
        selectItem(item){
            this.sheet = false;
            if(this.isSchoolSpace == true){
                if(item.path == 'posts.vocation'){
                    if(this.user.roleId == 3){
                        this.$router.push({name:"posts.vacationTeacher",params:{schoolId:this.selectedSchoolItem.schoolId}})
                    }else if(this.user.roleId == 2){
                        this.$router.push({name:"posts.attendance.vacation",params:{schoolId:this.selectedSchoolItem.schoolId}})
                    }
                    else{
                        this.$router.push({name:item.path,params:{schoolId:this.selectedSchoolItem.schoolId}})
                    }
                }else{
                    this.$router.push({name:item.path,params:{schoolId:this.selectedSchoolItem.schoolId}})
                }
            }
            else{
                if(item.path == 'posts.vocation'){
                    if(this.user.roleId == 3){
                        this.$router.push({name:"posts.vacationTeacher",params:{schoolId:this.selectedSchoolItem.schoolId,gradeId:this.selectedSchoolItem.gradeId,lessonId:this.selectedSchoolItem.lessonId}})
                    }else if(this.user.roleId == 2){
                        this.$router.push({name:"posts.attendance.vacation",params:{schoolId:this.selectedSchoolItem.schoolId,gradeId:this.selectedSchoolItem.gradeId,lessonId:this.selectedSchoolItem.lessonId}})
                    }
                    else{
                        this.$router.push({name:item.path,params:{schoolId:this.selectedSchoolItem.schoolId,gradeId:this.selectedSchoolItem.gradeId,lessonId:this.selectedSchoolItem.lessonId}})
                    }
                }else{
                    this.$router.push({name:item.path,params:{schoolId:this.selectedSchoolItem.schoolId,gradeId:this.selectedSchoolItem.gradeId,lessonId:this.selectedSchoolItem.lessonId}})
                }
            }
        },
        navToFirst(){
            this.$router.push({name: "home"})
        },
        navToSecond(){
            this.$router.push({name: "mochat.news"})
        },
        navToThird(){
            this.$router.push({name: "circle"})
        },
        navToFourth(){
            this.$router.push({name:"profile.list"})
        },
        navToNewPost(){
            this.$router.push({name:"mo.newPost"})
        }
    }
}
</script>

<style>

</style>