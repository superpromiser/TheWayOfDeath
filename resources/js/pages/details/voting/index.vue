<template>
    <v-container class="pa-0">
        <div class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)" class="float-left">
                        <v-icon size="70">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.voting}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        dark
                        color="#49d29e"
                        class="mr-8"
                        tile
                        @click="answerUsers"
                    >
                        已答{{answerDataList.length > 0 ? answerDataList.length : ''}}
                        <v-icon right>
                            mdi-chevron-right
                        </v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </div>
        <div v-if="answerUserShow == false">
            <v-row class="ma-0 px-5 px-md-10 mt-5">
                <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                        <!-- {{index + 1}}.   -->
                        <v-chip class="ma-2" color="success" outlined >
                            <strong v-if="contentData.votings.maxVote>1">多选</strong>
                            <strong v-else>单选</strong>
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
                        :dark="!alreadyAnswer"
                        color="#7879ff"
                        tile
                        :loading="isSubmit"
                        :disabled="alreadyAnswer"
                        @click="submit"
                        class="mr-5"
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
                if(val.name == 'details.voting' || val.name == 'details.classVoting'){
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
                return this.$snackbar.showMessage({content: '您已经回答了该帖子', color: 'error'})
            }
            if(this.contentData.votings.maxVote > 1){
                let index = this.answerData.indexOf(selIndex)
                if(index > -1){
                    this.answerData.splice(index,1)
                }else{
                    if(this.answerData.length >= this.contentData.votings.maxVote){
                        return this.$snackbar.showMessage({content: '无法再选择', color: 'error'})
                    }
                    this.answerData.push(selIndex)
                }
            }else{
                console.log(selIndex)
                console.log(this.answerData)
                if(this.answerData.length == 0){
                    this.answerData.push(selIndex)
                }else{
                    this.$set(this.answerData,0,selIndex)
                }
            }
        },

        async submit(){
            //console.log(this.answerData)
            if(this.answerData.length == 0){
                return this.$snackbar.showMessage({content: '请回答所有问题', color: 'error'})
            }
            if(this.alreadyAnswer == true){
                return this.$snackbar.showMessage({content: '您已经回答了该帖子', color: 'error'})
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
                return this.$snackbar.showMessage({content: "请投票", color: 'error'})
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