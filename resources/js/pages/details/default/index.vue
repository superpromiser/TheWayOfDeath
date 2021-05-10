<template>
    <v-container class="pa-0 h-100" v-if="$isMobile()">
        <v-container class="pa-0 add-comment-out-height-mo">
            <v-container class="pa-0 bg-white position-sticky-top-0" >
                <v-row class="ma-0 bg-white justify-center " >
                    <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                        mdi-chevron-left
                    </v-icon>
                    <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >评论</p>
                </v-row>
                <div class="cus-divider-light-gray-height"></div>
            </v-container>
            <div v-if='contentData.contentId == 1'>
                <QuestionnairePost :content='contentData'></QuestionnairePost>
            </div>
            <div v-else-if='contentData.contentId == 2'>
                <VotingPost :content='contentData'></VotingPost>
            </div>
            <div v-else-if='contentData.contentId == 3'>
                <SmsPost :content='contentData'></SmsPost>
            </div>
            <div v-else-if='contentData.contentId == 4'>
                <CampusPost :content='contentData'></CampusPost>
            </div>
            <div v-else-if='contentData.contentId == 5'>
                <AnouncementPost :content='contentData'></AnouncementPost>
            </div>
            <div v-else-if='contentData.contentId == 6'>
                <BulletinBoardPost :content='contentData'></BulletinBoardPost>
            </div>
            <div v-else-if='contentData.contentId == 7'>
                <RepaireDataPost :content='contentData'></RepaireDataPost>
            </div>
            <div v-else-if='contentData.contentId == 8'>
                <SafeStudyPost :content='contentData'></SafeStudyPost>
            </div>
            <div v-else-if='contentData.contentId == 9'>
                <ShiftMngPost :content='contentData'></ShiftMngPost>
            </div>
            <div v-else-if='contentData.contentId == 10'>
                <HomeVisitPost :content='contentData'></HomeVisitPost>
            </div>
            <div v-else-if='contentData.contentId == 11'>
                <SchoolStoryPost :content='contentData'></SchoolStoryPost>
            </div>
            <div v-else-if='contentData.contentId == 12'>
                <QuestionnairePost :content='contentData'></QuestionnairePost>
            </div>
            <div v-else-if='contentData.contentId == 13'>
                <VotingPost :content='contentData'></VotingPost>
            </div>
            <div v-else-if='contentData.contentId == 14'>
                <HomeworkPost :content='contentData'></HomeworkPost>
            </div>
            <div v-else-if='contentData.contentId == 15'>
                <SmsPost :content='contentData'></SmsPost>
            </div>
            <div v-else-if='contentData.contentId == 16'>
                <HomeVisitPost :content='contentData'></HomeVisitPost>
            </div>
            <div v-else-if='contentData.contentId == 17'>
                <NotificationPost :content='contentData'></NotificationPost>
            </div>
            <div v-else-if='contentData.contentId == 18'>
                <EvaluationPost :content='contentData'></EvaluationPost>
            </div>
            <div v-else-if='contentData.contentId == 19'>
                <RecognitionPost :content='contentData'></RecognitionPost>
            </div>
            <div v-else-if='contentData.contentId == 20'>
                <NotificationPost :content='contentData'></NotificationPost>
            </div>
            <div v-else-if='contentData.contentId == 21'>
                <SafeStudyPost :content='contentData'></SafeStudyPost>
            </div>
            <div v-else-if='contentData.contentId == 22'>
                <NotificationPost :content='contentData'></NotificationPost>
            </div>
            <div v-else-if='contentData.contentId == 23'>
                <SharePost :content='contentData'></SharePost>
            </div>
            <div v-else-if='contentData.contentId == 24'>
                <RegNamePost :content='contentData'></RegNamePost>
            </div>
            <div v-else-if='contentData.contentId == 25'>
                <ClassStoryPost :content='contentData'></ClassStoryPost>
            </div>
            <div v-else-if='contentData.contentId == 26'>
                <InterClassStoryPost :content='contentData'></InterClassStoryPost>
            </div>
            <FooterPost :footerInfo='contentData'></FooterPost>
            <v-container class="px-2">
                <v-container class="pa-0" v-for="(comment,index) in contentData.comments" :key="index">
                    <v-row class="ma-0">
                        <v-col cols="12" lg="1" md="2" sm="2">
                            <p class="mb-0 font-weight-bold">{{comment.users.name}}</p>
                        </v-col>
                        <v-col cols="12" lg="9" md="8" sm="6" class="text-wrap py-0">{{comment.comments}}</v-col>
                        <v-col cols="12" lg="2" md="2" sm="4" class="text-right">
                            {{TimeView(comment.created_at)}}
                            <v-icon color="#FF5722" @click="remove(comment)" :loading="comment.isDeleting">mdi-trash-can-outline</v-icon>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-container>
            </v-container>
        </v-container>
        <v-container class="px-0 py-0 position-relative">
            <Picker v-click-outside="outSidePicker" v-if="emoStatus" :data="emojiIndex" title="选择你的表情符号..." set="twitter" @select="onInput" class="position-absolute" style="bottom: 71px" />
            <v-textarea solo name="input-7-4"
                prepend-inner-icon="mdi-emoticon-excited-outline"
                @click:prepend-inner="toggleEmo"
                :append-icon-cb="toggleEmo" 
                label="请输入您的评论"
                @keydown.enter.exact.prevent 
                @keyup.enter.exact="submit" 
                @keydown.enter.shift.exact="newline" 
                v-model="commentText"
                rows="2"
                hide-details
            ></v-textarea>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
        <v-container class="pa-0 add-comment-out-height">
            <!-- <RouterBack title='评论'></RouterBack> -->
            <v-container class="px-10 z-index-2 banner-custom">
                <v-row>
                    <v-col cols="6" md="4" class="d-flex align-center position-relative">
                        <a @click="$router.go(-1)">
                            <v-icon size="70" class="left-24p">
                                mdi-chevron-left
                            </v-icon>
                        </a>
                    </v-col>
                    <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                        <h2>交接班管理</h2>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex align-center justify-end">
                        <div v-if="contentData.contentId == 9 && contentData.shift_mng.confirmDate == null && contentData.shift_mng.nextNameId == user.id">
                            <!-- <v-btn
                                tile
                                dark
                                color="#F19861"
                                :loading="isCancel"
                                @click="cancelShift"
                            >
                                取消
                            </v-btn> -->
                            <v-btn
                                dark
                                tile
                                color="#7879ff"
                                @click="confirmShift"
                                :loading="isSubmit"
                                class="mx-2"
                            >
                                确认
                            </v-btn>
                        </div>
                        
                    </v-col>
                </v-row>
            </v-container>
            <div v-if='contentData.contentId == 1'>
                <QuestionnairePost :content='contentData'></QuestionnairePost>
            </div>
            <div v-else-if='contentData.contentId == 2'>
                <VotingPost :content='contentData'></VotingPost>
            </div>
            <div v-else-if='contentData.contentId == 3'>
                <SmsPost :content='contentData'></SmsPost>
            </div>
            <div v-else-if='contentData.contentId == 4'>
                <CampusPost :content='contentData'></CampusPost>
            </div>
            <div v-else-if='contentData.contentId == 5'>
                <AnouncementPost :content='contentData'></AnouncementPost>
            </div>
            <div v-else-if='contentData.contentId == 6'>
                <BulletinBoardPost :content='contentData'></BulletinBoardPost>
            </div>
            <div v-else-if='contentData.contentId == 7'>
                <RepaireDataPost :content='contentData'></RepaireDataPost>
            </div>
            <div v-else-if='contentData.contentId == 8'>
                <SafeStudyPost :content='contentData'></SafeStudyPost>
            </div>
            <div v-else-if='contentData.contentId == 9'>
                <ShiftMngPost :content='contentData'></ShiftMngPost>
            </div>
            <div v-else-if='contentData.contentId == 10'>
                <HomeVisitPost :content='contentData'></HomeVisitPost>
            </div>
            <div v-else-if='contentData.contentId == 11'>
                <SchoolStoryPost :content='contentData'></SchoolStoryPost>
            </div>
            <div v-else-if='contentData.contentId == 12'>
                <QuestionnairePost :content='contentData'></QuestionnairePost>
            </div>
            <div v-else-if='contentData.contentId == 13'>
                <VotingPost :content='contentData'></VotingPost>
            </div>
            <div v-else-if='contentData.contentId == 14'>
                <HomeworkPost :content='contentData'></HomeworkPost>
            </div>
            <div v-else-if='contentData.contentId == 15'>
                <SmsPost :content='contentData'></SmsPost>
            </div>
            <div v-else-if='contentData.contentId == 16'>
                <HomeVisitPost :content='contentData'></HomeVisitPost>
            </div>
            <div v-else-if='contentData.contentId == 17'>
                <NotificationPost :content='contentData'></NotificationPost>
            </div>
            <div v-else-if='contentData.contentId == 18'>
                <EvaluationPost :content='contentData'></EvaluationPost>
            </div>
            <div v-else-if='contentData.contentId == 19'>
                <RecognitionPost :content='contentData'></RecognitionPost>
            </div>
            <div v-else-if='contentData.contentId == 20'>
                <VacationPost :content='contentData'></VacationPost>
            </div>
            <div v-else-if='contentData.contentId == 21'>
                <SafeStudyPost :content='contentData'></SafeStudyPost>
            </div>
            <div v-else-if='contentData.contentId == 22'>
                <NotificationPost :content='contentData'></NotificationPost>
            </div>
            <div v-else-if='contentData.contentId == 23'>
                <SharePost :content='contentData'></SharePost>
            </div>
            <div v-else-if='contentData.contentId == 24'>
                <RegNamePost :content='contentData'></RegNamePost>
            </div>
            <div v-else-if='contentData.contentId == 25'>
                <ClassStoryPost :content='contentData'></ClassStoryPost>
            </div>
            <div v-else-if='contentData.contentId == 26'>
                <InterClassStoryPost :content='contentData'></InterClassStoryPost>
            </div>
            <FooterPost :footerInfo='contentData'></FooterPost>
            <CommentView></CommentView>
        </v-container>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import QuestionnairePost from '~/components/contents/questionnairePost';
