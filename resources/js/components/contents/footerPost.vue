<template>
    <v-col cols="12" class="py-2 pt-0" v-if="$isMobile()">
        <div class="d-flex align-center justify-space-between">
            <p class="mb-0 font-size-0-8" > 浏览 {{footerInfo.readList ? footerInfo.readList.length : 0}}次</p>
            <v-speed-dial
                v-model="fab"
                direction="left"
                transition="slide-x-reverse-transition"
                class="mo-news-item-fab"
            >
                <template v-slot:activator>
                    <v-btn icon>
                        <v-icon>mdi-dots-horizontal </v-icon>
                    </v-btn>
                </template>
                <div class="d-flex align-center" v-if="user.roleId < 3 || footerInfo.users.id == user.id">
                    <v-btn icon color="blue accent-3">
                        <v-icon @click="postRemove(footerInfo)">mdi-trash-can-outline</v-icon>
                    </v-btn>
                </div>
                <div class="d-flex align-center ">
                    <v-btn icon color="#7879ff" v-if="user.roleId < 3" >
                        <v-icon size="20" @click="fixTop(footerInfo)" v-if="footerInfo.fixTop == null">mdi-arrow-up </v-icon>
                        <v-icon size="20" @click="relaseTop(footerInfo.id)" v-else>mdi-arrow-down </v-icon>
                    </v-btn>
                </div>
                
                <div class="d-flex align-center ">
                    <v-btn icon color="red accent-3" :loading="isLiking">
                        <v-icon size="20" v-if="footerInfo.isLiked" @click="removeLike">mdi-heart </v-icon>
                        <v-icon size="20" v-else @click="addLike">mdi-heart-outline </v-icon>
                    </v-btn>
                    <span>{{footerInfo.likes.length > 0 ? footerInfo.likes.length : 0}}</span>
                </div>
                <div class="d-flex align-center" @click="showDetail">
                    <v-btn icon color="success">
                        <v-icon size="20" >mdi-comment-outline</v-icon>
                    </v-btn>
                    <!-- <span class="font-size-0-8 font-color-white">评论</span> -->
                    <span>{{footerInfo.comments.length > 0 ? footerInfo.comments.length : 0}}</span>
                </div>
            </v-speed-dial>
        </div>
        <v-divider></v-divider>
    </v-col>
    <v-col cols="12" class="pt-2 px-10" v-else>
        <div class="d-flex align-center justify-end mb-5">
            <v-btn @click="showReadUsers" icon color="blue accent-3" :loading="isReadCnt" >
                <v-icon medium color="#7879ff" class="mr-2">mdi-eye</v-icon>
                <p class="mb-0 mr-8">{{footerInfo.readList ? footerInfo.readList.length : 0}}人</p>
            </v-btn>
            <v-btn icon color="red accent-3" :loading="isLiking">
                <v-icon size="25" v-if="footerInfo.isLiked" @click="removeLike">mdi-heart </v-icon>
                <v-icon size="25" v-else @click="addLike">mdi-heart-outline </v-icon>
            </v-btn>
            <span class="mr-8">{{footerInfo.likes.length > 0 ? footerInfo.likes.length : 0}}</span>
            <v-btn icon color="success" >
                <v-icon size="25" @click="showComment">mdi-comment-outline</v-icon>
            </v-btn>
            <span>{{footerInfo.comments.length > 0 ? footerInfo.comments.length : 0}}</span>
        </div>
        <div v-if="isComment == true" class="position-relative">
            <v-row>
                <v-col cols="12" class="d-flex">
                    <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="#7879ff" size="48">
                        <span class="white--text headline">{{user.name[0]}}</span>
                        </v-avatar>
                        <v-avatar v-else
                    size="48"
                    >
                        <v-img :src="user.avatar"></v-img>
                    </v-avatar>
                    <v-textarea
                        solo
                        name="input-7-4"
                        label=""
                        class="ml-2"
                        v-model="commentText"
                        hide-details
                    ></v-textarea>
                </v-col>
            </v-row>
            <Picker 
                v-click-outside="outSidePicker" 
                v-if="emoStatus" 
                :data="emojiIndex" 
                title="选择你的表情符号..." 
                set="twitter" 
                @select="onInput" 
                class="position-absolute" 
                style="bottom: 71px" 
                :showPreview="false"
                :showSearch="false"
                :i18n="emojiI18n"
                />
            <v-row class="d-flex justify-space-between my-5">
                <v-col cols="6">
                    <v-icon @click="emoStatus = !emoStatus">
                        mdi-emoticon-excited-outline
                    </v-icon>
                </v-col>
                <v-col cols="6" class="text-right">
                    <v-btn
                        color="#f89651"
                        dark
                        @click="cancelComment"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="#7879ff"
                        class="ml-2"
                        dark
                        :loading="isPosting"
                        @click="postComment"
                    >
                        提交评论
                    </v-btn>
                </v-col>
            </v-row>
        </div>
        <v-divider class="thick-border" light></v-divider>
        <v-row justify="center">
            <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
                v-model="dialog"
                max-width="500"
                height="150"
            >
                <v-card>
                    <v-card-title class="headline grey lighten-2">
                    已读
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="6" v-for="user in readUsers" :key="user.id" style="width:50px">
                                <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="#7879ff" size="50" class="ma-5">
                                    <span class="white--text headline">{{user.name[0]}}</span>
                                </v-avatar>
                                <v-avatar v-else
                                class="ma-5"
                                size="50"
                                >
                                    <v-img :src="user.avatar"></v-img>
                                </v-avatar>
                                <span>{{user.name}}</span>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-row>
    </v-col>
