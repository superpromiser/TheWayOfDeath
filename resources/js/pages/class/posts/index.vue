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
                <PostItem 
                    :item="item" 
                    :currentSchoolId="currentSchoolId"
                    :currentGradeId="currentGradeId"
                    :currentClassId="currentClassId"
                />
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
        this.currentGradeId = parseInt(this.currentPath.params.gradeId)
        this.currentClassId = parseInt(this.currentPath.params.classId)
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
                        path : "homevisit"
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
                        detail : "detail",
                        imgUrl : "/asset/img/icon/通知 拷贝.png",
                        path : "notification"
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
                        detail : "detail",
                        imgUrl : "/asset/img/icon/评价.png",
                        path : "something"
                    },
                    {
                        color : "lime darken-4",
                        title : "表彰",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/表彰.png",
                        path : "something"
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
                        detail : "detail",
                        imgUrl : "/asset/img/icon/组 29.png",
                        path : "something"
                    },
                    {
                        color : "indigo accent-2",
                        title : "相册",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/相册.png",
                        path : "something"
                    },
                    {
                        color : "indigo accent-2",
                        title : "文件",
                        detail : "detail",
                        imgUrl : "/asset/img/icon/文件.png",
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