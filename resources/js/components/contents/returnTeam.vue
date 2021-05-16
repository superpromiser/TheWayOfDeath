<template>
    <v-container>
        <v-col cols="12" class="d-flex align-center hover-cursor-point">
            <v-avatar v-if="content.users.name !== '' && content.users.avatar == '/'" color="primary" size="60" class="ma-5">
                <span class="white--text headline">{{content.users.name[0]}}</span>
            </v-avatar>
            <v-avatar v-else
              class="ma-5"
              size="60"
            >
              <v-img :src="content.users.avatar"></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> 归程队 </p>
              <div class="d-flex align-center">
                <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8">{{TimeView(content.created_at)}}</p>
                <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                <p class="mb-0">{{content.users.name}}</p>
              </div>
            </div>
            <div class="ml-auto" v-if="user.roleId < 3 || content.users.id == user.id">
              <v-menu offset-y >
                <template v-slot:activator="{ attrs, on }">
                  <v-btn icon color="primary" v-bind="attrs" v-on="on" >
                    <v-icon size="30">mdi-chevron-down </v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item link v-if="user.roleId < 3" >
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
            <div class="d-flex align-center">
                <p class="text-wrap mb-0">{{content.returnteam.member.length}}个已选择</p>
            </div>
            <div>
                <v-btn tile color="success" outlined class="ma-1 ml-0" @click="showDetail(content)" >
                    <v-icon left> mdi-eye </v-icon>
                    {{lang.viewDetail}}
                </v-btn>
            </div>
        </v-col>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {createReadCnt} from '~/api/alarm'
import {mapGetters} from 'vuex'
export default {
    props:{
        content: {
            type: Object,
            require: true,
        },
    },

    data:()=>({
        lang,
        baseUrl:window.Laravel.base_url,
        returnTeamData: null,
    }),

    created(){
      this.returnTeamData = this.content.returnteam;
    },
    computed:{
      currentPath(){
        return this.$route
      },
      ...mapGetters({
        user:'auth/user'
      })
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
        },
    }
}
</script>

<style>

</style>