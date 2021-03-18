<template>
    <v-container>
        <v-row v-for="(itemGroup, i) in contentItemList" :key="i">
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
                <PostItem :item="item" :currentId="currentSchoolId"/>
            </v-col>
        </v-row>
        <!-- <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition> -->
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
    created(){
        this.currentSchoolId = parseInt(this.currentPath.params.id)
    },
    data: () => ({
        currentSchoolId : -1,
        contentItemList : [
            {
                title : "基础沟通",
                icon : "mdi-message-text",
                items : [
                    {
                        color : "lime darken-4",
                        title : "问卷",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/问卷 拷贝.png",
                        path : "questionnaire"
                    },
                    {
                        color : "lime darken-4",
                        title : "投票",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/投票.png",
                        path : "voting"
                    },
                    {
                        color : "lime darken-4",
                        title : "短信",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/短信 拷贝.png",
                        path : "sms"
                    },
                    {
                        color : "indigo accent-2",
                        title : "校园动态",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/动态 拷贝.png",
                        path : "campus"
                    },
                    {
                        color : "lime darken-4",
                        title : "公告",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/公告 拷贝.png",
                        path : "something"
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
                        detail : "detail",
                        imgUrl : "/asset/img/icon/布告栏 拷贝.png",
                        path : "something"
                    },
                    {
                        color : "red accent-3",
                        title : "考勤",
                        detail : "detail",
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
                        detail : "detail",
                        imgUrl : "/asset/img/icon/作业 拷贝.png",
                        path : "something"
                    },
                    {
                        color : "lime darken-4",
                        title : "习题",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/习题.png",
                        path : "something"
                    },
                    {
                        color : "teal darken-4",
                        title : "家访",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/家访 拷贝.png",
                        path : "something"
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
                        detail : "detail",
                        imgUrl : "/asset/img/icon/请假.png",
                        path : "vacation"
                    },
                    {
                        color : "teal darken-4",
                        title : "考勤",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/组 25.png",
                        path : "something"
                    },
                ],
            },
        ]
    }),
}
</script>

<style>

</style>