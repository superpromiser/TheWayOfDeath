<template>
    <v-container class="pa-0">
        <v-row v-for="(itemGroup, i) in contentItemList" :key="i" v-if="isPostItem == true" class="ma-0">
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
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import PostItem from '~/components/postItem'
export default {
    components:{
        PostItem,
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
                console.log('&&&&&&&&&',val)
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
                title : "基础沟通",
                icon : "mdi-message-text",
                items : [
                    {
                        color : "lime darken-4",
                        title : "问卷",
                        imgUrl : "/asset/img/icon/问卷 拷贝.png",
                        path : "posts.questionnaire"
                    },
                    {
                        color : "lime darken-4",
                        title : "投票",
                        imgUrl : "/asset/img/icon/投票.png",
                        path : "posts.voting"
                    },
                    {
                        color : "lime darken-4",
                        title : "短信",
                        imgUrl : "/asset/img/icon/短信 拷贝.png",
                        path : "posts.sms"
                    },
                    {
                        color : "indigo accent-2",
                        title : "校园动态",
                        imgUrl : "/asset/img/icon/动态 拷贝.png",
                        path : "posts.campus"
                    },
                    {
                        color : "lime darken-4",
                        title : "公告",
                        imgUrl : "/asset/img/icon/公告 拷贝.png",
                        path : "posts.announcement"
                    },
                ],
            },
            {
                title : "校园文化",
                icon : "mdi-lifebuoy",
                items : [
                    {
                        color : "indigo accent-2",
                        title : "布告栏",
                        imgUrl : "/asset/img/icon/布告栏 拷贝.png",
                        path : "posts.bulletinboard"
                    },
                    {
                        color : "red accent-3",
                        title : "考勤",
                        imgUrl : "/asset/img/icon/考勤.png",
                        path : "something"
                    },
                ],
            },
            {
                title : "家校互动",
                icon : "mdi-nfc-tap",
                items : [
                    {
                        color : "teal darken-4",
                        title : "作业",
                        imgUrl : "/asset/img/icon/作业 拷贝.png",
                        path : "something"
                    },
                    {
                        color : "lime darken-4",
                        title : "习题",
                        imgUrl : "/asset/img/icon/习题.png",
                        path : "something"
                    },
                    {
                        color : "teal darken-4",
                        title : "家访",
                        imgUrl : "/asset/img/icon/家访 拷贝.png",
                        path : "posts.homevisit"
                    },
                ],
            },
            {
                title : "智能考勤",
                icon : "mdi-calendar-month-outline",
                items : [
                    {
                        color : "teal darken-4",
                        title : "请假",
                        imgUrl : "/asset/img/icon/请假.png",
                        path : "vacation"
                    },
                    {
                        color : "teal darken-4",
                        title : "考勤",
                        imgUrl : "/asset/img/icon/组 25.png",
                        path : "something"
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