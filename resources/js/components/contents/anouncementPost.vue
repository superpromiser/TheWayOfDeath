<template>
    <v-container>
        <v-col cols="12" class="d-flex align-center">
            <v-avatar class="ma-3 school-card-avatar" tile >
              <v-img :src="`${baseUrl}/asset/img/newIcon/公告.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{lang.announcement}}  </p>
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
                <strong>标题:</strong>
                {{content.anouncements.title}}
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>落款:</strong>
                {{content.anouncements.signName}}
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>日期:</strong>
                {{TimeViewYMD(content.anouncements.created_at)}}
              </p>
            </div>
            <div>
              <v-btn
                tile
                color="success"
                outlined
                class="ma-1 ml-0"
                @click="showDetail(content)"
              >
                <v-icon left>
                  mdi-eye
                </v-icon>
                {{lang.viewDetail}}
              </v-btn>
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
        this.$router.push({name:'details.anouncement'});
      }
    }
}
</script>

<style>

</style>