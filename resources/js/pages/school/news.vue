<template>
  <v-container class="school-space-tab-bar-outter">
    <v-row class="pa-3">
      <v-container v-if="contentList.length" class="pa-0" v-for="content in contentList" :key="content.id" >
        <v-row class="pa-0 mt-1" v-if="content.contentId == 1 && content.questionnaires">
          <QusetionnairePost :content="content"></QusetionnairePost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 2 && content.votings">
          <VotingPost :content='content'></VotingPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 3 && content.sms">
          <SmsPost :content='content'></SmsPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 4 && content.campus">
          <CampusPost :content='content'></CampusPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 5 && content.anouncements">
          <AnouncementPost :content="content"></AnouncementPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 6 && content.bulletin_boards">
          <BulletinBoardPost :content='content'></BulletinBoardPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 7 && content.repairdata">
          <RepairDataPost :content='content'></RepairDataPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 8 && content.safestudy">
          <SafeStudyPost :content='content'></SafeStudyPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 9 && content.shift_mng">
          <ShiftMngPost :content='content'></ShiftMngPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 10 && content.home_visit">
          <HomeVisitPost :content='content'></HomeVisitPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 11 && content.schoolstory">
          <SchoolStoryPost :content='content'></SchoolStoryPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 23 && content.shares">
          <SharePost :content='content'></SharePost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 24 && content.regnames">
          <RegnamePost :content='content'></RegnamePost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <!-- <v-row class="pa-0 mt-1" v-else>
          {{content}}
        </v-row> -->
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
              color="#7879ff"
              outlined
              pill
            >
              暂无
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
                  <h5>暂无</h5>
              </div>
          </div>
      </InfiniteLoading>
    </v-row>
  </v-container>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import {getSchoolPost} from '~/api/post';
import FooterPost from '~/components/contents/footerPost'
import lang from '~/helper/lang.json'
import QusetionnairePost from '~/components/contents/questionnairePost'
import VotingPost from '~/components/contents/votingPost';
import SmsPost from '~/components/contents/smsPost';
import CampusPost from '~/components/contents/campusPost'
import AnouncementPost from '~/components/contents/anouncementPost'
import BulletinBoardPost from '~/components/contents/bulletinBoardPost'
import HomeVisitPost from '~/components/contents/homeVisitPost'
import SharePost from '~/components/contents/sharePost'
import RegnamePost from '~/components/contents/regnamePost'
import ShiftMngPost from '~/components/contents/shiftMngPost'
import SafeStudyPost from '~/components/contents/safeStudyPost'
import RepairDataPost from '~/components/contents/repairDataPost'
import SchoolStoryPost from '~/components/contents/schoolStoryPost'
import NewComment from '~/pages/school/posts/comments/newComment'
export default {
  middleware: 'auth',
  components :{
    QusetionnairePost,
    VotingPost,
    SmsPost,
    FooterPost,
    CampusPost,
    AnouncementPost,
    BulletinBoardPost,
    HomeVisitPost,
    SharePost,
    RegnamePost,
    ShiftMngPost,
    SafeStudyPost,
    RepairDataPost,
    SchoolStoryPost,
    InfiniteLoading,
    NewComment
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

  async created(){
    console.log(this.currentPath)
    // this.isLoadingContents = true;
    // await getSchoolPost().then(res=>{
    //   //console.log('success',res)
    //   this.contentList = res.data.data;
    // }).catch(err=>{
      
    //   //console.log('failed',err.response)
    // })
    // this.isLoadingContents = false;
  },
  computed:{
    currentPath(){
      return this.$route
    }
  },
  methods:{
    updateFooterInfo(data){
      let index = this.contentList.findIndex(content=>content.id === data.id)
      if(index > -1){
        
      }
    },
    async infiniteHandler($state){
      let timeOut = 0;
      this.isLoadingContents = true;
      if (this.pageOfContent > 1) {
          timeOut = 1000;
      }
      let vm = this;
      await getSchoolPost({page:this.pageOfContent,schoolId:this.currentPath.params.schoolId})
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
    },
  }
}
</script>

<style>

</style>