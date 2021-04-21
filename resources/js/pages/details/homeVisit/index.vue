<template>
    <v-container>
        <v-row class="justify-center align-center z-index-2 banner-custom ">
            <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
                mdi-chevron-left
            </v-icon>
            <h2 class="py-7">{{lang.homeVisit}}</h2>
        </v-row>
        <v-row class="pl-10 mt-5 ma-0">
            <v-col cols="12">
                <p class="text-wrap mb-0"><read-more more-str="全文" :text="contentDataDetail.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
            </v-col>
            <v-col cols="12" v-if="checkIfAttachExist(contentDataDetail)">
                <AttachItemViewer :items="contentDataDetail" />
            </v-col>
            <v-col cols="12">
                <v-chip v-for="(name,idx) in studentInfo" :key="idx" class="ml-2">@{{name}}</v-chip>
            </v-col>
            <v-col cols="12">
                <v-row class="ma-0 " v-for="(item, i) in description" :key="i">
                    <v-col class="px-5  hover-cursor-point" cols="12" v-for="(data, j) in item" :key="`${i}-${j}`">
                        <p v-if="j==0" class="textMain mb-0" >{{i+1}}.{{data.title}}</p>
                        <p v-else class="mb-0" @click="selAnswer(item,i,j,`${i}-${j}`)">
                            <span v-if="item[0].type == 'single'" :class="{active:answerData.indexOf(`${i}-${j}`) > -1}">{{data.title}}</span>
                            <span v-if="item[0].type == 'multi'" :class="{active:multiAnswerArr.indexOf(`${i}-${j}`) > -1}">{{data.title}}</span>
                        </p>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
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
        multiAnswerArr:[],
        contentDataDetail: {},
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
        this.contentDataDetail = this.contentData.home_visit.content;
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