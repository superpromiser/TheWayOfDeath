<template>
  <v-container class="school-space-tab-bar-outter px-lg-10">
    <v-row v-if="isLoadingContents" class="pa-3">
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
      <v-col cols="12">
        <v-skeleton-loader
          v-bind="attrs"
          type=" list-item-avatar-two-line, list-item-three-line, actions"
          :loading="isLoadingContents"
        ></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row v-else class="pa-3">
      <v-col cols="12" class="d-flex align-center">
        <v-avatar class="ma-3 school-card-avatar" tile >
          <!-- <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" ></v-img> -->
          <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
        </v-avatar>
        <div>
          <p class="font-weight-black fs-15 mb-3"> 问卷  </p>
          <div class="d-flex align-center">
            <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
            <p class="mb-0 mr-8">2020-02-11 11:20 am</p>
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
                <v-list-item-title >something</v-list-item-title>
              </v-list-item>
              <v-list-item link >
                <v-list-item-title >something</v-list-item-title>
              </v-list-item>
              <v-list-item link >
                <v-list-item-title >something</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </div>
      </v-col>
      <v-col cols="12" class="pl-10">
        <p class="text-wrap">
          人習電害新得都生致最上的年育相用見接價長過才邊我是用對每石，進怎衣差一容爸發治。自地型。女成同；為長山都，實問那山考經小要有成的住，不保作出施得性盡吃便子心細！電子布我題健原師的；辦興量樂他先展推看常方我全房的……所好族，館從家世可看是頭都，就全族安信學積認轉算生動，大已從！假內華只才代為事不做見家每一可情續能星可部地。張小的花覺系北有病離第。以人體件寫士是：一交金離行任東只主，會題國難為。
        </p>
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
</template>

<script>
export default {
  data: () => ({
    isLoadingContents:true,
    baseUrl:window.Laravel.base_url,
    attrs: {
      class: 'mb-6',
      
    },
  }),

}
</script>

<style>

</style>