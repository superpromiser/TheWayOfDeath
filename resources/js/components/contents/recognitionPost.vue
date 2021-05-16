<template>
  <v-container v-if="$isMobile()">
    <v-row>
      <v-col cols="12" class="d-flex" @click="showDetail(content)">
        <v-avatar>
          <v-img :src="`${baseUrl}/asset/img/icon/recognition.png`" alt="postItem" ></v-img>
        </v-avatar>
        <div class="ml-2 d-flex flex-column">
          <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.recognition}}  </p>
          <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(content.created_at)}} 转发</span> {{content.users.name}}</p>
        </div>
      </v-col>
    </v-row>
  </v-container>
  <v-container v-else>
      <v-col cols="12" class="d-flex align-center hover-cursor-point" @click="showDetail(content)">
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
            <p class="font-weight-black fs-15 mb-3"> {{lang.recognition}}  </p>
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
        <v-chip v-for="student in students" :key="student.id" class="ml-2 hover-cursor-point">
          @{{student.name}}
        </v-chip>
      </v-col>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {createReadCnt} from '~/api/alarm'
import {mapGetters} from 'vuex'
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
        students:[],
    }),
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
        
      }
    },
    created(){
      this.students = JSON.parse(this.content.recognitions.students)
    },
}
</script>

<style>

</style>