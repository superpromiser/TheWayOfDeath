<template>
    <v-container>
        <v-col cols="12" class="d-flex align-cente">
            <a @click="$router.go(-1)" class="float-left">
                <v-icon size="70">
                    mdi-chevron-left
                </v-icon>
            </a>
            <v-avatar class="ma-3 school-card-avatar" tile >
                <v-img :src="`${baseUrl}/asset/img/newIcon/作业.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
            <p class="font-weight-black fs-15 mb-3"> {{lang.notification}}  </p>
            <div class="d-flex align-center">
                <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
                <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                <p class="mb-0">{{contentData.users.name}}</p>
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
                    <v-list-item-title class="px-2" @click="postRemove(contentData)">{{lang.remove}}</v-list-item-title>
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
        <div>
            <router-view></router-view>
        </div>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
import AttachItemViewer from '~/components/attachItemViewer';
export default {
    components:{
        AttachItemViewer,
    },
    data:()=>({
        baseUrl:window.Laravel.base_url,
        lang,
        homeworkData:null
    }),
    computed:{
         currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail',
            user:'auth/user'
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
        console.log(this.contentData)
        this.homeworkData = this.contentData.homework

    }

}
</script>

<style>

</style>