<template>
  <v-container>
    <v-row class="justify-center align-center z-index-2 banner-custom">
      <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
          mdi-chevron-left
      </v-icon>
      <h2 class="py-7">{{lang.campus}}</h2>
    </v-row>
    <v-row class="pl-10 pt-0">
      <v-col cols="12" >
          {{contentData.campus.category}}
      </v-col>
      <v-col cols="12">
        <div class="vhtmlShow" v-html="contentData.campus.content"></div>
      </v-col>
    </v-row>
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
        // contentData:null
        lang,
        baseUrl:window.Laravel.base_url,
    }),

    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail'
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
        this.contentData.campus.content = JSON.parse(this.contentData.campus.content)
        console.log(this.contentData)
    }
}
</script>

<style>

</style>