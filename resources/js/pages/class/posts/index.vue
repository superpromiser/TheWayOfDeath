<template>
    <v-container>
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
                <PostItem 
                    :item="item" 
                    @selected="selectedPost"
                />
            </v-col>
        </v-row>
        <transition name="fade" mode="out-in">
            <router-view :key="$router.path"></router-view>
        </transition>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import PostItem from '~/components/postItem'
import RouterBack from '~/components/routerBack'
import {getDashboardData} from '~/api/tablet'
export default {
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
                if(val.name == 'classSpace.post'){
                    this.isPostItem = true
                }
            },
            deep:true
        }
    },
    created(){
       if(this.currentPath.name == 'classSpace.post'){
            this.isPostItem = true
        }
        // getDashboardData().then(res=>{
        //     console.log(res.data)
        // }).catch(err=>{
        //     console.log(err.response)
        // })
    },
    data: () => ({
        currentSchoolId : -1,
        isPostItem:false,
        contentItemList : [
            {
                title : "基础沟通",
                icon : "mdi-message-text",
                items : [
                    {
                        color : "#98BB3A",
                        title : "问卷",
                        imgUrl : "/asset/img/newIcon/问卷.png",
                        path : "posts.Cquestionnaire"
                    },
                    {
                        color : "#C95384",
                        title : "投票",
                        imgUrl : "/asset/img/newIcon/投票.png",
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
                        imgUrl : "/asset/img/newIcon/作业.png",
                        path : "posts.Chomework"
                    },
                    // {
                    //     color : "#E4BC16",
                    //     title : "习题",
                    //     imgUrl : "/asset/img/newIcon/习题.png",
                    //     path : "something"
                    // },
                    {
                        color : "#DA7042",
                        title : "家访",
                        imgUrl : "/asset/img/newIcon/家访.png",
                        path : "posts.Chomevisit"
                    },
                    {
                        color : "#EB5846",
                        title : "班级动态",
                        imgUrl : "/asset/img/newIcon/班级动态.png",
                        path : "posts.classStory"
                    },
                    {
                        color : "#EB5846",
                        title : "班际动态",
                        imgUrl : "/asset/img/newIcon/班际动态.png",
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
                        imgUrl : "/asset/img/icon/表彰.png",
                        path : "posts.Crecognition"
                    },
                ],
            },
            {
                title : "工具",
                icon : "mdi-calendar-month-outline",
                items : [
                    // {
                    //     color : "indigo accent-2",
                    //     title : "课表",
                    //     imgUrl : "/asset/img/icon/组 29.png",
                    //     path : "something"
                    // },
                    {
                        color : "#3EBBE8",
                        title : "相册",
                        imgUrl : "/asset/img/newIcon/相册.png",
                        path : "posts.Calbum"
                    },
                    {
                        color : "indigo accent-2",
                        title : "文件",
                        imgUrl : "/asset/img/icon/文件.png",
                        path : "file"
                    },
                ],
            },
            // {
            //     title : "校园安全",
            //     icon : "mdi-safe",
            //     items : [
            //         {
            //             color : "indigo accent-2",
            //             title : "访客管理",
            //             imgUrl : "/asset/img/icon/组 29.png",
            //             path : "manageGuests"
            //         },
            //     ],
            // },
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