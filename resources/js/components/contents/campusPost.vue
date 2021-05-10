<template>
    <v-container class="pa-0" v-if="$isMobile()">
      <v-row class="ma-0">
        <v-col cols="12" class="d-flex" @click="showDetail(content)">
          <v-avatar>
            <v-img :src="`${baseUrl}/asset/img/appIcon/校园文化/校园动态.png`" alt="postItem" ></v-img>
          </v-avatar>
          <div class="ml-2 d-flex flex-column">
            <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.campus}}  </p>
            <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(content.created_at)}} 转发</span> {{content.users.name}}</p>
          </div>
        </v-col>
        <v-col cols="12" class="py-0 font-size-0-8">
          <v-card
            tile
            class="mx-auto"
            max-width="800"
          >
            <v-img height="250" :src="`${baseUrl}${content.campus.imgUrl}`" ></v-img>
            <v-card-title class="px-3 py-2" style="font-size:0.8rem!important">{{content.campus.title}}</v-card-title>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-else>
        <v-col cols="12" class="d-flex align-center hover-cursor-point" @click="showDetail(content)">
            <v-avatar class="ma-3 school-card-avatar" tile >
              <v-img :src="`${baseUrl}/asset/img/newIcon/校园动态.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{lang.campus}}  </p>
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
           <v-card
              tile
              class="mx-auto"
              max-width="800"
            >
              <v-img height="450" :src="`${baseUrl}${content.campus.imgUrl}`" ></v-img>
              <v-card-title>{{content.campus.title}}</v-card-title>
            </v-card>
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
    }),
    computed:{
      currentPath(){
        return this.$route
      }
    },
    mounted(){
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