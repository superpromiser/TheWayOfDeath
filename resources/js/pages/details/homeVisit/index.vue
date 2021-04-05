<template>
    <v-container>
        <v-col cols="12" class="d-flex align-center">
            <a @click="$router.go(-1)" class="float-left">
                <v-icon size="70">
                    mdi-chevron-left
                </v-icon>
            </a>
            <v-avatar class="ma-3 school-card-avatar" tile >
              <v-img :src="`${baseUrl}/asset/img/icon/家访 拷贝.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{lang.homeVisit}}  </p>
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
        <v-col  cols="12" class="pl-10 pt-0">
            <v-banner>
                <span v-for="(name,idx) in studentInfo" :key="idx" class="ml-2">
                    <v-chip>{{name}}</v-chip>
                </span>
            </v-banner>
        </v-col>
        <v-col  cols="12" class="pl-10 pt-0">
            <v-row class="ma-0 " v-for="(item, i) in description" :key="i">
                <v-col class="px-5  hover-cursor-point" cols="12" v-for="(data, j) in item" :key="`${i}-${j}`">
                    <p class="textMain" v-if="j==0">{{i+1}}.{{data.title}}</p>
                    <p v-else @click="selAnswer(item,i,j,`${i}-${j}`)">
                        <span v-if="item[0].type == 'single'" :class="{active:answerData.indexOf(`${i}-${j}`) > -1}">{{data.title}}</span>
                        <span v-if="item[0].type == 'multi'" :class="{active:multiAnswerArr.indexOf(`${i}-${j}`) > -1}">{{data.title}}</span>
                    </p>
                </v-col>
            </v-row>
        </v-col>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
export default {
    components:{
        AttachItemViewer,
    },
    data:()=>({
        lang,
        baseUrl:window.Laravel.base_url,
        studentInfo:[],
        description:[],
        answerData:[],
        multiAnswerArr:[]
    }),

    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail'
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
        this.studentInfo = JSON.parse(this.contentData.home_visit.userInfo)
        console.log(this.studentInfo)
        this.description = this.contentData.home_visit.description
        console.log(this.description)
    },
    methods:{
        selAnswer(item,i,j,key){
            // console.log(item,i,j,key)
            if(item[0].type == 'single'){
                this.$set(this.answerData,i,key)
            }else{
                let idx = this.multiAnswerArr.indexOf(key)
                if(idx > -1){
                    this.multiAnswerArr.splice(idx,1)
                }else{
                    this.multiAnswerArr.push(key)
                }
                this.$set(this.answerData,i,this.multiAnswerArr)
            }
            console.log(this.answerData)
        }
    }
}
</script>

<style>

</style>