<template>
    <v-container class="pa-0">
        <RouterBack title="发布"></RouterBack>
        <v-row v-for="(itemGroup, i) in contentItemList" :key="i" class="ma-0">
            <v-col cols="12">
                <v-chip
                    class="ma-2 px-5"
                    color="primary"
                    outlined
                >
                    <v-icon left>
                        {{itemGroup.icon}}
                    </v-icon>
                    {{itemGroup.title}}
                </v-chip>
            </v-col>
            <v-col v-for="(item, j) in itemGroup.items" :key="j" cols="12" sm="6" md="4" lg="3">
                <PostItem :item="item" @selected="selectedPost"/>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import PostItem from '~/components/postItem'
import RouterBack from '~/components/routerBack'
export default {
    middleware:'auth',
    components:{
        PostItem,
        RouterBack
    },

    computed: {
        ...mapGetters({
            
        }),
        currentPath(){
            return this.$route
        },
    },
    watch:{
        currentPath:{
            handler(val){
                //console.log('&&&&&&&&&',val)
                if(val.name == 'schoolSpace.post'){
                    this.isPostItem = true
                }
            },
            deep:true
        }
    },
    created(){
        if(this.currentPath.name == 'schoolSpace.post'){
            this.isPostItem = true
        }
    },
    data: () => ({
        currentSchoolId : -1,
        isPostItem:false,
        contentItemList : [
            {
                title : "基础沟通",//기초의사소통
                icon : "mdi-message-text",
                items : [
                    {
                        color : "#98BB3A",
                        title : "问卷",//설문조사
                        imgUrl : "/asset/img/newIcon/问卷.png",
                        path : "posts.questionnaire"
                    },
                    {
                        color : "#C95384",
                        title : "投票",//투표
                        imgUrl : "/asset/img/newIcon/投票.png",
                        path : "posts.voting"
                    },
                    {
                        color : "#E4BC16",
                        title : "短信",//통보문
                        imgUrl : "/asset/img/newIcon/短信.png",
                        path : "posts.sms"
                    },
                    {
                        color : "#7180EA",
                        title : "校园动态",//학원동태
                        imgUrl : "/asset/img/newIcon/校园动态.png",
                        path : "posts.campus"
                    },
                    {
                        color : "#3FB8E3",
                        title : "公告",//공시
                        imgUrl : "/asset/img/newIcon/公告.png",
                        path : "posts.announcement"
                    },
                    {
                        color : "#E4BC16",
                        title : "分享",//공유
                        imgUrl : "/asset/img/newIcon/分享.png",
                        path : "posts.share"
                    },
                    {
                        color : "#C95384",
                        title : "报名",//이름등록
                        imgUrl : "/asset/img/newIcon/报名.png",
                        path : "posts.regname"
                    },
                    // {
                    //     color : "#B673E0",
                    //     title : "通讯录",//주소록
                    //     imgUrl : "/asset/img/newIcon/通讯录.png",
                    //     path : "something"
                    // },
                ],
            },
            {
                title : "校园文化",//교내문화
                icon : "mdi-lifebuoy",
                items : [
                    // {
                    //     color : "#B673E0",
                    //     title : "考勤",//출근
                    //     imgUrl : "/asset/img/newIcon/课程表.png",
                    //     path : "something"
                    // },
                    // {
                    //     color : "#DA7042",
                    //     title : "作业",//숙제
                    //     imgUrl : "/asset/img/newIcon/作业.png",
                    //     path : "posts.homework"
                    // },
                    // {
                    //     color : "#3FB8E3",
                    //     title : "班牌发布",//반표발포
                    //     imgUrl : "/asset/img/newIcon/班牌发布.png",
                    //     path : "something"
                    // },
                    {
                        color : "#7180EA",
                        title : "布告栏",//게시란
                        imgUrl : "/asset/img/newIcon/布告栏.png",
                        path : "posts.bulletinboard"
                    },
                    // {
                    //     color : "#C95384",
                    //     title : "学生风采",//학생풍채
                    //     imgUrl : "/asset/img/newIcon/学生风采.png",
                    //     path : "something"
                    // },
                    
                ],
            },
            {
                title : "家校互动",//가교호상활동
                icon : "mdi-nfc-tap",
                items : [
                    // {
                    //     color : "#3EBBE8",
                    //     title : "相册",//사진
                    //     imgUrl : "/asset/img/newIcon/相册.png",
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
                        imgUrl : "/asset/img/newIcon/家访.png",
                        path : "posts.homevisit"
                    },
                    // {
                    //     color : "#7180EA",
                    //     title : "提示",//제시
                    //     imgUrl : "/asset/img/newIcon/提示.png",
                    //     path : "something"
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
            //             imgUrl : "/asset/img/newIcon/请假单.png",
            //             path : "posts.vocation"
            //         },
            //         {
            //             color : "#E4BC16",
            //             title : "话题",//화제
            //             imgUrl : "/asset/img/newIcon/话题.png",
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
            //             imgUrl : "/asset/img/newIcon/话题.png",
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
                        imgUrl : "/asset/img/newIcon/交接班.png",
                        path : "posts.shift"
                    },
                    {
                        color : "#7180EA",
                        title : "维修工单",//Repair work order
                        imgUrl : "/asset/img/newIcon/维修工单.png",
                        path : "posts.repair"
                    },
                    {
                        color : "#DA7042",
                        title : "安全教育", //Ask for leave
                        imgUrl : "/asset/img/newIcon/闸机.png",
                        path : "posts.safeStudy"
                    },
                ],
            },
        ]
    }),

    methods:{
        selectedPost(val){
            this.isPostItem = val
        }
    }
}
</script>

<style>

</style>