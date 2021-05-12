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
            <!-- <v-btn fab plain :ripple="false" class="mo-bottom-nav-btn-item " @click="navToFirst">
                <span>首页</span>
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-btn fab plain :ripple="false" class="mo-bottom-nav-btn-item " >
                <span>通讯录</span>
                <v-icon>mdi-account-group</v-icon>
            </v-btn>

            <v-btn v-if="isNewPost" :ripple="false" fab dark depressed class="" color="#7879ff" @click="$router.go(-1)" >
                <v-icon> mdi-minus </v-icon>
            </v-btn>
            
            <v-btn v-else fab dark :ripple="false" depressed class="" color="#7879ff" @click="navToNewPost" >
                <v-icon> mdi-plus </v-icon>
            </v-btn>
           
            <v-btn fab plain :ripple="false" class="mo-bottom-nav-btn-item " @click="navToThird">
                <span>圈子</span>
                <v-icon>mdi-fire-hydrant</v-icon>
            </v-btn>
            <v-btn fab plain :ripple="false" class="mo-bottom-nav-btn-item " @click="navToFourth">
                <span>我的</span>
                <v-icon>mdi-account</v-icon>
            </v-btn> -->
            <v-btn :ripple="false"  @click="navToFirst">
                <span>首页</span>
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-btn :ripple="false" @click="navToSecond">
                <span>通讯录</span>
                <v-icon>mdi-account-group</v-icon>
            </v-btn>
            <div class="pa-1 h-100 px-5">
                <v-btn v-if="isNewPost" :ripple="false" fab dark depressed class="mo-bottom-center-btn" color="#7879ff" @click="$router.go(-1)" >
                    <v-icon color="white"> mdi-minus </v-icon>
                </v-btn>
                <v-btn v-else fab dark :ripple="false" depressed class="mo-bottom-center-btn" color="#7879ff" @click="navToNewPost" >
                    <v-icon color="white"> mdi-plus </v-icon>
                </v-btn>
            </div>
            <v-btn :ripple="false" @click="navToThird">
                <span>圈子</span>
                <v-icon>mdi-fire-hydrant</v-icon>
            </v-btn>
            <v-btn :ripple="false" @click="navToFourth">
                <span>我的</span>
                <v-icon>mdi-account</v-icon>
            </v-btn>
        </v-bottom-navigation>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    computed:{
        ...mapGetters({
            isSchoolSpace: 'mo/isSchoolSpace',
            selectedSchoolItem: 'mo/selectedSchoolItem',
            user: 'auth/user',
            value: 'mo/value',
            isNewPost: 'mo/isNewPost'
        }),
        // value: {
        //     get() {
        //         return this.$store.state.mo.value;
        //     },
        //     set(value) {
        //             this.$store.dispatch('mo/onMoBottomNavValue', {
        //             value: value,
        //         })
        //     }
        // },

        currentPath(){
            return this.$route
        },
        

    },
    watch:{
        selectedSchoolItem: {
            handler(val){
            },
            deep: true
        },
        currentPath:{
            handler(val){
                if(val.name!=="home" && val.name!=="chatMobile" && val.name!=="mochat.news" && val.name!=="mochat.detail" && val.name!=="mochat.contact" && val.name!=="circle" && val.name!=="profile.list"){
                    let btnList = document.getElementsByClassName('mo-bottom-nav-btn-item');
                    for(let i = 0; i < btnList.length; i++){
                        btnList[i].classList.remove('v-btn--active');
                        $(btnList[i]).removeClass('v-btn--active');
                    }
                }
            },
            deep: true
        }
    },
    data: ()=> ({
        active: true,
        sheet: false,
        baseUrl: window.Laravel.base_url,
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
            if(this.currentPath.name == 'home'){
                return
            }
            else{
                this.$store.dispatch('mo/onMoBottomNavValue', 0);
                this.$router.push({name: "home"})
            }
        },
        navToSecond(){
            if(this.currentPath.name == 'mochat.news'){
                return
            }
            else{
                this.$store.dispatch('mo/onMoBottomNavValue', 1);
                this.$router.push({name: "mochat.news"})
            }
        },
        navToThird(){
            if(this.currentPath.name == 'circle'){
                return
            }
            else{
                this.$store.dispatch('mo/onMoBottomNavValue', 3);
                this.$router.push({name: "circle"})
            }
        },
        navToFourth(){
            if(this.currentPath.name == 'profile.list'){
                return
            }
            else{
                this.$store.dispatch('mo/onMoBottomNavValue', 4);
                this.$router.push({name:"profile.list"})
            }
        },
        navToNewPost(){
            if(this.currentPath.name == 'mo.newPost'){
                return
            }
            else{
                this.$store.dispatch('mo/onMoBottomNavValue', null);
                this.$router.push({name:"mo.newPost"})
            }
        }
    }
}
</script>

<style>

</style>