import VotingPost from '~/components/contents/votingPost';
import SmsPost from '~/components/contents/smsPost';
import CampusPost from '~/components/contents/campusPost';
import AnouncementPost from '~/components/contents/anouncementPost';
import BulletinBoardPost from '~/components/contents/bulletinBoardPost';
import RepaireDataPost from '~/components/contents/repairDataPost';
import SafeStudyPost from '~/components/contents/safeStudyPost';
import ShiftMngPost from '~/components/contents/shiftMngPost';
import HomeVisitPost from '~/components/contents/homeVisitPost';
import SchoolStoryPost from '~/components/contents/schoolStoryPost';
import HomeworkPost from '~/components/contents/homeworkPost';
import NotificationPost from '~/components/contents/notificationPost';
import EvaluationPost from '~/components/contents/evaluationPost';
import RecognitionPost from '~/components/contents/recognitionPost';
import SharePost from '~/components/contents/sharePost';
import RegNamePost from '~/components/contents/regnamePost';
import ClassStoryPost from '~/components/contents/classStoryPost';
import InterClassStoryPost from '~/components/contents/interClassStoryPost';
import VacationPost from '~/components/contents/vacationPost'
import FooterPost from '~/components/contents/footerPost';
import CommentView from '~/pages/school/posts/comments/commentView';
import RouterBack from '~/components/routerBack'
import lang from '~/helper/lang.json'
import {addComment,deleteComment} from '~/api/post'

