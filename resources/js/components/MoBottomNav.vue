<template>
    <div class="position-fixed mo-bottom-nav-con">
        <v-bottom-navigation
            v-model="value"
            color="#7879ff"
            grow
            fixed
            class="mo-glow-bg mo-bottom-nav"
        >
            <v-btn fab class="mo-glow-small-shadow ml-3">
                <span>首页</span>
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-btn fab class="mo-glow-small-shadow mx-3 mr-auto">
                <span>通讯录</span>
                <v-icon>mdi-account-group</v-icon>
            </v-btn>
           
            <v-btn fab class="mo-glow-small-shadow mx-3 ml-auto">
                <span>圈子</span>
                <v-icon>mdi-fire-hydrant</v-icon>
            </v-btn>
            <v-btn fab class="mo-glow-small-shadow mr-3">
                <span>我的</span>
                <v-icon>mdi-account</v-icon>
            </v-btn>
        </v-bottom-navigation>
         <v-btn fab dark class="position-absolute mo-bottom-nav-plut-btn" large color="#7879ff"
            @click="openSheet"
            >
            <v-icon>
                mdi-plus
            </v-icon>
        </v-btn>
        <v-bottom-sheet v-model="sheet" :scrollable="true" content-class="child-bottom-sheet" overlay-color="#7879ff" >
            <v-sheet height="250px" class="mo-glow-bg" v-if="isSchoolSpace">
                <carousel :nav="false" :items="1" :loop="true" :dots="false">
                    <v-card class="mo-bottom-nav-carousel-card d-flex align-start">
                        <v-row class="ma-0 pa-0 mt-3">
                            <v-col cols="3" class="pa-0 d-flex justify-center mt-3 mb-3" v-for="(item, i) in first_carousel_schoolspace" :key="i" @click="selectItem(item)">
                                <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                                    <div class="text-center">
                                        <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" width="30" height="30" class="mx-auto"></v-img>
                                        <span class="font-size-0-75 pt-2"> {{item.title}}</span>
                                    </div>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-card class="mo-bottom-nav-carousel-card d-flex align-start">
                        <v-row class="ma-0 pa-0 mt-3">
                            <v-col cols="3" class="pa-0 d-flex justify-center mt-3 mb-3" v-for="(item, i) in second_carousel_schoolspace" :key="i" @click="selectItem(item)">
                                <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                                    <div class="text-center">
                                        <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" width="30" height="30" class="mx-auto"></v-img>
                                        <span class="font-size-0-75 pt-2"> {{item.title}}</span>
                                    </div>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card>
                </carousel>
            </v-sheet>
            <v-sheet height="250px" class="mo-glow-bg" v-else>
                <carousel :nav="false" :items="1" :loop="true" :dots="false">
                    <v-card class="mo-bottom-nav-carousel-card d-flex align-start">
                        <v-row class="ma-0 pa-0 mt-3">
                            <v-col cols="3" class="pa-0 d-flex justify-center mt-3 mb-3" v-for="(item, i) in first_carousel_classspace" :key="i" @click="selectItem(item)">
                                <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                                    <div class="text-center">
                                        <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" width="30" height="30" class="mx-auto"></v-img>
                                        <span class="font-size-0-75 pt-2"> {{item.title}}</span>
                                    </div>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-card class="mo-bottom-nav-carousel-card d-flex align-start">
                        <v-row class="ma-0 pa-0 mt-3">
                            <v-col cols="3" class="pa-0 d-flex justify-center mt-3 mb-3" v-for="(item, i) in second_carousel_classspace" :key="i" @click="selectItem(item)">
                                <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                                    <div class="text-center">
                                        <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" width="30" height="30" class="mx-auto"></v-img>
                                        <span class="font-size-0-75 pt-2"> {{item.title}}</span>
                                    </div>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card>
                </carousel>
            </v-sheet>
        </v-bottom-sheet>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import carousel from 'v-owl-carousel'
