<template>
    <v-container class="pa-0 pb-16">
        <v-container class="pa-0 bg-secondary position-sticky-top-0">
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex align-center justify-space-between py-1">
                    <transition name="page" mode="out-in">
                        <v-text-field
                            v-if="isSearching" key="1"
                            solo
                            clearable
                            class="mo-select-gray-bg"
                            v-model="searchKeyword"
                            label="请输入您的搜索词"
                            append-icon="mdi-check"
                            @click:append="onSearch"
                            prepend-inner-icon="mdi-magnify"
                            hide-details
                            color="#7879ff"
                            dense 
                        ></v-text-field>
                        <p v-else key="2" class="mb-0 font-color-gray-heavy" style="padding: 7px 12px"> {{selectedSchoolItem.label}}</p>
                    </transition>
                    <transition name="page" mode="out-in">
                    <v-btn icon v-if="isSearching" key="3" class="ml-3" @click="onFalseSearching">
                        <v-icon>
                        mdi-close
                        </v-icon>
                    </v-btn>
                    <v-btn icon plain v-else key="4" class="ml-3" @click="isSearching = true">
                        <v-icon size="30">
                        mdi-magnify
                        </v-icon>
                    </v-btn>
                    </transition>
                </v-col>
            </v-row>
        </v-container>
        <v-container class="pa-0" v-for="(selectItems, i) in selectItemGroup" :key="i">
            <v-row class="ma-0">
                <v-col cols="12">
                    <p class="mb-0 border-left-5 pl-2 font-size-0-8 font-weight-bold">{{selectItems.title}}</p>
                </v-col>
                <v-col class="col-50 text-center px-2 py-2" v-for="(item, j) in selectItems.items" :key="j" @click="selectItem(item)">
                    <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" width="50" height="50" class="mx-auto"></v-img>
                    <p class="font-size-0-75 pt-1 mb-0">{{item.title}}</p>
                </v-col>
            </v-row >
            <div class="cus-divider"></div>
        </v-container>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    computed:{
        ...mapGetters({
            isSchoolSpace: 'mo/isSchoolSpace',
            selectedSchoolItem: 'mo/selectedSchoolItem',
            user: 'auth/user'
        })
    },

    data: ()=> ({
        baseUrl: window.Laravel.base_url,
        schoolContentItemList : [
            {
                title : "基础沟通",//기초의사소통
                icon : "mdi-message-text",
                items : [
                    {
                        color : "#98BB3A",
                        title : "问卷",//설문조사
                        imgUrl : "/asset/img/appIcon/basicCommunity/问卷.png",
                        path : "posts.questionnaire"
                    },
                    {
                        color : "#C95384",
                        title : "投票",//투표
                        imgUrl : "/asset/img/appIcon/basicCommunity/voting.png",
                        path : "posts.voting"
                    },
                    {
                        color : "#E4BC16",
                        title : "短信",//통보문
                        imgUrl : "/asset/img/appIcon/basicCommunity/sms.png",
                        path : "posts.sms"
                    },
                    // {
                    //     color : "#7180EA",
                    //     title : "校园动态",//학원동태
                    //     imgUrl : "/asset/img/appIcon/校园文化/校园动态.png",
                    //     path : "posts.campus"
                    // },
                    {
                        color : "#3FB8E3",
                        title : "公告",//공시
                        imgUrl : "/asset/img/appIcon/homeSchool/announcement.png",
                        path : "posts.announcement"
                    },
                    {
                        color : "#E4BC16",
                        title : "分享",//공유
                        imgUrl : "/asset/img/appIcon/basicCommunity/share.png",
                        path : "posts.share"
                    },
                    {
                        color : "#C95384",
                        title : "报名",//이름등록
                        imgUrl : "/asset/img/appIcon/basicCommunity/报名.png",
                        path : "posts.regname"
                    },
                    // {
                    //     color : "#B673E0",
                    //     title : "通讯录",//주소록
                    //     imgUrl : "/asset/img/appIcon/basicCommunity/通讯录.png",
                    //     path : "something"
                    // },
                ],
            },
            // {
            //     title : "校园文化",//교내문화
            //     icon : "mdi-lifebuoy",
            //     items : [
            //         // {
            //         //     color : "#B673E0",
            //         //     title : "考勤",//출근
            //         //     imgUrl : "/asset/img/appIcon/智能考勤/考勤.png",
            //         //     path : "something"
            //         // },
            //         // {
            //         //     color : "#DA7042",
            //         //     title : "作业",//숙제
            //         //     imgUrl : "/asset/img/appIcon/homeSchool/作业.png",
            //         //     path : "posts.homework"
            //         // },
            //         // {
            //         //     color : "#3FB8E3",
            //         //     title : "班牌发布",//반표발포
            //         //     imgUrl : "/asset/img/newIcon/班牌发布.png",
            //         //     path : "something"
            //         // },
            //         // {
            //         //     color : "#7180EA",
            //         //     title : "布告栏",//게시란
            //         //     imgUrl : "/asset/img/appIcon/others/bulletinboard.png",
            //         //     path : "posts.bulletinboard"
            //         // },
            //         // {
            //         //     color : "#C95384",
            //         //     title : "学生风采",//학생풍채
            //         //     imgUrl : "/asset/img/newIcon/学生风采.png",
            //         //     path : "something"
            //         // },
                    
            //     ],
            // },
            {
                title : "家校互动",//가교호상활동
                icon : "mdi-nfc-tap",
                items : [
                    // {
                    //     color : "#3EBBE8",
                    //     title : "相册",//사진
                    //     imgUrl : "/asset/img/appIcon/工具/相册.png",
                    //     path : "something"
                    // },
                    // {
                    //     color : "#E4BC16",
                    //     title : "习题",//련습문제
                    //     imgUrl : "/asset/img/newIcon/习题.png",
                    //     path : "something"
                    // },
                    {
                        color : "#DA7042",
                        title : "家访",//가정방문
                        imgUrl : "/asset/img/appIcon/others/家访.png",
                        path : "posts.homevisit"
                    },
                    // {
                    //     color : "#7180EA",
                    //     title : "学校动态",//학교동태
                    //     imgUrl : "/asset/img/appIcon/校园文化/校园动态.png",
                    //     path : "posts.schoolStory"
                    // },
                    
                ],
            },
            // {
            //     title : "智能考勤",//지능출근
            //     icon : "mdi-calendar-month-outline",
            //     items : [
            //         {
            //             color : "#98BB3A",
            //             title : "请假",//휴가
            //             imgUrl : "/asset/img/appIcon/智能考勤/请假审批.png",
            //             path : "posts.vocation"
            //         },
            //         {
            //             color : "#E4BC16",
            //             title : "话题",//화제
            //             imgUrl : "/asset/img/newIcon/discussion.png",
            //             path : "something"
            //         },
            //     ],
            // },
            // {
            //     title : "工具",//공구
            //     icon : "mdi-hammer-wrench",
            //     items : [
            //         {
            //             color : "#98BB3A",
            //             title : "我的",//나의
            //             imgUrl : "/asset/img/newIcon/我的.png",
            //             path : "profile.list"
            //         },
            //         {
            //             color : "#7180EA",
            //             title : "话题",//화제
            //             imgUrl : "/asset/img/newIcon/discussion.png",
            //             path : "something"
            //         },
            //     ],
            // },
            {
                title : "校园安全", //safety
                icon : "mdi-message-text",
                items : [
                    {
                        color : "#98BB3A",
                        title : "交接班管理",//Shift management
                        imgUrl : "/asset/img/appIcon/校园安全/shiftMng.png",
                        path : "posts.shift"
                    },
                    {
                        color : "#7180EA",
                        title : "维修工单",//Repair work order
                        imgUrl : "/asset/img/appIcon/校园安全/维修工单.png",
                        path : "posts.repair"
                    },
                    {
                        color : "#DA7042",
                        title : "安全教育", //safe study
                        imgUrl : "/asset/img/appIcon/校园安全/闸机.png",
                        path : "posts.safeStudy"
                    },
                ],
            },
        ],
        classContentItemList : [
            {
                title : "基础沟通",
                icon : "mdi-message-text",
                items : [
                    {
                        color : "#98BB3A",
                        title : "问卷",
                        imgUrl : "/asset/img/appIcon/basicCommunity/问卷.png",
                        path : "posts.Cquestionnaire"
                    },
                    {
                        color : "#C95384",
                        title : "投票",
                        imgUrl : "/asset/img/appIcon/basicCommunity/voting.png",
                        path : "posts.Cvoting"
                    },
                ],
            },
            {
                title : "家校互动",
                icon : "mdi-nfc-tap",
                items : [
                    {
                        color : "#DA7042",
                        title : "作业",
                        imgUrl : "/asset/img/appIcon/homeSchool/作业.png",
                        path : "posts.Chomework"
                    },
                    {
                        color : "#E4BC16",
                        title : "习题",
                        imgUrl : "/asset/img/newIcon/习题.png",
                        path : "something"
                    },
                    {
                        color : "#DA7042",
                        title : "家访",
                        imgUrl : "/asset/img/appIcon/others/家访.png",
                        path : "posts.Chomevisit"
                    },
                    {
                        color : "#EB5846",
                        title : "班级动态",
                        imgUrl : "/asset/img/appIcon/校园文化/班级动态.png",
                        path : "posts.classStory"
                    },
                    {
                        color : "#EB5846",
                        title : "班际动态",
                        imgUrl : "/asset/img/appIcon/校园文化/班际动态.png",
                        path : "posts.interClassStory"
                    },
                ],
            },
            {
                title : "移动办公",
                icon : "mdi-calendar-month-outline",
                items : [
                    {
                        color : "red accent-3",
                        title : "通知",
                        imgUrl : "/asset/img/icon/通知 拷贝.png",
                        path : "posts.Cnotification"
                    },
                ],
            },
            {
                title : "数字德育",
                icon : "mdi-calendar-month-outline",
                items : [
                    {
                        color : "lime darken-4",
                        title : "评价",
                        imgUrl : "/asset/img/icon/评价.png",
                        path : "posts.Cevaluation"
                    },
                    {
                        color : "lime darken-4",
                        title : "表彰",
                        imgUrl : "/asset/img/icon/recognition.png",
                        path : "posts.Crecognition"
                    },
                ],
            },
            {
                title : "工具",
                icon : "mdi-calendar-month-outline",
                items : [
                    {
                        color : "indigo accent-2",
                        title : "课表",
                        imgUrl : "/asset/img/appIcon/智能考勤/课程表.png",
                        path : "something"
                    },
                    {
                        color : "#3EBBE8",
                        title : "相册",
                        imgUrl : "/asset/img/appIcon/工具/相册.png",
                        path : "posts.Calbum"
                    },
                    {
                        color : "indigo accent-2",
                        title : "文件",
                        imgUrl : "/asset/img/appIcon/basicCommunity/文件.png",
                        path : "file"
                    },
                ],
            },
            {
                title : "校园安全",
                icon : "mdi-safe",
                items : [
                    {
                        color : "indigo accent-2",
                        title : "访客管理",
                        imgUrl : "/asset/img/appIcon/校园安全/访客管理.png",
                        path : "manageGuests"
                    },
                ],
            },
        ],

        isSearching: false,
        searchKeyword: '',
    }),

    created(){
        console.log("this.selectedSchoolItem", this.selectedSchoolItem);
        if(this.selectedSchoolItem == null){
            return this.$router.push({name: 'home'});
        }
        if(this.isSchoolSpace == true){
            this.selectItemGroup = this.schoolContentItemList;
        }
        else{
            this.selectItemGroup = this.classContentItemList;
        }
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

        onSearch(){
        },
        onFalseSearching(){
            this.isSearching = false;
            this.searchKeyword = '';
        },
    }

}
</script>

<style>

</style>