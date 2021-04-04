<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <a @click="$router.go(-1)" class="float-left">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/投票.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.voting}}</h2>
            </div>
            <template v-slot:actions>
                <v-btn
                    dark
                    color="green lighten-1"
                    class="mr-8"
                    tile
                    @click="answerUsers"
                >
                    已答{{answerDataList.length > 0 ? answerDataList.length : ''}}
                    <v-icon right>
                        mdi-chevron-right
                    </v-icon>
                </v-btn>
            </template>
        </v-banner>
        <!----title---->
        <!-- <v-row class="ma-0 px-5 px-md-10">
            <v-col cols="12" class="d-flex justify-center align-center">
                <h2>{{contentData.voting.title}}</h2>
            </v-col>
            <v-col cols="12">
                <p>{{contentData.questionnaires.desc}}</p>
            </v-col>
        </v-row> -->
        <div v-if="answerUserShow == false">
            <v-row>
                <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                        <!-- {{index + 1}}.   -->
                        <v-chip class="ma-2" color="success" outlined >
                        <strong>多选题</strong>
                        </v-chip>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ content[0].text }}</p>
                </v-col>
                <v-col v-if="checkIfAttachExist(content[0])">
                    <AttachItemViewer :items="content[0]" />
                </v-col>
                <v-col class="pl-6" cols="12" v-for="(multiData, multiDataIndex) in content" :key="multiDataIndex" v-if="multiDataIndex !== 0">
                    <div class="d-flex align-center cursor-pointer" @click="multiAnswer(multiDataIndex)" :class="{active: answerData.indexOf(multiDataIndex) > -1}"> 
                        <v-chip
                        class="mr-2"
                        color="success"
                        outlined
                        >
                        <strong>{{alphabet[multiDataIndex-1]}}</strong>
                        </v-chip>
                        <p class="mb-0 text-wrap"> {{multiData.text}}</p>
                    </div>
                    <AttachItemViewer :items="multiData" v-if="checkIfAttachExist(multiData)" />
                </v-col>
            </v-row>
            <v-row class="d-flex justify-end px-md-13 px-5 mx-0 my-10">
                <v-btn
                        dark
                        color="deep-purple accent-3"
                        tile
                        :loading="isSubmit"
                        :disabled="alreadyAnswer"
                        @click="submit"
                    > 
                        {{lang.submit}}
                </v-btn>
            </v-row>
        </div>
        <div v-else>
            <router-view :answerUsers="answerDataList"></router-view>
        </div>
    </v-container>
</template>

<script>
import EventBus from '~/helper/event-bus';
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
import {createAnswerVoting,getAnswerVoting} from '~/api/postAnswer'
export default {
    components:{
        AttachItemViewer,
    },
    data:()=>({
        // contentData:null
        baseUrl:window.Laravel.base_url,
        lang,
        content:null,
        answerData:[],
        alphabet:['A','B','C','D','E','F','G','H','J','K','L','M','N',
                'O','P','Q','R','S','T','U','V','W','X','Y','Z' ],
        answerDataList:[],
        isSubmit:false,
        alreadyAnswer:false,
        answerUserShow:false,        
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

    watch:{
        currentpath:{
            handler(val){
                if(val.name == 'details.voting'){
                    this.answerUserShow = false
                }
            },  
            deep:true
        }
    },
    async created(){
        if(this.contentData == null){
          if(this.currentpath.params.lessonId){
            this.$router.push({name:'classSpace.news'})
          }else{
            this.$router.push({name:'schoolSpace.news'})
          }
        }
        console.log(this.contentData)
        this.answerData.postId = this.contentData.id
        this.content = JSON.parse(this.contentData.votings.content)
        // //console.log('detail index')
        await getAnswerVoting({postId:this.answerData.postId}).then(res=>{
            this.answerDataList = res.data
            this.answerDataList.map(answerData=>{
                if(answerData.userId == this.user.id){
                    console.log("answerData",answerData)
                    this.answerData = JSON.parse(answerData.answerData)
                    this.alreadyAnswer = true
                }
            })
        }).catch(err=>{
            //console.log(err.console)
        })
    },
    methods:{
        checkIfAttachExist(data){
            let count = 0;
            count = count + data.imgUrl.length + data.videoUrl.length + data.otherUrl.length;
            if( count == 0 ) {
                return false;
            }
            else{
                return true;
            }
        },
        multiAnswer(selIndex){
            if(this.alreadyAnswer == true){
                alert('您已经回答了该帖子');
                return;
            }
            let index = this.answerData.indexOf(selIndex)
            if(index > -1){
                this.answerData.splice(index,1)
            }else{
                if(this.answerData.length >= this.contentData.votings.maxVote){
                    alert('无法再选择')
                    return
                }
                this.answerData.push(selIndex)
            }
        },

        async submit(){
            //console.log(this.answerData)
            if(this.answerData.length == 0){
                alert('请回答所有问题');
                return
            }
            if(this.alreadyAnswer == true){
                alert('您已经回答了该帖子');
                return;
            }
            this.isSubmit = true
            await createAnswerVoting({answer:this.answerData,postId:this.contentData.id}).then(res=>{
                this.isSubmit = false
                if(this.currentpath.params.lessonId){
                    this.$router.push({name:'classSpace.news'})
                }else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                this.isSubmit = false
                console.log(err.response)
            })
        },

        answerUsers(){
            if(this.answerDataList.length == 0){
                alert(lang.noData)
                return
            }
            this.answerUserShow = true
            this.$router.push({name:'details.votingUsers'});
            //console.log('answerUsers')
        }
    }
}
</script>

<style>
  .active{
    background-color:#2d8cf0;
    cursor: pointer;
    color:white
  }
</style>