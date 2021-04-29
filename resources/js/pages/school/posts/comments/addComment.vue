<template>
    <v-container class="pa-0">
        <!-- {{contentData}} -->
        <RouterBack title='评论'></RouterBack>
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
        <CommentView></CommentView>
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

import FooterPost from '~/components/contents/footerPost';
import CommentView from './commentView';
import RouterBack from '~/components/routerBack'
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
        RouterBack
    },

    data:() => ({

    }),
    computed:{
        ...mapGetters({
            contentData:'content/postDetail'
        }),
        currentpath(){
            return this.$route
        }
    },
    created(){
        if(this.contentData == null){
          if(this.currentpath.params.lessonId){
            this.$router.push({name:'classSpace.news'})
          }else{
            this.$router.push({name:'schoolSpace.news'})
          }
        }
        //console.log('CommentData',this.contentData)
    }
}
</script>

<style>

</style>