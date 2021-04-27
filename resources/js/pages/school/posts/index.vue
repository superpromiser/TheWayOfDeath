<template>
    <v-container class="pa-0">
        <RouterBack title="发布"></RouterBack>
        {{user.role}}
        <div v-if="user.roleId == 1">
            <v-row v-for="(itemGroup, i) in adminItem" :key="i" class="ma-0 px-6">
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
        </div>
        <div v-if="user.roleId == 2">
            <v-row v-for="(itemGroup, i) in managerItem" :key="i" class="ma-0 px-6">
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
        </div>
        <div v-if="user.roleId == 3">
            <v-row v-for="(itemGroup, i) in teacherItem" :key="i" class="ma-0 px-6">
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
        </div>
        <div v-if="user.roleId == 4">
            <v-row v-for="(itemGroup, i) in studentItem" :key="i" class="ma-0 px-6">
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
        </div>
        <div v-if="user.roleId == 5">
            <v-row v-for="(itemGroup, i) in contentItemList" :key="i" class="ma-0 px-6">
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
        </div>
        <div v-if="user.roleId == 6">

        </div>
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
        console.log("this.user",this.user)
        if(this.currentPath.name == 'schoolSpace.post'){
            this.isPostItem = true
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/颜色填充 1.png",
                        path:"posts.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/graph chart 3.png",
                        path:"posts.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/Shape 18.png",
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/megaphone 2.png",
                        path:"posts.announcement"
                    }
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    {
                        color:"#98BB3A",
                        title:"访客管理",//방문자관리
                        imgUrl:"/asset/img/newIcon/图层 1.png",
                        path:"posts."
                    },
                    {
                        color:"#98BB3A",
                        title:"交接班",//교대반관리
                        imgUrl:"/asset/img/newIcon/交接班.png",
                        path:"posts.shift"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/维修.png",
                        path:"posts.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/安全教育 2.png",
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
                        title:"学生风采",//학생풍모
                        imgUrl:"/asset/img/newIcon/graduate.png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"教师风采",//교사풍모
                        imgUrl:"/asset/img/newIcon/教师 (1).png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"学校动态",//학교동태
                        imgUrl:"/asset/img/newIcon/hourglass.png",
                        path:"posts.schoolStory",

                    },
                    {
                        color:"#C95384",
                        title:"表彰",//영예표창
                        imgUrl:"/asset/img/newIcon/表彰.png",
                        path:"posts.posts.Crecognition",

                    },
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/颜色填充 1.png",
                        path:"posts.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/graph chart 3.png",
                        path:"posts.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/Shape 18.png",
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/megaphone 2.png",
                        path:"posts.announcement"
                    }
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    {
                        color:"#98BB3A",
                        title:"访客管理",//방문자관리
                        imgUrl:"/asset/img/newIcon/图层 1.png",
                        path:"posts."
                    },
                    {
                        color:"#98BB3A",
                        title:"交接班",//교대반관리
                        imgUrl:"/asset/img/newIcon/交接班.png",
                        path:"posts.shift"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/维修.png",
                        path:"posts.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/安全教育 2.png",
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
                        title:"学生风采",//학생풍모
                        imgUrl:"/asset/img/newIcon/graduate.png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"教师风采",//교사풍모
                        imgUrl:"/asset/img/newIcon/教师 (1).png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"学校动态",//학교동태
                        imgUrl:"/asset/img/newIcon/hourglass.png",
                        path:"posts.schoolStory",

                    },
                    {
                        color:"#C95384",
                        title:"表彰",//영예표창
                        imgUrl:"/asset/img/newIcon/表彰.png",
                        path:"posts.posts.Crecognition",

                    },
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/颜色填充 1.png",
                        path:"posts.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/graph chart 3.png",
                        path:"posts.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/Shape 18.png",
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/megaphone 2.png",
                        path:"posts.announcement"
                    }
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    {
                        color:"#98BB3A",
                        title:"访客管理",//방문자관리
                        imgUrl:"/asset/img/newIcon/图层 1.png",
                        path:"posts."
                    },
                    {
                        color:"#98BB3A",
                        title:"交接班",//교대반관리
                        imgUrl:"/asset/img/newIcon/交接班.png",
                        path:"posts.shift"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/维修.png",
                        path:"posts.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/安全教育 2.png",
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
                        title:"学生风采",//학생풍모
                        imgUrl:"/asset/img/newIcon/graduate.png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"教师风采",//교사풍모
                        imgUrl:"/asset/img/newIcon/教师 (1).png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"学校动态",//학교동태
                        imgUrl:"/asset/img/newIcon/hourglass.png",
                        path:"posts.schoolStory",

                    },
                    {
                        color:"#C95384",
                        title:"表彰",//영예표창
                        imgUrl:"/asset/img/newIcon/表彰.png",
                        path:"posts.posts.Crecognition",

                    },
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/颜色填充 1.png",
                        path:"posts.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/graph chart 3.png",
                        path:"posts.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/Shape 18.png",
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/megaphone 2.png",
                        path:"posts.announcement"
                    }
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    {
                        color:"#98BB3A",
                        title:"访客管理",//방문자관리
                        imgUrl:"/asset/img/newIcon/图层 1.png",
                        path:"posts."
                    },
                    {
                        color:"#98BB3A",
                        title:"交接班",//교대반관리
                        imgUrl:"/asset/img/newIcon/交接班.png",
                        path:"posts.shift"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/维修.png",
                        path:"posts.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/安全教育 2.png",
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
                        title:"学生风采",//학생풍모
                        imgUrl:"/asset/img/newIcon/graduate.png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"教师风采",//교사풍모
                        imgUrl:"/asset/img/newIcon/教师 (1).png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"学校动态",//학교동태
                        imgUrl:"/asset/img/newIcon/hourglass.png",
                        path:"posts.schoolStory",

                    },
                    {
                        color:"#C95384",
                        title:"表彰",//영예표창
                        imgUrl:"/asset/img/newIcon/表彰.png",
                        path:"posts.posts.Crecognition",

                    },
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/颜色填充 1.png",
                        path:"posts.questionnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/graph chart 3.png",
                        path:"posts.voting"
                    },
                    {
                        color:"#B673E0",
                        title:"报名",//이름등록
                        imgUrl:"/asset/img/newIcon/Shape 18.png",
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
                        imgUrl:"/asset/img/newIcon/图层 3.png",
                        path:"posts.share"
                    },
                    {
                        color:"#E4BC16",
                        title:"公告",//공시
                        imgUrl:"/asset/img/newIcon/megaphone 2.png",
                        path:"posts.announcement"
                    }
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    {
                        color:"#98BB3A",
                        title:"访客管理",//방문자관리
                        imgUrl:"/asset/img/newIcon/图层 1.png",
                        path:"posts."
                    },
                    {
                        color:"#98BB3A",
                        title:"交接班",//교대반관리
                        imgUrl:"/asset/img/newIcon/交接班.png",
                        path:"posts.shift"
                    },
                    {
                        color:"#98BB3A",
                        title:"维修工单",//수리공
                        imgUrl:"/asset/img/newIcon/维修.png",
                        path:"posts.repair"
                    },
                    {
                        color:"#98BB3A",
                        title:"安全教育",//안전교육
                        imgUrl:"/asset/img/newIcon/安全教育 2.png",
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
                        title:"学生风采",//학생풍모
                        imgUrl:"/asset/img/newIcon/graduate.png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"教师风采",//교사풍모
                        imgUrl:"/asset/img/newIcon/教师 (1).png",
                        path:"posts.",

                    },
                    {
                        color:"#C95384",
                        title:"学校动态",//학교동태
                        imgUrl:"/asset/img/newIcon/hourglass.png",
                        path:"posts.schoolStory",

                    },
                    {
                        color:"#C95384",
                        title:"表彰",//영예표창
                        imgUrl:"/asset/img/newIcon/表彰.png",
                        path:"posts.posts.Crecognition",

                    },
                ]
            },
        ],
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