import emojiData from "emoji-mart-vue-fast/data/all.json";
import "emoji-mart-vue-fast/css/emoji-mart.css";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast";
let emojiIndex = new EmojiIndex(emojiData);
import {updateShiftMng} from '~/api/shiftMng'
export default {
    components : {
        QuestionnairePost,
        VotingPost,
        SmsPost,
        CampusPost,
        AnouncementPost,
        BulletinBoardPost,
        RepaireDataPost,
        SafeStudyPost,
        ShiftMngPost,
        HomeVisitPost,
        SchoolStoryPost,
        HomeworkPost,
        NotificationPost,
        EvaluationPost,
        RecognitionPost,
        SharePost,
        RegNamePost,
        ClassStoryPost,
        InterClassStoryPost,
        FooterPost,
        CommentView,
        RouterBack,
        Picker,
        VacationPost
    },

    data:() => ({
        lang,
        emoStatus:false,
        commentText:'',
        isDeleting:false,

        emojiIndex: emojiIndex,
        emojisOutput: "",
        titleArr:[
            ''
        ],
        isCancel:false,
        isSubmit:false,
    }),
    computed:{
        ...mapGetters({
            contentData:'content/postDetail',
            user:'auth/user'
        }),
        currentpath(){
            return this.$route
        }
    },
    created(){
        if(this.contentData == null){
            if(this.$isMobile()){
                this.$router.push({name: 'home'})
            }
            else{
                if(this.currentpath.params.lessonId){
                  this.$router.push({name:'classSpace.news'})
                }else{
                  this.$router.push({name:'schoolSpace.news'})
                }
            }
        }
        this.contentData.comments.map(comment=>{
            this.$set(comment,'isDeleting',false)
        })
        console.log('CommentData',this.contentData)
    },
    methods:{
        outSidePicker(){
            this.emoStatus = false;
        },

        toggleEmo(){
            this.emoStatus = ! this.emoStatus
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
        newline(){
            this.commentText = `${this.commentText}\n`
        },
        submit(){
            if(this.commentText == ''){
                return;
            }
            addComment({text:this.commentText,postId:this.contentData.id}).then(res=>{
                console.log(res)
                this.contentData.comments.unshift(res.data)
            }).catch(err=>{
                //console.log(err.response)
            })
            this.commentText = ''
        },
        async remove(comment){
            console.log(comment)
            comment.isDeleting = true
            await deleteComment({id:comment.id}).then(res=>{
                let index = this.contentData.comments.indexOf(comment)
                if(index > -1){
                this.contentData.comments.splice(index,1)
                }
                comment.isDeleting = false
                console.log(res.data)
            }).catch(err=>{
                console.log(err.response)
                comment.isDeleting = false
            })
        },
        cancelShift(){
            console.log('updateShiftMng');
        },
        async confirmShift(){
            this.isSubmit = true
            let confirmDate = this.TimeView(Date.now());
            await updateShiftMng({shiftId:this.contentData.shift_mng.id,confirmDate:confirmDate}).then(res=>{
                this.isSubmit = false
                console.log(res.dat)
                if(this.currentpath.params.lessonId){
                    this.$router.push({name:'classSpace.news'})
                }else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                this.isSubmit = false
                console.log(err.response)
            })
        }
    }
}
</script>

<style>

</style>