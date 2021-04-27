<template>
    <v-container>
        <v-col cols="12" class="d-flex align-center hover-cursor-point" @click="showDetail">
            <v-avatar v-if="content.users.name !== '' && content.users.avatar == '/'" color="primary" size="60" class="ma-5">
                <span class="white--text headline">{{content.users.name[0]}}</span>
            </v-avatar>
            <v-avatar v-else
              size="48"
            >
              <v-img :src="content.users.avatar"></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{homeworkData.homeworkType}}  </p>
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
              <strong>作业科目:</strong>
              {{homeworkData.subjectName}}
            </p>
          </div>
          <div class="d-flex align-center">
            <p class="text-wrap mb-0">
              <strong>作业类型:</strong>
              {{homeworkData.homeworkType}}
            </p>
          </div>
          <div class="d-flex align-center">
            <p class="text-wrap mb-0">
              <strong>作业内容:</strong>
              {{homeworkData.content.text}}
            </p>
          </div>
        </v-col>
        <v-col cols="12" class="pl-10 pt-0">
          <v-row>
            <v-col cols="12" v-if="checkIfAttachExist(homeworkData.content)">
              <AttachItemViewer :items="homeworkData.content" />
            </v-col>
          </v-row>
        </v-col>
    </v-container>
</template>

<script>
import AttachItemViewer from '~/components/attachItemViewer';
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex'
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
        homeworkData: null,
    }),
    computed:{
      currentPath(){
        return this.$route
      },
      ...mapGetters({
          user:'auth/user'
      })
    },
    created(){
        console.log(this.content)
        if(this.content){
            this.homeworkData = this.content.homework
            this.homeworkData.content = JSON.parse(this.homeworkData.content)
        }
        console.log(this.user)
    },
    methods:{
      showDetail(){
        this.$store.dispatch('content/storePostDetail',this.content)
        if(this.currentPath.params.lessonId){
          if(this.content.homework.homeworkType == "常规作业"){
            if(this.user.roleId == 3){
              this.$router.push({name:'details.homeworkofflineTeacher'});    
            }else if(this.user.roleId == 5){
              this.$router.push({name:'details.homeworkofflineStudent'});    
            }else{
              this.$router.push({name:'details.classHomework'});    
            }
          }else if(this.content.homework.homeworkType == '在线作业'){
            if(this.user.roleId == 3){
              this.$router.push({name:'details.homeworkonlineTeacher'});    
            }else if(this.user.roleId == 5){
              this.$router.push({name:'details.homeworkonlineStudent'});    
            }else{
              this.$router.push({name:'details.classHomework'});    
            }
          }else if(this.content.homework.homeworkType == '在线测试'){
            if(this.user.roleId == 3){
              this.$router.push({name:'details.homeworktestTeacher'});    
            }else if(this.user.roleId == 5){
              this.$router.push({name:'details.homeworktestTeacher'});    
            }else{
              this.$router.push({name:'details.classHomework'});    
            }
          }else{
            this.$router.push({name:'details.classHomework'});
          }
        }else{
          this.$router.push({name:'details.homework'});
        }
      }
    }
}
</script>

<style>

</style>