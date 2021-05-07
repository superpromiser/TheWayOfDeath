<template>
  <v-container class="school-space-tab-bar-outter">
    <v-row class="pa-3">
      <v-container  v-if="contentList.length" class="pa-0" v-for="content in contentList" :key="content.id">
        <v-row class="pa-0 mt-1" v-if="content.contentId == 5 && content.anouncements">
          <AnouncementPost :content="content"></AnouncementPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 8 && content.safestudy">
          <SafeStudyPost :content='content'></SafeStudyPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 12 && content.questionnaires">
          <QusetionnairePost :content="content"></QusetionnairePost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 13 && content.votings">
          <VotingPost :content='content'></VotingPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 14 && content.homework">
          <!-- <SmsPost :content='content'></SmsPost> -->
          <HomeworkPost :content='content'></HomeworkPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <!-- <v-row class="pa-0 mt-1" v-else-if="content.contentId == 15">
          <CampusPost :content='content'></CampusPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row> -->
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 16 && content.home_visit">
          <HomeVisitPost :content="content"></HomeVisitPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 17 && content.notifications">
          <NotificationPost :content="content"></NotificationPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 18 && content.evaluations">
          <EvaluationPost :content="content"></EvaluationPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 19 && content.recognitions">
          <RecognitionPost :content="content"></RecognitionPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 20 && content.vacations">
          <VacationPost :content="content"></VacationPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <!-- <v-row class="pa-0 mt-1" v-else-if="content.contentId == 22 && content.homework_result">
          <HomeworkResultPost :content="content"></HomeworkResultPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row> -->
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 23 && content.shares">
          <SharePost :content='content'></SharePost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 24 && content.regnames">
          <RegnamePost :content='content'></RegnamePost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 25 && content.classstory">
          <ClassStoryPost :content="content"></ClassStoryPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 26 && content.interclassstory">
          <InterClassStoryPost :content="content"></InterClassStoryPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 27 && content.returnteam">
          <ReturnTeam :content="content"></ReturnTeam>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
      </v-container>
      <InfiniteLoading 
          class="pb-3 w-100"
          @infinite="infiniteHandler"
      >   
          <div slot="spinner">
            <v-row class="pa-3">
              <v-col cols="12" class="pt-10">
                <v-skeleton-loader
                  v-bind="attrs"
                  type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                  :loading="isLoadingContents"
                ></v-skeleton-loader>
              </v-col>
              <v-divider></v-divider>
              <v-col cols="12" class="pt-10">
                <v-skeleton-loader
                  v-bind="attrs"
                  type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                  :loading="isLoadingContents"
                ></v-skeleton-loader>
              </v-col>
              <v-divider></v-divider>
              <v-col cols="12" class="pt-10">
                <v-skeleton-loader
                  v-bind="attrs"
                  type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                  :loading="isLoadingContents"
                ></v-skeleton-loader>
              </v-col>
              <v-divider></v-divider>
              <v-col cols="12" class="pt-10">
                <v-skeleton-loader
                  v-bind="attrs"
                  type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                  :loading="isLoadingContents"
                ></v-skeleton-loader>
              </v-col>
              <v-divider></v-divider>
              <v-col cols="12" class="pt-10">
                <v-skeleton-loader
                  v-bind="attrs"
                  type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                  :loading="isLoadingContents"
                ></v-skeleton-loader>
              </v-col>
              <v-divider></v-divider>
              <v-col cols="12" class="pt-10">
                <v-skeleton-loader
                  v-bind="attrs"
                  type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                  :loading="isLoadingContents"
                ></v-skeleton-loader>
              </v-col>
              <v-divider></v-divider>
            </v-row>
          </div>
          <div slot="no-more" class="pa-3 ma-3 text-center">
            <v-chip
              class="ma-2"
              color="primary"
              outlined
              pill
            >
              没有更多数据
              <v-icon right>
                mdi-cancel 
              </v-icon>
            </v-chip>
          </div>
          <div slot="no-results" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
              <div class="w-100 text-center p-5 m-5 mt-10">
                  <v-icon size="150" color="grey darken-1">
                    mdi-magnify
                  </v-icon>
                  <h5>资料不存在</h5>
              </div>
          </div>
      </InfiniteLoading>
    </v-row>
    
  </v-container>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import {getClassPost,} from '~/api/post';