export default {
    components:{
        carousel,
    },
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
            console.log("sss", val)
            },
            deep: true
        },
        currentPath:{
            handler(val){
                if(val.name=="home"){
                    this.value = 0
                    // let btnList = document.getElementsByClassName('mo-glow-small-shadow');
                    // btnList[0].classList.add('v-btn--active');
                }
                else if(val.name=="chat"){
                    this.value = 1
                }
                else{
                    this.value = -1
                    let btnList = document.getElementsByClassName('mo-glow-small-shadow');
                    for(let i = 0; i < btnList.length; i++){
                        btnList[i].classList.remove('v-btn--active');
                    }
                }
                console.log("this.value", this.value);
            },
            deep: true
        }
    },
    data: ()=> ({
        sheet: false,
        value: 0,
        baseUrl: window.Laravel.base_url,
        first_carousel_schoolspace: [
            {
                title : "问卷",
                imgUrl : "/asset/img/icon/问卷 拷贝.png",
                path : "posts.questionnaire"
            },
            {
                title : "投票",
                imgUrl : "/asset/img/icon/投票.png",
                path : "posts.voting"
            },
            {
                title : "短信",
                imgUrl : "/asset/img/icon/短信 拷贝.png",
                path : "posts.sms"
            },
            {
                title : "校园动态",
                imgUrl : "/asset/img/icon/动态 拷贝.png",
                path : "posts.campus"
            },
            {
                title : "公告",
                imgUrl : "/asset/img/icon/公告 拷贝.png",
                path : "posts.announcement"
            },
            {
                title : "分享",
                imgUrl : "/asset/img/icon/分享.png",
                path : "posts.share"
            },
            {
                title : "布告栏",
                imgUrl : "/asset/img/icon/布告栏 拷贝.png",
                path : "posts.bulletinboard"
            },
            {
                title : "考勤",
                imgUrl : "/asset/img/icon/考勤.png",
                path : "something"
            },
        ],
        second_carousel_schoolspace: [
            {
                title : "作业",
                imgUrl : "/asset/img/icon/作业 拷贝.png",
                path : "something"
            },
            {
                title : "习题",
                imgUrl : "/asset/img/icon/习题.png",
                path : "something"
            },
            {
                title : "家访",
                imgUrl : "/asset/img/icon/家访 拷贝.png",
                path : "posts.homevisit"
            },
            {
                title : "报名",
                imgUrl : "/asset/img/icon/报名 拷贝.png",
                path : "posts.regname"
            },
            {
                title : "请假",
                imgUrl : "/asset/img/icon/请假.png",
                path : "posts.vocation"
            },
        ],
        first_carousel_classspace: [
            {
                title : "问卷",
                imgUrl : "/asset/img/icon/问卷 拷贝.png",
                path : "posts.Cquestionnaire"
            },
            {
                title : "投票",
                imgUrl : "/asset/img/icon/投票.png",
                path : "posts.Cvoting"
            },
            {
                title : "作业",
                imgUrl : "/asset/img/icon/作业 拷贝.png",
                path : "something"
            },
            {
                title : "习题",
                imgUrl : "/asset/img/icon/习题.png",
                path : "something"
            },
            {
                title : "家访",
                imgUrl : "/asset/img/icon/家访 拷贝.png",
                path : "posts.Chomevisit"
            },
            {
                title : "通知",
                imgUrl : "/asset/img/icon/通知 拷贝.png",
                path : "posts.Cnotification"
            },
            {
                title : "评价",
                imgUrl : "/asset/img/icon/评价.png",
                path : "posts.Cevaluation"
            },
            {
                title : "表彰",
                imgUrl : "/asset/img/icon/表彰.png",
                path : "posts.Crecognition"
            },
        ],
        second_carousel_classspace: [
            {
                title : "课表",
                imgUrl : "/asset/img/icon/组 29.png",
                path : "something"
            },
            {
                title : "相册",
                imgUrl : "/asset/img/icon/相册.png",
                path : "posts.Calbum"
            },
            {
                title : "文件",
                imgUrl : "/asset/img/icon/文件.png",
                path : "file"
            },
        ]
    }),

    
    
    created(){
        
    },
    methods:{
        openSheet(){
            this.sheet = !this.sheet;
        },
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
        }
    }
}
</script>

<style>

</style>