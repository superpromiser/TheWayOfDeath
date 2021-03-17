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
        <v-row class="pa-0 mt-1" v-if="content.contentId == 1">
          <QusetionnairePost :content="content"></QusetionnairePost>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 2">
           <v-col cols="12" class="d-flex align-center">
            <v-avatar class="ma-3 school-card-avatar" tile >
              <v-img :src="`${baseUrl}/asset/img/icon/投票.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{lang.voting}}  </p>
              <div class="d-flex align-center">
                <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8">{{TimeView(content.created_at)}}</p>
                <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                <p class="mb-0">{{content.users.name}}</p>
              </div>
            </div>
            <div class="ml-auto">
              <v-menu offset-y >
                <template v-slot:activator="{ attrs, on }">
                  <v-btn icon color="primary" v-bind="attrs" v-on="on" >
                    <v-icon size="30">mdi-chevron-down </v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item link >
                    <v-list-item-title >{{lang.toTop}}</v-list-item-title>
                  </v-list-item>
                  <v-list-item link >
                    <v-list-item-title >{{lang.remove}}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>
          </v-col>
          <v-col cols="12" class="pl-10 pt-0">
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>投票类型:</strong>
                {{content.votings.votingType}}
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>调查范围:</strong>
                {{content.votings.maxVote}}
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>截止时间:</strong>
                {{content.votings.deadline}}
              </p>
            </div>
            <div>
              <v-btn
                rounded
                color="success"
                outlined
                class="ma-1"
                @click="showDetail(content)"
              >
                <v-icon left>
                  mdi-hand
                </v-icon>
                {{lang.viewDetail}}
              </v-btn>
            </div>
          </v-col>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
        <v-row class="pa-0 mt-1" v-else-if="content.contentId == 3">
           <v-col cols="12" class="d-flex align-center">
            <v-avatar class="ma-3 school-card-avatar" tile >
              <v-img :src="`${baseUrl}/asset/img/icon/投票.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{lang.sms}}  </p>
              <div class="d-flex align-center">
                <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8">{{TimeView(content.created_at)}}</p>
                <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                <p class="mb-0">{{content.users.name}}</p>
              </div>
            </div>
            <div class="ml-auto">
              <v-menu offset-y >
                <template v-slot:activator="{ attrs, on }">
                  <v-btn icon color="primary" v-bind="attrs" v-on="on" >
                    <v-icon size="30">mdi-chevron-down </v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item link >
                    <v-list-item-title >{{lang.toTop}}</v-list-item-title>
                  </v-list-item>
                  <v-list-item link >
                    <v-list-item-title >{{lang.remove}}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>
          </v-col>
          <v-col cols="12" class="pl-10 pt-0">
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>投票类型:</strong>
                <!-- {{content.votings.votingType}} -->
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>调查范围:</strong>
                <!-- {{content.votings.maxVote}} -->
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>截止时间:</strong>
                <!-- {{content.votings.deadline}} -->
              </p>
            </div>
            <div>
              <v-btn
                rounded
                color="success"
                outlined
                class="ma-1"
                @click="showDetail(content)"
              >
                <v-icon left>
                  mdi-hand
                </v-icon>
                {{lang.viewDetail}}
              </v-btn>
            </div>
          </v-col>
          <FooterPost :footerInfo='content' @updateFooterInfo="updateFooterInfo"></FooterPost>
        </v-row>
      </v-container>
      
    </v-row>
    
  </v-container>
</template>

<script>
import {getAllPost,} from '~/api/post';
import FooterPost from '~/components/contents/footerPost'
import lang from '~/helper/lang.json'
import QusetionnairePost from '~/components/contents/questionnairePost'
export default {
  components :{
    QusetionnairePost,
    FooterPost
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

  async created(){
    this.isLoadingContents = true;
    await getAllPost().then(res=>{
      console.log('success',res)
      this.contentList = res.data.data;
    }).catch(err=>{
      
      console.log('failed',err.response)
    })
    this.isLoadingContents = false;
  },

  methods:{
    showDetail(content){
      this.$store.dispatch('content/storePostDetail',content)
      this.$router.push({name:'posts.detail'});
    },
    likePost(postId){
      console.log(postId)
    },
    updateFooterInfo(data){
      let index = this.contentList.findIndex(content=>content.id === data.contentId);
      if(index > -1){
        this.contentList[index].isLiked = data.isLiked
        this.contentList[index].likeCnt = data.likeCnt
        this.contentList[index].commentCnt = data.commentCnt
      }
    }
  }
}
</script>

<style>

</style>