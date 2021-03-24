<template>
    <v-container>
        <v-col cols="12" class="d-flex align-center" @click="showDetail(content)">
            <v-avatar class="ma-3 school-card-avatar" tile >
              <v-img :src="`${baseUrl}/asset/img/icon/家访 拷贝.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{lang.homeVisit}}  </p>
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
                    <v-list-item-title class="px-2">{{lang.toTop}}</v-list-item-title>
                  </v-list-item>
                  <v-list-item link >
                    <v-list-item-title class="px-2" @click="postRemove(content)">{{lang.remove}}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>
        </v-col>
        <v-col cols="12" class="pl-10 pt-0">
          <div class="d-flex align-center">
            <p class="text-wrap mb-0">
              <strong>截止日期:</strong>
              {{TimeView(homeVisitData.deadline)}}
            </p>
          </div>
          <div class="d-flex align-center">
            <p class="text-wrap mb-0">
              <strong>家访内容:</strong>
              {{homeVisitData.type}}
            </p>
          </div>
        </v-col>
        <v-col cols="12" class="pl-10 pt-0">
          <v-row>
            <v-col cols="12">
              <p class="text-wrap"><read-more more-str="全文" :text="homeVisitData.content.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
            </v-col>
            <v-col cols="12" v-if="checkIfAttachExist(homeVisitData.content)">
              <AttachItemViewer :items="homeVisitData.content" />
            </v-col>
          </v-row>
        </v-col>
    </v-container>
</template>

<script>
import AttachItemViewer from '~/components/attachItemViewer';
import lang from '~/helper/lang.json'
export default {
    components:{
        AttachItemViewer,
    },
    props:{
        content:{
            type:Object,
            required:true
        }
    },
    data:()=>({
        lang,
        baseUrl:window.Laravel.base_url,
        homeVisitData: null,
    }),
    created(){
      this.homeVisitData = this.content.home_visit;
      this.homeVisitData.content = JSON.parse(this.homeVisitData.content); 
      this.homeVisitData.description = JSON.parse(this.homeVisitData.description); 
    },
    methods:{
      showDetail(content){
        this.$store.dispatch('content/storePostDetail',content)
        this.$router.push({name:'details.homeVisit'});
      }
    }
}
</script>

<style>

</style>