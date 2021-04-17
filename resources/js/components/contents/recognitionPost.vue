<template>
  <v-container v-if="$isMobile()">
    <v-row>
      <v-col cols="12" class="d-flex" @click="showDetail(content)">
        <v-avatar>
          <v-img :src="`${baseUrl}/asset/img/icon/表彰.png`" alt="postItem" ></v-img>
        </v-avatar>
        <div class="ml-2 d-flex flex-column">
          <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.recognition}}  </p>
          <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(content.created_at)}} 转发</span> {{content.users.name}}</p>
        </div>
      </v-col>
    </v-row>
  </v-container>
  <v-container v-else>
      <v-col cols="12" class="d-flex align-center" @click="showDetail(content)">
          <v-avatar class="ma-3 school-card-avatar" tile >
            <v-img :src="`${baseUrl}/asset/img/icon/表彰.png`" alt="postItem" ></v-img>
          </v-avatar>
          <div>
            <p class="font-weight-black fs-15 mb-3"> {{lang.recognition}}  </p>
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
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
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
    methods:{
      showDetail(content){
        this.$store.dispatch('content/storePostDetail',content)
        this.$router.push({name:'details.classRecognition'});
      }
    }
}
</script>

<style>

</style>