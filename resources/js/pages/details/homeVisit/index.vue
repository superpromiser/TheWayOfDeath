<template>
    <v-container>
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class="left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.homeVisit}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <!-- <v-btn
                        text
                        color="primary"
                        @click="templateList"
                    >
                        可用模板 0， 草稿 0
                    </v-btn>
                    <v-btn
                        dark
                        tile
                        color="#49d29e"
                        class="mx-2"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>
                    <v-btn
                        dark
                        tile
                        color="#F19861"
                        :loading="isDraft"
                        @click="saveDraft"
                    >
                        {{lang.saveDraft}}
                    </v-btn> -->
                </v-col>
            </v-row>
        </v-container>
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