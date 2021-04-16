<template>
  <v-container>
    <v-col cols="12" class="d-flex align-center hover-cursor-point" @click="showDetail(content)">
      <v-avatar class="ma-3 school-card-avatar" tile >
        <v-img :src="`${baseUrl}/asset/img/newIcon/分享.png`" alt="postItem" ></v-img>
      </v-avatar>
      <div>
        <p class="font-weight-black fs-15 mb-3"> {{lang.share}}  </p>
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
      <v-row>
        <v-col cols="12">
          <p class="text-wrap"><read-more more-str="全文" :text="shareData[0].text" link="#" less-str="收起" :max-chars="250"></read-more></p>
        </v-col>
        <v-col cols="12" v-if="checkIfAttachExist(shareData[0])">
          <AttachItemViewer :items="shareData[0]" />
        </v-col>
      </v-row>
    </v-col>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
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
    data:() => ({
        lang,
        baseUrl:window.Laravel.base_url,
        shareData: {},
    }),
    created(){
      this.shareData = JSON.parse(this.content.shares.content);
    },
    methods:{

      showDetail(content){
        this.$store.dispatch('content/storePostDetail',content)
        this.$router.push({name:'details.share'});
      },
      
    }

}
</script>

<style>

</style>