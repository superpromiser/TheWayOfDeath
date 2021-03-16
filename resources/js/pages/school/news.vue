<template>
  <v-container class="school-space-tab-bar-outter px-lg-10">
    <v-row v-if="isLoadingContents" class="pa-3">
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, heading, list-item, list-item,  heading, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row v-else class="pa-3">
      <v-container class="pa-0" v-for="content in contentList" :key="content.id">
        <v-row class="pa-0" v-if="content.contentId == 1">
          <v-col cols="12" class="d-flex align-center">
            <v-avatar class="ma-3 school-card-avatar" tile >
              <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> 问卷  </p>
              <div class="d-flex align-center">
                <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8">{{TimeView(content.created_at)}}</p>
                <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                <p class="mb-0">sammie</p>
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
                    <v-list-item-title >置顶</v-list-item-title>
                  </v-list-item>
                  <v-list-item link >
                    <v-list-item-title >删除</v-list-item-title>
                  </v-list-item>
                  <v-list-item link >
                    <v-list-item-title >AAA</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>
          </v-col>
          <v-col cols="12" class="pl-10 pt-0">
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>问卷标题:</strong>
                {{content.questionnaires.title}}
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>问卷说明:</strong>
                {{content.questionnaires.desc}}
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>截止时间:</strong>
                {{content.questionnaires.deadline}}
              </p>
            </div>
            <div>
              <v-btn
                rounded
                color="success"
                outlined
                class="ma-1"
              >
                <v-icon left>
                  mdi-hand
                </v-icon>
                查看详情查看详情
              </v-btn>
            </div>
          </v-col>
          <v-col cols="12" class="pt-2">
            <div class="d-flex align-center justify-end">
              <v-icon medium color="primary" class="mr-2">mdi-eye</v-icon>
              <p class="mb-0 mr-8">34人</p>
              <v-btn icon color="red accent-3" >
                <v-icon size="30">mdi-heart </v-icon>
              </v-btn>
              <v-btn icon color="success" >
                <v-icon size="30">mdi-message-outline  </v-icon>
              </v-btn>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-row>
    
  </v-container>
</template>

<script>
import {getAllPost,} from '~/api/post';
export default {
  data: () => ({
    isLoadingContents:false,
    baseUrl:window.Laravel.base_url,
    attrs: {
      class: 'mb-6',
    },
    contentList: [],
  }),

  async created(){
    this.isLoadingContents = true;
    await getAllPost().then(res=>{
      console.log('success',res)
      this.contentList = res.data;
    }).catch(err=>{
      
      console.log('failed',err.response)
    })
    this.isLoadingContents = false;
  }
}
</script>

<style>

</style>