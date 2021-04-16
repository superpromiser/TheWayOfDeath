<template>
  <v-container>
    <v-row class="px-10 z-index-2 banner-custom">
      <v-col cols="6" md="4" class="d-flex align-center position-relative">
        <a @click="$router.go(-1)" class="float-left">
          <v-icon size="70" class=" left-24p">
              mdi-chevron-left
          </v-icon>
        </a>
      </v-col>
      <v-col  cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
        <h2>{{lang.sms}}</h2>
      </v-col>
      <v-col cols="12" md="4" class="d-flex align-center justify-end"></v-col>
    </v-row>
    <!-- <v-col cols="12" class="d-flex align-center">
        <a @click="$router.go(-1)" class="float-left">
            <v-icon size="70">
                mdi-chevron-left
            </v-icon>
        </a>
      <v-avatar class="ma-3 school-card-avatar" tile >
        <v-img :src="`${baseUrl}/asset/img/icon/短信 拷贝.png`" alt="postItem" ></v-img>
      </v-avatar>
      <div>
        <p class="font-weight-black fs-15 mb-3"> {{lang.sms}}  </p>
        <div class="d-flex align-center">
          <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
          <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
          <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
          <p class="mb-0">{{contentData.users.name}}</p>
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
              <v-list-item-title class="px-2">{{lang.toTop}}</v-list-item-title>
            </v-list-item>
            <v-list-item link >
              <v-list-item-title class="px-2" @click="postRemove(contentData)">{{lang.remove}}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-col> -->
    <v-col cols="12" class="pl-10 mt-5">
      <v-row>
        <v-col cols="12">
          <p class="text-wrap"><read-more more-str="全文" :text="smsData[0].text" link="#" less-str="收起" :max-chars="250"></read-more></p>
        </v-col>
        <v-col cols="12" v-if="checkIfAttachExist(smsData[0])">
          <AttachItemViewer :items="smsData[0]" />
        </v-col>
      </v-row>
    </v-col>
  </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
export default {
    components:{
        AttachItemViewer,
    },
    data:()=>({
        lang,
        baseUrl:window.Laravel.base_url,
        smsData: {},
    }),

    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail',
            user:'auth/user'
        })
    },

    created(){
        if(this.contentData == null){
          if(this.currentpath.params.lessonId){
            this.$router.push({name:'classSpace.news'})
          }else{
            this.$router.push({name:'schoolSpace.news'})
          }
        }
        this.smsData = JSON.parse(this.contentData.sms.content);
        console.log(this.contentData)
        console.log(this.user)
    }
}
</script>

<style>

</style>