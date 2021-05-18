<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
      <v-container class="pt-0 px-0 h-100 bg-white pt-12">
        <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.bulletin}} ▪ {{bulletinBoardData.type}}</p>
        </v-row>
        <div class="cus-divider-light-gray-height"></div>
        <v-row class="ma-0">
          <v-col cols="12">
            <p class="text-wrap"><read-more more-str="全文" :text="bulletinBoardData.content.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
          </v-col>
          <v-col cols="12" v-if="checkIfAttachExist(bulletinBoardData.content)" >
            <AttachItemViewer :items="bulletinBoardData.content" />
          </v-col>
        </v-row>
      </v-container>
    </v-container>
    <v-container v-else>
      <v-row class="justify-center align-center z-index-2 banner-custom">
        <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
            mdi-chevron-left
        </v-icon>
        <h2 class="py-7">{{lang.bulletin}} ▪ {{bulletinBoardData.type}}</h2>
      </v-row>
      <v-row class="pl-10 pt-0">
        <v-col cols="12">
          <p class="text-wrap"><read-more more-str="全文" :text="bulletinBoardData.content.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
        </v-col>
        <v-col cols="12" v-if="checkIfAttachExist(bulletinBoardData.content)" >
          <AttachItemViewer :items="bulletinBoardData.content" />
        </v-col>
      </v-row>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json'
import AttachItemViewer from '~/components/attachItemViewer'
export default {
    components:{
      AttachItemViewer,
    },
    data:()=>({
        // contentData:null
        lang,
        baseUrl:window.Laravel.base_url,
        bulletinBoardData: null,
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
        this.bulletinBoardData = this.contentData.bulletin_boards;
        console.log(this.bulletinBoardData.content)
        // this.bulletinBoardData.content = JSON.parse(this.bulletinBoardData.content);
    }
}
</script>

<style>

</style>