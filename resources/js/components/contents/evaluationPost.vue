<template>
    <v-container v-if="$isMobile()">
      <v-row>
        <v-col cols="12" class="d-flex hover-cursor-point" @click="showDetail(content)">
          <v-avatar>
            <v-img :src="`${baseUrl}/asset/img/icon/评价.png`" alt="postItem" ></v-img>
          </v-avatar>
          <div class="ml-2 d-flex flex-column">
            <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.evaluation}}  </p>
            <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(content.created_at)}} 转发</span> {{content.users.name}}</p>
          </div>
        </v-col>
        <v-col cols="12" class="py-0">
          <v-chip v-for="user in userList" :key="user.id" class="ml-2 hover-cursor-point">
            @{{user.name}}
          </v-chip>
        </v-col>
        <v-col cols="12" class="py-0">

        </v-col>
      </v-row>
    </v-container>
    <v-container v-else>
        <v-col cols="12" class="d-flex align-center hover-cursor-point" @click="showDetail(content)">
            <v-avatar class="ma-3 school-card-avatar" tile >
              <v-img :src="`${baseUrl}/asset/img/icon/评价.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{lang.evaluation}}  </p>
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
                    <v-list-item-title class="px-2" @click="fixTop(content)">{{lang.toTop}}</v-list-item-title>
                  </v-list-item>
                  <v-list-item link >
                    <v-list-item-title class="px-2" @click="postRemove(content)">{{lang.remove}}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>
        </v-col>
        <v-col cols="12" class="pl-10 pt-0">
          <v-chip v-for="user in userList" :key="user.id" class="ml-2 hover-cursor-point">
            @{{user.name}}
          </v-chip>
        </v-col>
        <v-col cols="12" class="pl-10 pt-0">
          <!-- <v-img
            :src="`${baseUrl}/asset/img/icon/medal/medal_plus_background.7422ef6e.png`"
            class="medal-background"
          ></v-img>
          <v-col cols="6" sm="4" md="4" lg="3" class="d-flex justify-center" v-for="(medalItem, j) in medalGroup.menuList" :key="j">
            <img v-for="(medalItem,idx) in medalList" :key="idx" :src="`${baseUrl}/asset/img/icon/medal_empty.png`" :style="medalItem.medalImg" alt="" class="md-logo">
          </v-col> -->
        </v-col>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {createReadCnt} from '~/api/alarm'
export default {
    props:{
        content:{
            type:Object,
            required:true
        }
    },
    data:()=>({
        lang,
        baseUrl:window.Laravel.base_url,
        userList:[],
        medalList:[],
    }),
    created(){
      this.userList = JSON.parse(this.content.evaluations.userList)
      this.medalList = this.content.evaluations.selMedalList
    },
    computed:{
      currentPath(){
        return this.$route
      }
    },
    methods:{
      showDetail(content){
        createReadCnt({postId:content.id}).then(res=>{
          console.log(res.data)
        }).catch(err=>{
          console.log(err.response)
        })
        this.$store.dispatch('content/storePostDetail',content)
        if(this.currentPath.params.lessonId){
          this.$router.push({name:'details.classDefault'});
        }else{
          this.$router.push({name:'details.schoolDefault'});
        }
        
      }
    }
}
</script>

<style>

</style>