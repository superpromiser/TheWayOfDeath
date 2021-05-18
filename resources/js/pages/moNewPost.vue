<template>
    <v-container class="pa-0 pb-16 h-100 bg-secondary pt-12">
        <v-container class="pa-0 bg-white position-sticky-top-0">
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex align-center justify-space-between py-1">
                    <transition name="page" mode="out-in">
                        <v-text-field
                            v-if="isSearching" key="1"
                            solo
                            class="mo-search-input-text-field"
                            v-model="searchKeyword"
                            label="请输入您的搜索词"
                            prepend-inner-icon="mdi-magnify"
                            hide-details
                            color="#7879ff"
                            dense 
                            >
                            <v-icon
                                v-if="searchKeyword.trim() !== ''"
                                slot="append"
                                @click="searchKeyword = ''"
                                small
                                >
                                mdi-close-circle
                            </v-icon>
                        </v-text-field>
                        <p v-else key="2" class="mb-0 font-color-gray-heavy" style="padding: 7px 12px"> {{selectedSchoolItem.label}}</p>
                    </transition>
                    <transition name="page" mode="out-in">
                    <v-btn text small v-if="isSearching" key="3" class="ml-3 px-0 min-width-0" @click="onFalseSearching">
                        取消
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
            <v-row class="ma-3 bg-white rounded-lg">
                <v-col cols="12">
                    <p class="mb-0 border-left-5 pl-2 font-size-0-8 font-weight-bold">{{selectItems.title}}</p>
                </v-col>
                <v-col class="col-50 text-center px-2 py-2" v-for="(item, j) in selectItems.items" :key="j" @click="selectItem(item)">
                    <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" width="50" height="50" class="mx-auto"></v-img>
                    <p class="font-size-0-75 pt-1 mb-0">{{item.title}}</p>
                </v-col>
            </v-row >
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
        schoolContentItemList : [],
        classContentItemList : [],
        isSearching: false,
        searchKeyword: '',

        adminSchoolContents:[
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                        path:"posts.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                        path:"posts.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                        path:"posts.regname"
                    },
                ]
            },
            {
                title:"家校互动",
                icon:"mdi-nfc-tap",
                items:[
                     {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                        path:"posts.announcement"
                    }
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/manageGuests.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#98BB3A",
                        title:"交接班",//교대반관리
                        imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
                        path:"posts.shift"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                        path:"posts.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                        path:"posts.safeStudy"
                    },
                ]
            },
            {
                title:"校园文化",//
                icon:"mdi-lifebuoy",
                items:[
                    
                    {
                        color:"#C95384",
                        title:"学校动态",//학교동태
                        imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
                        path:"posts.schoolStory",

                    },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.Crecognition",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"教师风采",//교사풍모
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//교사풍모
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.",

                    // },
                ]
            },
        ],
        managerSchoolContents: [
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                        path:"posts.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                        path:"posts.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                        path:"posts.regname"
                    },
                ]
            },
            {
                title:"家校互动",
                icon:"mdi-nfc-tap",
                items:[
                     {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                        path:"posts.announcement"
                    }
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/manageGuests.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#98BB3A",
                        title:"交接班",//교대반관리
                        imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
                        path:"posts.shift"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                        path:"posts.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                        path:"posts.safeStudy"
                    },
                ]
            },
            {
                title:"校园文化",//
                icon:"mdi-lifebuoy",
                items:[
                    
                    {
                        color:"#C95384",
                        title:"学校动态",//학교동태
                        imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
                        path:"posts.schoolStory",

                    },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.Crecognition",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"教师风采",//교사풍모
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//교사풍모
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.",

                    // },
                ]
            },
        ],
        teacherSchoolContents : [
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                        path:"posts.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                        path:"posts.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                        path:"posts.regname"
                    },
                ]
            },
            {
                title:"家校互动",
                icon:"mdi-nfc-tap",
                items:[
                     {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                        path:"posts.announcement"
                    }
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/manageGuests.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#98BB3A",
                        title:"交接班",//교대반관리
                        imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
                        path:"posts.shift"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                        path:"posts.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                        path:"posts.safeStudy"
                    },
                ]
            },
            {
                title:"校园文化",//
                icon:"mdi-lifebuoy",
                items:[
                    
                    {
                        color:"#C95384",
                        title:"学校动态",//학교동태
                        imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
                        path:"posts.schoolStory",

                    },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.Crecognition",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"教师风采",//교사풍모
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//교사풍모
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.",

                    // },
                ]
            },
        ],
        parentSchoolContents : [
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    // {
                    //     color:"#B673E0",
                    //     title:"问卷",//설문
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                    //     path:"posts.questionnaire"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"投票",//투표
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                    //     path:"posts.voting"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"报名",//이름등록
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                    //     path:"posts.regname"
                    // },
                ]
            },
            {
                title:"家校互动",
                icon:"mdi-nfc-tap",
                items:[
                     {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    // {
                    //     color:"#E4BC16",
                    //     title:"公告",//공시
                    //     imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                    //     path:"posts.announcement"
                    // }
                ]
            },
            // {
            //     title:"校园安全",//교내안전
            //     icon:"mdi-account-cog-outline",
            //     items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"交接班",//교대반관리
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
                    //     path:"posts.shift"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"维修工单",//수리공
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                    //     path:"posts.repair"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"安全教育",//안전교육
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                    //     path:"posts.safeStudy"
                    // },
            //     ]
            // },
            // {
            //     title:"校园文化",//
            //     icon:"mdi-lifebuoy",
            //     items:[
                    
                    // {
                    //     color:"#C95384",
                    //     title:"学校动态",//학교동태
                    //     imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
                    //     path:"posts.schoolStory",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.Crecognition",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"教师风采",//교사풍모
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//교사풍모
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.",

                    // },
        //         ]
        //     },
        ],
        studentSchoolContents : [
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    // {
                    //     color:"#B673E0",
                    //     title:"问卷",//설문
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                    //     path:"posts.questionnaire"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"投票",//투표
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                    //     path:"posts.voting"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"报名",//이름등록
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                    //     path:"posts.regname"
                    // },
                ]
            },
            {
                title:"家校互动",
                icon:"mdi-nfc-tap",
                items:[
                     {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.share"
                    },
                    // {
                    //     color:"#E4BC16",
                    //     title:"公告",//공시
                    //     imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                    //     path:"posts.announcement"
                    // }
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"交接班",//교대반관리
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
                    //     path:"posts.shift"
                    // },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                        path:"posts.repair"
                    },
                    // {
                    //     color:"#98BB3A",
                    //     title:"安全教育",//안전교육
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                    //     path:"posts.safeStudy"
                    // },
                ]
            },
            // {
            //     title:"校园文化",//
            //     icon:"mdi-lifebuoy",
            //     items:[
                    
                    // {
                    //     color:"#C95384",
                    //     title:"学校动态",//학교동태
                    //     imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
                    //     path:"posts.schoolStory",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.Crecognition",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"教师风采",//교사풍모
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//교사풍모
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.",

                    // },
            //     ]
            // },
        ],

        adminClassContents:[
            // {
            //     title:"智能考勤",//지능출근
            //     icon:"mdi-calendar-month-outline",
            //     items:[
                    // {
                    //     color:"#3EBBE8",
                    //     title:"课程维护",//수업유지
                    //     imgUrl:"/asset/img/newIcon/schedule.png",
                    //     path:"admin.schedule"
                    // },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"请假单",//휴가신청
                    //     imgUrl:"/asset/img/appIcon/attendance/vocationRequest.png",
                    //     path:"posts.vocation"
                    // },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"请假审批",//휴가심사
                    //     imgUrl:"/asset/img/appIcon/attendance/vocationReply.png",
                    //     path:"posts.vocation"
                    // },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"考勤",//출근
                    //     imgUrl:"/asset/img/newIcon/attendance.png",
                    //     path:"posts.attendance"
                    // },
            //         {
            //             color:"#3EBBE8",
            //             title:"课程表",//시간표
            //             imgUrl:"/asset/img/appIcon/attendance/scheduleClass.png",
            //             path:"admin.scheduleClass"
            //         },
            //     ]
            // },
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    // {
                    //     color:"#B673E0",
                    //     title:"通讯录",//주소록
                    //     imgUrl:"/asset/img/newIcon/member.png",
                    //     path:"schoolSpace.member"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"文件",//문건
                    //     imgUrl:"/asset/img/newIcon/file.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"话题",//화제
                    //     imgUrl:"/asset/img/newIcon/discussion.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                        path:"posts.Cquestionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                        path:"posts.Cvoting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                        path:"posts.CregName"
                    },
                ]
            },
            {
                title:"家校互动",//가교호상활동
                icon:"mdi-nfc-tap",
                items:[
                    
                    {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                        path:"posts.Cannouncement"
                    },
                    // {
                    //     color:"#E4BC16",
                    //     title:"作业",//숙제
                    //     imgUrl:"/asset/img/appIcon/homeSchool/homework.png",
                    //     path:"posts.Chomework"
                    // },
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/manageGuests.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"归程队",//귀한팀관리
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/returnTeam.png",
                    //     path:"classSpace.applications.returnTeam"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"打卡管理",//카드긋기
                    //     imgUrl:"/asset/img/newIcon/cardcheck.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                        path:"posts.Crepair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                        path:"posts.CsafeStudy"
                    },
                ]
            },
            {
                title:"校园文化",//
                icon:"mdi-lifebuoy",
                items:[
                    {
                        color:"#C95384",
                        title:"班级动态",//학급동태
                        imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
                        path:"posts.classStory",

                    },
                    {
                        color:"#C95384",
                        title:"班际动态",//학급별동태
                        imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
                        path:"posts.interClassStory",
                    },
                    {
                        color:"#C95384",
                        title:"表彰",//영예표창
                        imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                        path:"posts.Crecognition",

                    },
                ]
            },
        ],
        managerClassContents:[
            // {
            //     title:"智能考勤",//지능출근
            //     icon:"mdi-calendar-month-outline",
                // items:[
                    // {
                    //     color:"#3EBBE8",
                    //     title:"课程维护",//수업유지
                    //     imgUrl:"/asset/img/newIcon/schedule.png",
                    //     path:"admin.schedule"
                    // },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"请假单",//휴가신청
                    //     imgUrl:"/asset/img/appIcon/attendance/vocationRequest.png",
                    //     path:"posts.vocation"
                    // },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"请假审批",//휴가심사
                    //     imgUrl:"/asset/img/appIcon/attendance/vocationReply.png",
                    //     path:"posts.vocation"
                    // },
            //         {
            //             color:"#3EBBE8",
            //             title:"考勤",//출근
            //             imgUrl:"/asset/img/newIcon/attendance.png",
            //             path:"posts.attendance"
            //         },
            //         {
            //             color:"#3EBBE8",
            //             title:"课程表",//시간표
            //             imgUrl:"/asset/img/appIcon/attendance/scheduleClass.png",
            //             path:"admin.scheduleClass"
            //         },
            //     ]
            // },
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    // {
                    //     color:"#B673E0",
                    //     title:"通讯录",//주소록
                    //     imgUrl:"/asset/img/newIcon/member.png",
                    //     path:"schoolSpace.member"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"文件",//문건
                    //     imgUrl:"/asset/img/newIcon/file.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"话题",//화제
                    //     imgUrl:"/asset/img/newIcon/discussion.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                        path:"posts.Cquestionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                        path:"posts.Cvoting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                        path:"posts.CregName"
                    },
                ]
            },
            {
                title:"家校互动",//가교호상활동
                icon:"mdi-nfc-tap",
                items:[
                    
                    {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                        path:"posts.Cannouncement"
                    },
                    // {
                    //     color:"#E4BC16",
                    //     title:"作业",//숙제
                    //     imgUrl:"/asset/img/appIcon/homeSchool/homework.png",
                    //     path:"posts.Chomework"
                    // },
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/manageGuests.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"归程队",//귀한팀관리
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/returnTeam.png",
                    //     path:"classSpace.applications.returnTeam"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"打卡管理",//카드긋기
                    //     imgUrl:"/asset/img/newIcon/cardcheck.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                        path:"posts.Crepair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                        path:"posts.CsafeStudy"
                    },
                ]
            },
            {
                title:"校园文化",//
                icon:"mdi-lifebuoy",
                items:[
                    {
                        color:"#C95384",
                        title:"班级动态",//학급동태
                        imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
                        path:"posts.classStory",

                    },
                    {
                        color:"#C95384",
                        title:"班际动态",//학급별동태
                        imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
                        path:"posts.interClassStory",
                    },
                    {
                        color:"#C95384",
                        title:"表彰",//영예표창
                        imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                        path:"posts.Crecognition",

                    },
                ]
            },
        ],
        teacherClassContents:[
            {
                title:"智能考勤",//지능출근
                icon:"mdi-calendar-month-outline",
                items:[
                    // {
                    //     color:"#3EBBE8",
                    //     title:"课程维护",//수업유지
                    //     imgUrl:"/asset/img/newIcon/schedule.png",
                    //     path:"admin.schedule"
                    // },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"请假单",//휴가신청
                    //     imgUrl:"/asset/img/appIcon/attendance/vocationRequest.png",
                    //     path:"posts.vocation"
                    // },
                    {
                        color:"#3EBBE8",
                        title:"请假审批",//휴가심사
                        imgUrl:"/asset/img/appIcon/attendance/vocationReply.png",
                        path:"posts.vocation"
                    },
            //         {
            //             color:"#3EBBE8",
            //             title:"考勤",//출근
            //             imgUrl:"/asset/img/newIcon/attendance.png",
            //             path:"posts.attendance"
            //         },
                    {
                        color:"#3EBBE8",
                        title:"课程表",//시간표
                        imgUrl:"/asset/img/appIcon/attendance/scheduleClass.png",
                        path:"admin.scheduleClass"
                    },
                ]
            },
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    // {
                    //     color:"#B673E0",
                    //     title:"通讯录",//주소록
                    //     imgUrl:"/asset/img/newIcon/member.png",
                    //     path:"schoolSpace.member"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"文件",//문건
                    //     imgUrl:"/asset/img/newIcon/file.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"话题",//화제
                    //     imgUrl:"/asset/img/newIcon/discussion.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                        path:"posts.Cquestionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                        path:"posts.Cvoting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                        path:"posts.CregName"
                    },
                ]
            },
            {
                title:"家校互动",//가교호상활동
                icon:"mdi-nfc-tap",
                items:[
                    
                    {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                        path:"posts.Cannouncement"
                    },
                    {
                        color:"#E4BC16",
                        title:"作业",//숙제
                        imgUrl:"/asset/img/appIcon/homeSchool/homework.png",
                        path:"posts.Chomework"
                    },
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/manageGuests.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#98BB3A",
                        title:"归程队",//귀한팀관리
                        imgUrl:"/asset/img/appIcon/schoolSafety/returnTeam.png",
                        path:"classSpace.applications.returnTeam"
                    },
                    // {
                    //     color:"#98BB3A",
                    //     title:"打卡管理",//카드긋기
                    //     imgUrl:"/asset/img/newIcon/cardcheck.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                        path:"posts.Crepair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                        path:"posts.CsafeStudy"
                    },
                ]
            },
            {
                title:"校园文化",//
                icon:"mdi-lifebuoy",
                items:[
                    {
                        color:"#C95384",
                        title:"班级动态",//학급동태
                        imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
                        path:"posts.classStory",

                    },
                    {
                        color:"#C95384",
                        title:"班际动态",//학급별동태
                        imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
                        path:"posts.interClassStory",
                    },
                    {
                        color:"#C95384",
                        title:"表彰",//영예표창
                        imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                        path:"posts.Crecognition",

                    },
                ]
            },
        ],
        parentClassContents:[
            // {
                // title:"智能考勤",//지능출근
                // icon:"mdi-calendar-month-outline",
                // items:[
                    // {
                    //     color:"#3EBBE8",
                    //     title:"课程维护",//수업유지
                    //     imgUrl:"/asset/img/newIcon/schedule.png",
                    //     path:"admin.schedule"
                    // },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"请假单",//휴가신청
                    //     imgUrl:"/asset/img/appIcon/attendance/vocationRequest.png",
                    //     path:"posts.vocation"
                    // },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"请假审批",//휴가심사
                    //     imgUrl:"/asset/img/appIcon/attendance/vocationReply.png",
                    //     path:"posts.vocation"
                    // },
            //         {
            //             color:"#3EBBE8",
            //             title:"考勤",//출근
            //             imgUrl:"/asset/img/newIcon/attendance.png",
            //             path:"posts.attendance"
            //         },
            //         {
            //             color:"#3EBBE8",
            //             title:"课程表",//시간표
            //             imgUrl:"/asset/img/appIcon/attendance/scheduleClass.png",
            //             path:"admin.scheduleClass"
            //         },
            //     ]
            // },
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    // {
                    //     color:"#B673E0",
                    //     title:"通讯录",//주소록
                    //     imgUrl:"/asset/img/newIcon/member.png",
                    //     path:"schoolSpace.member"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"文件",//문건
                    //     imgUrl:"/asset/img/newIcon/file.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"话题",//화제
                    //     imgUrl:"/asset/img/newIcon/discussion.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    // {
                    //     color:"#B673E0",
                    //     title:"问卷",//설문
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                    //     path:"posts.Cquestionnaire"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"投票",//투표
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                    //     path:"posts.Cvoting"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"报名",//이름등록
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                    //     path:"posts.regname"
                    // },
                ]
            },
            {
                title:"家校互动",//가교호상활동
                icon:"mdi-nfc-tap",
                items:[
                    
                    {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    // {
                    //     color:"#E4BC16",
                    //     title:"公告",//공시
                    //     imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                    //     path:"posts.announcement"
                    // },
                    // {
                    //     color:"#E4BC16",
                    //     title:"作业",//숙제
                    //     imgUrl:"/asset/img/appIcon/homeSchool/homework.png",
                    //     path:"posts.Chomework"
                    // },
                ]
            },
            // {
            //     title:"校园安全",//교내안전
            //     icon:"mdi-account-cog-outline",
            //     items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/manageGuests.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"归程队",//귀한팀관리
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/returnTeam.png",
                    //     path:"classSpace.applications.returnTeam"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"打卡管理",//카드긋기
                    //     imgUrl:"/asset/img/newIcon/cardcheck.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"维修工单",//수리공
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                    //     path:"posts.Crepair"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"安全教育",//안전교육
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                    //     path:"posts.safeStudy"
                    // },
            //     ]
            // },
            // {
            //     title:"校园文化",//
            //     icon:"mdi-lifebuoy",
            //     items:[
                    // {
                    //     color:"#C95384",
                    //     title:"班级动态",//학급동태
                    //     imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
                    //     path:"posts.classStory",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"班际动态",//학급별동태
                    //     imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
                    //     path:"posts.interClassStory",
                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.Crecognition",

                    // },
            //     ]
            // },
        ],
        studentClassContents:[
            {
                title:"智能考勤",//지능출근
                icon:"mdi-calendar-month-outline",
                items:[
                    // {
                    //     color:"#3EBBE8",
                    //     title:"课程维护",//수업유지
                    //     imgUrl:"/asset/img/newIcon/schedule.png",
                    //     path:"admin.schedule"
                    // },
                    {
                        color:"#3EBBE8",
                        title:"请假单",//휴가신청
                        imgUrl:"/asset/img/appIcon/attendance/vocationRequest.png",
                        path:"posts.Cvacation"
                    },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"请假审批",//휴가심사
                    //     imgUrl:"/asset/img/appIcon/attendance/vocationReply.png",
                    //     path:"posts.vocation"
                    // },
            //         {
            //             color:"#3EBBE8",
            //             title:"考勤",//출근
            //             imgUrl:"/asset/img/newIcon/attendance.png",
            //             path:"posts.attendance"
            //         },
            //         {
            //             color:"#3EBBE8",
            //             title:"课程表",//시간표
            //             imgUrl:"/asset/img/appIcon/attendance/scheduleClass.png",
            //             path:"admin.scheduleClass"
            //         },
                ]
            },
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    // {
                    //     color:"#B673E0",
                    //     title:"通讯录",//주소록
                    //     imgUrl:"/asset/img/newIcon/member.png",
                    //     path:"schoolSpace.member"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"文件",//문건
                    //     imgUrl:"/asset/img/newIcon/file.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"话题",//화제
                    //     imgUrl:"/asset/img/newIcon/discussion.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    // {
                    //     color:"#B673E0",
                    //     title:"问卷",//설문
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
                    //     path:"posts.Cquestionnaire"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"投票",//투표
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
                    //     path:"posts.Cvoting"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"报名",//이름등록
                    //     imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
                    //     path:"posts.regname"
                    // },
                ]
            },
            {
                title:"家校互动",//가교호상활동
                icon:"mdi-nfc-tap",
                items:[
                    
                    {
                        color:"#E4BC16",
                        title:"分享",//공유
                        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
                        path:"posts.Cshare"
                    },
                    // {
                    //     color:"#E4BC16",
                    //     title:"公告",//공시
                    //     imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
                    //     path:"posts.announcement"
                    // },
                    // {
                    //     color:"#E4BC16",
                    //     title:"作业",//숙제
                    //     imgUrl:"/asset/img/appIcon/homeSchool/homework.png",
                    //     path:"posts.Chomework"
                    // },
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    // {
                    //     color:"#98BB3A",
                    //     title:"访客管理",//방문자관리
                    //     imgUrl:"/asset/img/newIcon/manageGuests.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"归程队",//귀한팀관리
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/returnTeam.png",
                    //     path:"classSpace.applications.returnTeam"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"打卡管理",//카드긋기
                    //     imgUrl:"/asset/img/newIcon/cardcheck.png",
                    //     path:"posts."
                    // },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
                        path:"posts.Crepair"
                    },
                    // {
                    //     color:"#98BB3A",
                    //     title:"安全教育",//안전교육
                    //     imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
                    //     path:"posts.safeStudy"
                    // },
                ]
            },
            // {
            //     title:"校园文化",//
            //     icon:"mdi-lifebuoy",
            //     items:[
                    // {
                    //     color:"#C95384",
                    //     title:"班级动态",//학급동태
                    //     imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
                    //     path:"posts.classStory",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"班际动态",//학급별동태
                    //     imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
                    //     path:"posts.interClassStory",
                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
                    //     path:"posts.Crecognition",

                    // },
            //     ]
            // },
        ]

    }),

    created(){
        if(this.user.roleId == 1){
            this.schoolContentItemList = this.adminSchoolContents;
            this.classContentItemList = this.adminClassContents;
        }
        else if(this.user.roleId == 2){
            this.schoolContentItemList = this.managerSchoolContents;
            this.classContentItemList = this.managerClassContents;
        }
        else if(this.user.roleId == 3 || this.user.roleId == 7){
            this.schoolContentItemList = this.teacherSchoolContents;
            this.classContentItemList = this.teacherClassContents;
        }
        else if(this.user.roleId == 4){
            this.schoolContentItemList = this.parentSchoolContents;
            this.classContentItemList = this.parentClassContents;
        }
        else if(this.user.roleId == 5){
            this.schoolContentItemList = this.studentSchoolContents;
            this.classContentItemList = this.studentClassContents;
        }


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