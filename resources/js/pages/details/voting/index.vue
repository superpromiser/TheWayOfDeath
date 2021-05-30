<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()" >
        <v-container class="pt-0 px-0 h-100 bg-white pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.voting}}</p>
                <div>
                    <v-btn color="#7879ff" :dark="!alreadyAnswer" :disabled="alreadyAnswer" :loading="isSubmit" @click="submit" class="position-absolute put-align-center" style="right: 20%; top:50%"> {{lang.submit}} </v-btn>
                    <v-btn v-if="answerUserShow == false" @click="answerUsers" dark color="#F19861" class="position-absolute put-align-center" style="right: 0px; top:50%">
                        已答{{answerDataList.length > 0 ? answerDataList.length : ''}}
                    </v-btn>
                </div>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex">
                    <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="#7879ff" size="48">
                        <span class="white--text headline">{{contentData.users.name[0]}}</span>
                    </v-avatar>
                    <v-avatar v-else
                        size="48"
                    >
                        <v-img :src="contentData.users.avatar"></v-img>
                    </v-avatar>
                    <div class="ml-2 d-flex flex-column">
                        <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.voting}}  </p>
                        <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(contentData.created_at)}}  </span> {{contentData.users.name}}</p>
                    </div>
                </v-col>
            </v-row>
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
                            <p class="mb-0 text-wrap width-100-without-68-px"> {{multiData.text}}</p>
                        </div>
                        <AttachItemViewer :items="multiData" v-if="checkIfAttachExist(multiData)" />
                    </v-col>
                </v-row>
                <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
                <CommentView class="pb-10"></CommentView>
                <!-- <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-white pa-3 ">
                    <v-col cols="12" class="d-flex justify-space-between align-center pa-0">
                        <v-btn color="#7879ff" block :dark="!alreadyAnswer" large :disabled="alreadyAnswer" :loading="isSubmit" @click="submit"> {{lang.submit}} </v-btn>
                    </v-col>
                </v-row> -->
            </div>
            <div v-else>
                <router-view :answerUsers="answerDataList"></router-view>
            </div>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
        <v-container class="z-index-2 banner-custom">
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
                        color="#7879ff"
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
        </v-container>
        <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="#7879ff"
            ></v-progress-circular>
        </div>
        <div v-else>
            <div v-if="answerUserShow == false" class=" px-5 mt-5">
                <v-col cols="12" class="d-flex align-center hover-cursor-point">
                    <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="#7879ff" size="60" class="ma-5">
                        <span class="white--text headline">{{contentData.users.name[0]}}</span>
                    </v-avatar>
                    <v-avatar v-else
                    class="ma-5"
                    size="60"
                    >
                    <v-img :src="contentData.users.avatar"></v-img>
                    </v-avatar>
                    <div>
                    <p class="font-weight-black fs-15 mb-3"> {{lang.voting}}  </p>
                    <div class="d-flex align-center">
                        <v-icon medium color="#7879ff" class="mr-2">mdi-clock-outline </v-icon>
                        <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
                        <v-icon medium color="#7879ff" class="mr-2">mdi-account </v-icon>
                        <p class="mb-0">{{contentData.users.name}}</p>
                    </div>
                    </div>
                    <div class="ml-auto mr-5">
                    <v-menu offset-y v-if="user.roleId < 3 || contentData.users.id == user.id">
                        <template v-slot:activator="{ attrs, on }">
                        <v-btn icon color="#7879ff" v-bind="attrs" v-on="on" >
                            <v-icon size="30">mdi-chevron-down </v-icon>
                        </v-btn>
                        </template>
                        <v-list>
                            <v-list-item link v-if="user.roleId < 3" >
                                <v-list-item-title class="px-2" @click="fixTop(contentData)" v-if="contentData.fixTop == null">{{lang.toTop}}</v-list-item-title>
                                <v-list-item-title class="px-2" @click="relaseTop(contentData.id)" v-else>{{lang.toRelase}}</v-list-item-title>
                            </v-list-item>
                            <v-list-item link >
                                <v-list-item-title class="px-2" @click="postRemove(contentData)">{{lang.remove}}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    </div>
                </v-col>
                <v-row class="ma-0 mt-5">
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
                        <div class="d-flex align-center hover-cursor-point" @click="multiAnswer(multiDataIndex)" :class="{active: answerData.indexOf(multiDataIndex) > -1}"> 
                            <v-chip
                            class="mr-2"
                            :color="answerData.indexOf(multiDataIndex) > -1 ? '#49d29e': '#999999'"
                            :outlined="!(answerData.indexOf(multiDataIndex) > -1)"
                            :dark="answerData.indexOf(multiDataIndex) > -1"
                            >
                            <strong>{{alphabet[multiDataIndex-1]}}</strong>
                            </v-chip>
                            <p class="mb-0 text-wrap width-100-without-68-px"> {{multiData.text}}</p>
                        </div>
                        <AttachItemViewer :items="multiData" v-if="checkIfAttachExist(multiData)" />
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-end mx-0 my-10 px-10">
                    <v-btn
                        :dark="!alreadyAnswer"
                        color="#7879ff"
                        tile
                        :loading="isSubmit"
                        :disabled="alreadyAnswer"
                        @click="submit"
                    > 
                        {{lang.submit}}
                    </v-btn>
                </v-row>
                <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
                <CommentView></CommentView>
            </div>
            <div v-else>
                <router-view :answerUsers="answerDataList"></router-view>
            </div>
        </div>
    </v-container>
</template>

<script>
import EventBus from '~/helper/event-bus';
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
import {createAnswerVoting,getAnswerVoting} from '~/api/postAnswer'
import FooterPost from '~/components/contents/footerPost'
import CommentView from '~/pages/school/posts/comments/commentView';
export default {
    components:{
        AttachItemViewer,
        FooterPost,
        CommentView
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
        isLoading:false
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
        this.answerData.postId = this.contentData.id
        this.content = JSON.parse(this.contentData.votings.content)
        this.isLoading = true
        await getAnswerVoting({postId:this.answerData.postId}).then(res=>{
            this.answerDataList = res.data
            this.answerDataList.map(answerData=>{
                if(answerData.userId == this.user.id){
                    this.answerData = JSON.parse(answerData.answerData)
                    this.alreadyAnswer = true
                }
            })
            this.isLoading = false
        }).catch(err=>{
            console.log(err.console)
            this.isLoading = false
        })
        console.log('=======',this.contentData)
        console.log('------',this.answerDataList)
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
            if(this.contentData.votings.deadline < this.TimeView(Date.now())){
                return this.$snackbar.showMessage({content: this.lang.deadlinePassed, color: 'error'})
            }
            this.isSubmit = true
            await createAnswerVoting({answer:this.answerData,postId:this.contentData.id}).then(res=>{
                this.isSubmit = false
                if(this.$isMobile()){
                    this.$router.push({name: "home"})
                }
                else{
                    if(this.currentpath.params.lessonId){
                        this.$router.push({name:'classSpace.news'})
                    }else{
                        this.$router.push({name:'schoolSpace.news'})
                    }
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
        },
        updateFooterInfo(){

        }
    }
}
</script>

<style>
  .active{
    /* background-color:#2d8cf0; */
    /* cursor: pointer; */
    /* color:white */
  }
</style>