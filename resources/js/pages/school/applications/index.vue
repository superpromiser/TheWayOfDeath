<template>
    <v-container class="pa-0">
        <v-row v-for="(itemGroup, i) in contentItemList" :key="i" class="ma-0">
            <v-col cols="12">
                <v-chip
                    class="ma-2 px-5"
                    color="#7879ff"
                    outlined
                >
                    <v-icon left>
                        {{itemGroup.icon}}
                    </v-icon>
                    {{itemGroup.title}}
                </v-chip>
            </v-col>
            <v-col v-for="(item, j) in itemGroup.items" :key="j" cols="12" sm="6" md="4" lg="3">
                <PostItem :item="item" @selected="selectedPost" :btnTxt="'详情'"/>
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
            user:'auth/user' 
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
        switch(this.user.roleId){
            case 1:
                this.contentItemList = this.adminItem;
                break;
            case 2:
                this.contentItemList = this.managerItem;
                break;
            case 3:
                this.contentItemList = this.teacherItem;
                break;
            case 4:
                this.contentItemList = this.parentItem
                break;
            case 5:
                this.contentItemList = this.studentItem
                break;
            case 6:
                this.contentItemList = this.employeeItem
                break
            case 7:
                this.contentItemList = this.teacherItem;
                break;
            default:
                this.contentItemList = this.studentItem
                break;
            
        }

    },
    data: () => ({
        currentSchoolId : -1,
        isPostItem:false,
        adminItem : [
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/newIcon/share1.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/questionnaire.png",
                        path:"schoolSpace.applications.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/voting.png",
                        path:"schoolSpace.applications.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/regName.png",
                        path:"schoolSpace.applications.regname"
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
                        imgUrl:"/asset/img/newIcon/share2.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/announcement.png",
                        path:"schoolSpace.applications.announcement"
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
                        imgUrl:"/asset/img/newIcon/shiftMng.png",
                        path:"schoolSpace.applications.shiftMng"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/repair.png",
                        path:"schoolSpace.applications.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/safeStudy.png",
                        path:"schoolSpace.applications.safeStudy"
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
                        imgUrl:"/asset/img/newIcon/schoolStory.png",
                        path:"schoolSpace.applications.schoolStory",

                    },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/newIcon/recognition.png",
                    //     path:"posts.posts.Crecognition",

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
                ]
            },
        ],
        managerItem : [
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/newIcon/share1.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/questionnaire.png",
                        path:"schoolSpace.applications.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/voting.png",
                        path:"schoolSpace.applications.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/regName.png",
                        path:"schoolSpace.applications.regname"
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
                        imgUrl:"/asset/img/newIcon/share2.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/announcement.png",
                        path:"schoolSpace.applications.announcement"
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
                        imgUrl:"/asset/img/newIcon/shiftMng.png",
                        path:"schoolSpace.applications.shiftMng"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/repair.png",
                        path:"schoolSpace.applications.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/safeStudy.png",
                        path:"schoolSpace.applications.safeStudy"
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
                        imgUrl:"/asset/img/newIcon/schoolStory.png",
                        path:"schoolSpace.applications.schoolStory",

                    },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.posts.Crecognition",

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
                ]
            },
        ],
        teacherItem : [
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/newIcon/share1.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/questionnaire.png",
                        path:"schoolSpace.applications.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/voting.png",
                        path:"schoolSpace.applications.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/regName.png",
                        path:"schoolSpace.applications.regname"
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
                        imgUrl:"/asset/img/newIcon/share2.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/announcement.png",
                        path:"schoolSpace.applications.announcement"
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
                        imgUrl:"/asset/img/newIcon/shiftMng.png",
                        path:"schoolSpace.applications.shiftMng"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/repair.png",
                        path:"schoolSpace.applications.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/safeStudy.png",
                        path:"schoolSpace.applications.safeStudy"
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
                        imgUrl:"/asset/img/newIcon/schoolStory.png",
                        path:"schoolSpace.applications.schoolStory",

                    },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.posts.Crecognition",

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
                ]
            },
        ],
        parentItem : [
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/newIcon/share1.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/questionnaire.png",
                        path:"schoolSpace.applications.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/voting.png",
                        path:"schoolSpace.applications.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/regName.png",
                        path:"schoolSpace.applications.regname"
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
                        imgUrl:"/asset/img/newIcon/share2.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/announcement.png",
                        path:"schoolSpace.applications.announcement"
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
                    // {
                    //     color:"#98BB3A",
                    //     title:"交接班",//교대반관리
                    //     imgUrl:"/asset/img/newIcon/shiftMng.png",
                    //     path:"schoolSpace.applications.shiftMng"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"维修工单",//수리공
                    //     imgUrl:"/asset/img/newIcon/repair.png",
                    //     path:"schoolSpace.applications.repair"
                    // },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/safeStudy.png",
                        path:"schoolSpace.applications.safeStudy"
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
                        imgUrl:"/asset/img/newIcon/schoolStory.png",
                        path:"schoolSpace.applications.schoolStory",

                    },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.posts.Crecognition",

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
                ]
            },
        ],
        studentItem : [
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"分享",//공유
                        imgUrl:"/asset/img/newIcon/share1.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/questionnaire.png",
                        path:"schoolSpace.applications.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/voting.png",
                        path:"schoolSpace.applications.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/regName.png",
                        path:"schoolSpace.applications.regname"
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
                        imgUrl:"/asset/img/newIcon/share2.png",
                        path:"schoolSpace.applications.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/announcement.png",
                        path:"schoolSpace.applications.announcement"
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
                        imgUrl:"/asset/img/newIcon/shiftMng.png",
                        path:"schoolSpace.applications.shiftMng"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/repair.png",
                        path:"schoolSpace.applications.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/safeStudy.png",
                        path:"schoolSpace.applications.safeStudy"
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
                        imgUrl:"/asset/img/newIcon/schoolStory.png",
                        path:"schoolSpace.applications.schoolStory",

                    },
                    // {
                    //     color:"#C95384",
                    //     title:"表彰",//영예표창
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.posts.Crecognition",

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
                ]
            },
        ],
        employeeItem:[
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    {
                        color:"#98BB3A",
                        title:"交接班",//교대반관리
                        imgUrl:"/asset/img/newIcon/shiftMng.png",
                        path:"schoolSpace.applications.shiftMng"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/repair.png",
                        path:"schoolSpace.applications.repair"
                    },
                ]
            },
        ],
        contentItemList:[]
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