import FooterPost from '~/components/contents/footerPost'
import lang from '~/helper/lang.json'
import QusetionnairePost from '~/components/contents/questionnairePost'
import VotingPost from '~/components/contents/votingPost';
import AnouncementPost from '~/components/contents/anouncementPost'
import NotificationPost from '~/components/contents/notificationPost'
import HomeVisitPost from '~/components/contents/homeVisitPost'
import HomeworkPost from '~/components/contents/homeworkPost'
import EvaluationPost from '~/components/contents/evaluationPost'
import RecognitionPost from '~/components/contents/recognitionPost'
import HomeworkResultPost from '~/components/contents/homeworkResultPost'
import SharePost from '~/components/contents/sharePost'
import RegnamePost from '~/components/contents/regnamePost'
import ClassStoryPost from '~/components/contents/classStoryPost'
import InterClassStoryPost from '~/components/contents/interClassStoryPost'
import SafeStudyPost from '~/components/contents/safeStudyPost'
import ReturnTeam from '~/components/contents/returnTeam'
import VacationPost from '~/components/contents/vacationPost'
export default {
  components :{
    QusetionnairePost,
    VotingPost,
    AnouncementPost,
    FooterPost,
    NotificationPost,
    HomeVisitPost,
    HomeworkPost,
    EvaluationPost,
    RecognitionPost,
    SafeStudyPost,
    HomeworkResultPost,
    SharePost,
    RegnamePost,
    ClassStoryPost,
    InterClassStoryPost,
    ReturnTeam,
    InfiniteLoading,
    VacationPost
  },

  data: () => ({
    isLoadingContents:false,
    baseUrl:window.Laravel.base_url,
    attrs: {
      class: 'mb-6',
    },
    contentList: [],
    lang,
    //infinit loading
    pageOfContent: 1,
    lastPageOfContent: 0,
  }),
  
  computed:{
    currentPath(){
      return this.$route;
    }
  },

  watch:{
    $route(to, from) {
      // react to route changes...
      //console.log(from)
      // this.$router.go()
      //console.log('routerChanged')
      this.infiniteHandler($state)
      //console.log(to)
    }
  },

  async created(){
    // this.isLoadingContents = true;
    // await getClassPost(this.currentPath.params.classId).then(res=>{
    //   //console.log('success',res)
    //   this.contentList = res.data.data;
    // }).catch(err=>{
      
    //   //console.log('failed',err.response)
    // })
    // this.isLoadingContents = false;
  },

  methods:{
    async infiniteHandler($state){
      let timeOut = 0;
      this.isLoadingContents = true;
      if (this.pageOfContent > 1) {
          timeOut = 1000;
      }
      let vm = this;
      await getClassPost(this.currentPath.params.lessonId, this.pageOfContent)
      .then(res=>{
          if(vm.pageOfContent == 1 && res.data.data.length == 0){
              $state.complete();
              return;
          }
          vm.lastpageOfContent = res.data.last_page;

          $.each(res.data.data, function(key, value){
              vm.contentList.push(value); 
          });
          if (vm.pageOfContent - 1 === vm.lastpageOfContent) {
              $state.complete();
          }
          else {
              $state.loaded();
          }
          vm.pageOfContent = vm.pageOfContent + 1;
      });
      this.isLoadingContents = false;
      console.log("this.contentList", this.contentList);
    },

    updateFooterInfo(data){
      let index = this.contentList.findIndex(content=>content.id === data.id)
      if(index > -1){
        
      }
    }
  }
}
</script>

<style>

</style>