</template>

<script>
import {addLike,removeLike} from '~/api/post'
import {mapGetters} from 'vuex';
import {getReadCnt} from '~/api/alarm'
import {addComment,deleteComment} from '~/api/post'
import {createReadCnt} from '~/api/alarm'
import { Picker, EmojiIndex } from "emoji-mart-vue-fast";
import "emoji-mart-vue-fast/css/emoji-mart.css";
import emojiData from "emoji-mart-vue-fast/data/all.json";
let emojiIndex = new EmojiIndex(emojiData);
export default {
    props:{
        footerInfo:{
            type:Object,
            required:true
        }
    },
    components:{
        Picker
    },
    computed:{
        ...mapGetters({
            user:'auth/user',
            selectedSchoolItem: 'mo/selectedSchoolItem'
        }),
        currentPath(){
            return this.$route
        }
    },
    // watch:{
    // currentPath:{
    //     handler(val){
    //         if(val.query.fix){
    //             let index = this.contentList.findIndex(content=>content.id == this.currentPath.query.fix)
    //             if(index > -1){
    //                 let fixVal = this.contentList[index]
    //                 this.contentList.splice(index,1)
    //                 let currentTime = this.TimeView(Date.now())
    //                 fixVal.fixTop = currentTime;
    //                 this.contentList.unshift(fixVal)
    //             }
    //         }
    //         if(val.query.release){
    //             let index = this.contentList.findIndex(content=>content.id == this.currentPath.query.release)
    //             if(index > -1){
    //                 let releaseVal = this.contentList[index]
    //                 releaseVal.fixTop = null
    //                 this.contentList.splice(index,1)
    //                 this.contentList.push(releaseVal)
    //             }
    //         }
    //         if(val.query.remove){
    //             let index = this.contentList.findIndex(content=>content.id == this.currentPath.query.remove)
    //             if(index > -1){
    //                 this.contentList.splice(index,1)
    //             }
    //         }
    //     },
    //     deeper:true
    // },
    data: ()=> ({
        fab: false,
        isReadCnt:false,
        isLiking : false,
        isDisLiking : false,
        dialog:false,
        readUsers:[],
        commentText:'',
        isComment:false,
        emoStatus:false,
        emojiIndex: emojiIndex,
        isPosting:false,

        emojiI18n: { 
            search: 'Recherche', 
            categories: { 
                search: '//Search Results',
                recent: '最近常用',
                smileys: '黄脸',
                people: '人和手势',
                nature: '动物和植物',
                foods: '食物',
                activity: '活动',
                places: '交通 ',
                objects: '物品',
                symbols: '标志',
                flags: '国旗',
                custom: '其他',
            } 
        },
    }),
    created(){
    },
    mounted(){
        let index = this.footerInfo.likes.map(x=>{
            return x.userId
        }).indexOf(this.user.id)
        if(index > -1){
            this.$set(this.footerInfo,'isLiked',true)
        }
    },
    methods :{
        async addLike(){
            this.isLiking = true;
            // this.fab = true;
            await addLike({postId:this.footerInfo.id}).then(res=>{
                this.footerInfo.likes.push(res)
                this.$set(this.footerInfo,'isLiked',true)
            }).catch(err=>{
                //console.log(err.response)
            })
            this.isLiking = false;
            // this.fab = false;
        },
        async removeLike(){
            this.isLiking = true;
            // this.fab = true;
            await removeLike({postId:this.footerInfo.id}).then(res=>{
                let index = this.footerInfo.likes.map(x=>{
                    return x.userId
                }).indexOf(this.user.id)
                this.footerInfo.likes.splice(index,1)
                delete this.footerInfo['isLiked'];
            }).catch(err=>{
                //console.log(err.response)
            })
            this.isLiking = false;
            // this.fab = false;
        },
        
        showComment(){
            if(this.currentPath.path.includes('detail')){
                return;
            }
            else{
                this.isComment = ! this.isComment
            }
        },
        onInput(e){
            if(!e){
                return false;
            }
            if(!this.commentText){
                this.commentText = e.native
            }else{
                this.commentText = this.commentText + e.native
            }
        },
        outSidePicker(){
            this.emoStatus = false;
        },
        async showReadUsers(){
            this.isReadCnt = true
            await getReadCnt({userList:this.footerInfo.readList}).then(res=>{
                this.isReadCnt = false
                this.dialog = true
                this.readUsers = res.data
            }).catch(err=>{
                this.isReadCnt = false
                console.log(err.response)
            })
        },
        postComment(){
            this.isPosting = true
            addComment({text:this.commentText,postId:this.footerInfo.id}).then(res=>{
                this.isPosting = false
                this.footerInfo.comments.unshift(res.data)
            }).catch(err=>{
                this.isPosting = false
                //console.log(err.response)
            })
            this.commentText = ''
        },
        cancelComment(){
            this.commentText = ''
            this.emoStatus = false
            this.isComment = false
        },
        showDetail(){
            // console.log(this.footerInfo)
             createReadCnt({postId:this.footerInfo.id}).then(res=>{
                 console.log("--------",res.data)
            }).catch(err=>{
                console.log(err.response)
            })
            // alert(this.footerInfo.contentId)
            
            this.$store.dispatch('content/storePostDetail',this.footerInfo)
            if(this.$isMobile()){
                switch(this.footerInfo.contentId){
                    case 1:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.quesionnaire', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classQuesionnaire', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 2:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.voting', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classVoting', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 5:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.anouncement', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.Canouncement', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 7:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolRepair', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classRepair', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 8:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 9:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 11:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 12:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.quesionnaire', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classQuesionnaire', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 13:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.voting', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classVoting', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 14:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            // this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId}});
                            if(this.content.homework.homeworkType == "常规作业"){
                            if(this.user.roleId == 3 || this.user.roleId == 7){
                                this.$router.push({name:'details.homeworkofflineTeacher', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});    
                            }else if(this.user.roleId == 5){
                                this.$router.push({name:'details.homeworkofflineStudent', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});    
                            }else{
                                this.$router.push({name:'details.classHomework', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});    
                            }
                            }else if(this.content.homework.homeworkType == '在线作业'){
                            if(this.user.roleId == 3 || this.user.roleId == 7){
                                this.$router.push({name:'details.homeworkonlineTeacher', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});    
                            }else if(this.user.roleId == 5){
                                this.$router.push({name:'details.homeworkonlineStudent', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});    
                            }else{
                                this.$router.push({name:'details.classHomework', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});    
                            }
                            }else if(this.content.homework.homeworkType == '在线测试'){
                            if(this.user.roleId == 3 || this.user.roleId == 7){
                                this.$router.push({name:'details.homeworktestTeacher', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});    
                            }else if(this.user.roleId == 5){
                                this.$router.push({name:'details.homeworktestTeacher', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});    
                            }else{
                                this.$router.push({name:'details.classHomework', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});    
                            }
                            }else{
                            this.$router.push({name:'details.classHomework', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                            }
                        }
                        break;
                    case 15:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 16:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId:this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId:this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 17:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 19:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.classRecognition', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classRecognition', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 20:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 21:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 23:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId:this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId:this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 24:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.interClassStory'});
                            if(this.user.roleId == 5){
                                this.$router.push({name:'details.regnameAnswer', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                            }
                            else{
                                this.$router.push({name:'details.regnameResult', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                            }
                        }
                        else{
                            if(this.user.roleId == 5){
                                this.$router.push({name:'details.CregnameAnswer', params:{schoolId: this.selectedSchoolItem.schoolId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                            }
                            else{
                                this.$router.push({name:'details.CregnameResult', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                            }
                        }
                        break;
                    case 25:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId,  lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 26:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'details.schoolDefault', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'details.classDefault', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId, lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    case 27:
                        if(this.selectedSchoolItem.type == 'school'){
                            this.$router.push({name:'classSpace.applications.returnTeam', params:{schoolId: this.selectedSchoolItem.schoolId},query:{autoFocus:true}});
                        }
                        else{
                            this.$router.push({name:'classSpace.applications.returnTeam', params:{schoolId: this.selectedSchoolItem.schoolId,gradeId: this.selectedSchoolItem.gradeId,  lessonId: this.selectedSchoolItem.lessonId},query:{autoFocus:true}});
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }
}
</script>

<style>

</style>