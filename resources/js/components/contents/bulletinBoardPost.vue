<template>
    <v-container v-if="$isMobile()">
      <v-row>
        <v-col cols="12" class="d-flex" @click="showDetail(content)">
          <v-avatar>
            <v-img :src="`${baseUrl}/asset/img/appIcon/others/bulletinboard.png`" alt="postItem" ></v-img>
          </v-avatar>
          <div class="ml-2 d-flex flex-column">
            <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color">{{lang.bulletin}} ▪ {{bulletinBoardData.type}} </p>
            <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(content.created_at)}} 转发</span> {{content.users.name}}</p>
          </div>
        </v-col>
        <v-col cols="12" class="pb-0">
          <p class="text-wrap mb-0 font-size-0-75"><read-more more-str="全文" :text="bulletinBoardData.content.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
        </v-col>
        <v-col cols="12" class="py-0" v-if="checkIfAttachExist(bulletinBoardData.content)">
          <AttachItemViewer :items="bulletinBoardData.content" />
        </v-col>
      </v-row>
    </v-container>
    <v-container v-else>
        <v-col cols="12" class="d-flex align-center hover-cursor-point" @click="showDetail(content)">
            <v-avatar class="ma-3 school-card-avatar" tile >
              <v-img :src="`${baseUrl}/asset/img/newIcon/布告栏.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{lang.bulletin}} ▪ {{bulletinBoardData.type}}  </p>
              <div class="d-flex align-center">
                <v-icon medium color="#7879ff" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8">{{TimeView(content.created_at)}}</p>
                <v-icon medium color="#7879ff" class="mr-2">mdi-account </v-icon>
                <p class="mb-0">{{content.users.name}}</p>
              </div>
            </div>
            <div class="ml-auto">
              <v-menu offset-y >
                <template v-slot:activator="{ attrs, on }">
                  <v-btn icon color="#7879ff" v-bind="attrs" v-on="on" >
                    <v-icon size="30">mdi-chevron-down </v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item link >
                    <v-list-item-title class="px-2" @click="fixTop(content)" v-if="content.fixTop == null">{{lang.toTop}}</v-list-item-title>
                    <v-list-item-title class="px-2" @click="relaseTop(content.id)" v-else>{{lang.toRelase}}</v-list-item-title>
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
              <p class="text-wrap"><read-more more-str="全文" :text="bulletinBoardData.content.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
            </v-col>
            <v-col cols="12" v-if="checkIfAttachExist(bulletinBoardData.content)" >
              <AttachItemViewer :items="bulletinBoardData.content" />
            </v-col>
          </v-row>
        </v-col>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import AttachItemViewer from '~/components/attachItemViewer'
import {createReadCnt} from '~/api/alarm'
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
        bulletinBoardData: null,
    }),
    computed:{
      currentPath(){
        return this.$route
      }
    },
    created(){
      this.bulletinBoardData = this.content.bulletin_boards;
      this.bulletinBoardData.content = JSON.parse(this.bulletinBoardData.content);
    },
    methods:{
      showDetail(content){
        createReadCnt({postId:content.id}).then(res=>{
        }).catch(err=>{
          console.log(err.response)
        })
        this.$store.dispatch('content/storePostDetail',content)
        if(this.currentPath.params.lessonId){
          this.$router.push({name:'details.classDefault'});
        }else{
          this.$router.push({name:'details.schoolDefault'});
        }
      },
    }
}
</script>

<style>

</style>