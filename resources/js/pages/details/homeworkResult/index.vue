<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
      <v-container class="pt-0 px-0 h-100 bg-white pt-12">
        <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
          <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
            mdi-chevron-left
          </v-icon>
          <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.homework}}</p>
        </v-row>
        <div class="cus-divider-light-gray-height"></div>
        <v-row class="ma-0">
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
          <v-col cols="12" v-if="checkIfAttachExist(homeworkData.content)">
            <AttachItemViewer :items="homeworkData.content" />
          </v-col>
        </v-row>
        <div>
            <router-view :contentData="contentData"></router-view>
        </div>
      </v-container>
    </v-container>
    <v-container v-else>
        <v-col cols="12" class="d-flex align-center">
            <a @click="$router.go(-1)" class="float-left">
                <v-icon size="70">
                    mdi-chevron-left
                </v-icon>
            </a>
            <v-avatar class="ma-3 school-card-avatar" tile >
                <v-img :src="`${baseUrl}/asset/img/newIcon/作业.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
                <p class="font-weight-black fs-15 mb-3"> {{lang.homework}}  </p>
                <div class="d-flex align-center">
                    <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                    <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
                    <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                    <p class="mb-0">{{contentData.users.name}}</p>
                </div>
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
            <router-view :contentData="contentData"></router-view>
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
        this.homeworkData = this.contentData.homework_result.homework

    }

}
</script>

<style>

</style>