<template>
  <v-container class="school-space-tab-bar-outter px-lg-10">
    <v-row v-if="isLoadingContents" class="pa-3">
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row v-else class="pa-3">
      <v-col v-if="contentList.length == 0">
        {{lang.noData}}
      </v-col>
      <v-container class="pa-0" v-for="content in contentList" :key="content.id" v-else>
        <v-row class="pa-0 mt-1" v-if="content.contentId == 12">
          <QusetionnairePost :content="content"></QusetionnairePost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 13">
          <VotingPost :content='content'></VotingPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 14">
          <!-- <SmsPost :content='content'></SmsPost> -->
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 15">
          <!-- <CampusPost :content='content'></CampusPost> -->
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 16">
          <HomeVisitPost :content="content"></HomeVisitPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 17">
          <NotificationPost :content="content"></NotificationPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 18">
          <EvaluationPost :content="content"></EvaluationPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 19">
          <RecognitionPost :content="content"></RecognitionPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
      </v-container>
      
    </v-row>
    
  </v-container>
</template>

<script>
import {getClassPost,} from '~/api/post';
import FooterPost from '~/components/contents/footerPost'
import lang from '~/helper/lang.json'
import QusetionnairePost from '~/components/contents/questionnairePost'
import VotingPost from '~/components/contents/votingPost';
import NotificationPost from '~/components/contents/notificationPost'
import HomeVisitPost from '~/components/contents/homeVisitPost'
import EvaluationPost from '~/components/contents/evaluationPost'
import RecognitionPost from '~/components/contents/recognitionPost'
export default {
  components :{
    QusetionnairePost,
    VotingPost,
    FooterPost,
    NotificationPost,
    HomeVisitPost,
    EvaluationPost,
    RecognitionPost,
  },

  data: () => ({
    isLoadingContents:false,
    baseUrl:window.Laravel.base_url,
    attrs: {
      class: 'mb-6',
    },
    contentList: [],
    lang,
  }),
  
  computed:{
    currentPath(){
      return this.$route;
    }
  },

  watch:{
    $route(to, from) {
      // react to route changes...
      console.log(from)
      this.$router.go()
      console.log('routerChanged')
      console.log(to)
    }
  },

  async created(){
    this.isLoadingContents = true;
    await getClassPost(this.currentPath.params.classId).then(res=>{
      console.log('success',res)
      this.contentList = res.data.data;
    }).catch(err=>{
      
      console.log('failed',err.response)
    })
    this.isLoadingContents = false;
  },

  methods:{
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