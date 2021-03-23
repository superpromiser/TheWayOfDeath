<template>
  <v-container class="school-space-tab-bar-outter px-lg-10">
    <v-row v-if="isLoadingContents" class="pa-3">
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
    <v-row v-else class="pa-3">
      <v-col v-if="contentList.length == 0">
        {{lang.noData}}
      </v-col>
      <v-container class="pa-0" v-for="content in contentList" :key="content.id" v-else>
        <v-row class="pa-0 mt-1" v-if="content.contentId == 1">
          <QusetionnairePost :content="content"></QusetionnairePost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 2">
          <VotingPost :content='content'></VotingPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 3">
          <SmsPost :content='content'></SmsPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 4">
          <CampusPost :content='content'></CampusPost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 5">
          <AnouncementPost :content="content"></AnouncementPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 6">
          <BulletinBoardPost :content='content'></BulletinBoardPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 10">
          <HomeVisitPost :content='content'></HomeVisitPost>
          <FooterPost :footerInfo='content' @updateFooterInfo='updateFooterInfo'></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else>
          {{contentList}}
        </v-row>
      </v-container>
      
    </v-row>
    
  </v-container>
</template>

<script>
import {getSchoolPost} from '~/api/post';
import FooterPost from '~/components/contents/footerPost'
import lang from '~/helper/lang.json'
import QusetionnairePost from '~/components/contents/questionnairePost'
import VotingPost from '~/components/contents/votingPost';
import SmsPost from '~/components/contents/smsPost';
import CampusPost from '~/components/contents/CampusPost'
import AnouncementPost from '~/components/contents/anouncementPost'
import BulletinBoardPost from '~/components/contents/bulletinBoardPost'
import HomeVisitPost from '~/components/contents/homeVisitPost'
export default {
  components :{
    QusetionnairePost,
    VotingPost,
    SmsPost,
    FooterPost,
    CampusPost,
    AnouncementPost,
    BulletinBoardPost,
    HomeVisitPost,
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
    await getSchoolPost().then(res=>{
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