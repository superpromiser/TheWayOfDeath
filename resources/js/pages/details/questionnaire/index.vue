<template>
    <v-container class="pa-0" v-if="$isMobile()">
      <v-container class="pt-0 px-0 h-100 bg-white">
        <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
          <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
            mdi-chevron-left
          </v-icon>
          <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.questionnaire}}</p>
          <v-btn @click="answerUsers" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
            已答{{answerDataList.length > 0 ? answerDataList.length : ''}}
            <v-icon right>
              mdi-chevron-right
            </v-icon>
          </v-btn>
        </v-row>
        <div class="cus-divider-light-gray-height"></div>
        </v-container>
        <!----title---->
        <div v-if="answerUserShow == false">
          <v-row class="ma-0 px-5 px-md-10 mt-5">
              <v-col cols="12" class="d-flex justify-center align-center">
                  <h2>{{contentData.questionnaires.title}}</h2>
              </v-col>
              <v-col cols="12">
                  <p>{{contentData.questionnaires.desc}}</p>
              </v-col>
          </v-row>
          <!----questionnaires---->
          <v-row class="ma-0 px-5 px-md-10">
              <v-col cols="12" v-for="(content, index) in contentData.questionnaires.content" :key="index">
                  <!--  single Datas  -->
                  <v-row v-if="content.type == 'single'">
                    <v-col cols="12" class="hover-cursor-point">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined >
                          <strong>单选题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.singleContentDataArr[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.singleContentDataArr[0])">
                      <AttachItemViewer :items="content.singleContentDataArr[0]" />
                    </v-col>
                    <v-col class="pl-6 hover-cursor-point" cols="12" v-for="(singleData, singleDataIndex) in content.singleContentDataArr" :key="`${index}_${singleDataIndex}`" v-if="singleDataIndex !== 0">
                      <div class="d-flex align-center cursor-pointer" @click="singleAnswer(`${index}_${singleDataIndex}`,index,content.type)" :class="{active: answerData.indexOf(`${index}_${singleDataIndex}`) > -1}"> 
                        <v-chip
                          class="mr-2"
                          color="success"
                          outlined
                        >
                          <strong>{{alphabet[singleDataIndex-1]}}</strong>
                        </v-chip>
                        <p class="mb-0 text-wrap"> {{singleData.text}}</p>
                      </div>
                      <AttachItemViewer :items="singleData" v-if="checkIfAttachExist(singleData)" />
                    </v-col>
                  </v-row>
                  <!--  multi Datas  -->
                  <v-row v-if="content.type == 'multi'">
                    <v-col cols="12" class="hover-cursor-point">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined >
                          <strong>多选题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.multiContentDataArr[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.multiContentDataArr[0])">
                      <AttachItemViewer :items="content.multiContentDataArr[0]" />
                    </v-col>
                    <v-col class="pl-6 hover-cursor-point" cols="12" v-for="(multiData, multiDataIndex) in content.multiContentDataArr" :key="`${index}_${multiDataIndex}`" v-if="multiDataIndex !== 0">
                      <div class="d-flex align-center cursor-pointer" @click="multiAnswer(`${index}_${multiDataIndex}`,index,content.type)"  :class="{active: answerData[index].indexOf(`${index}_${multiDataIndex}`) > -1}" v-if="alreadyAnswer == true"> 
                        <v-chip
                          class="mr-2"
                          color="success"
                          outlined
                        >
                          <strong>{{alphabet[multiDataIndex-1]}}</strong>
                        </v-chip>
                        <p class="mb-0 text-wrap"> {{multiData.text}}</p>
                      </div>
                      <div class="d-flex align-center cursor-pointer" @click="multiAnswer(`${index}_${multiDataIndex}`,index,content.type)"  :class="{active: multiAnswerArr.indexOf(`${index}_${multiDataIndex}`) > -1}" v-else>
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
                  <!--  qa Datas  -->
                  <v-row v-if="content.type == 'qa'">
                    <v-col cols="12" class="hover-cursor-point">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined >
                          <strong>问答题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.qaContentDataArr[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.qaContentDataArr[0])">
                      <AttachItemViewer :items="content.qaContentDataArr[0]" />
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                        clearable
                        solo
                        clear-icon="mdi-close-circle"
                        label=""
                        value=""
                        v-model="answerData[index]"
                        hide-details
                      ></v-textarea>
                    </v-col>
                  </v-row>
                  <!--  statistics Datas  -->
                  <!-- <v-row v-if="content.type == 'stat'">
                    <v-col cols="12">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined >
                          <strong>统计题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.statDataArr[0].contentData[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.statDataArr[0].contentData[0])">
                      <AttachItemViewer :items="content.statDataArr[0].contentData[0]" />
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                        clearable
                        solo
                        clear-icon="mdi-close-circle"
                        :label="`${content.statDataArr[0].sValue}~${content.statDataArr[0].eValue}`"
                        value=""
                        v-model.number="answerData.statAnswer"
                        hide-details
                      ></v-textarea>
                    </v-col>
                  </v-row> -->
                  <!--  score Datas  -->
                  <v-row v-if="content.type == 'score'">
                    <v-col cols="12">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined >
                          <strong>评分题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.scoringDataArr[0].contentData[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.scoringDataArr[0].contentData[0])">
                      <AttachItemViewer :items="content.scoringDataArr[0].contentData[0]" />
                    </v-col>
                    <v-col cols="12">
                      <div v-for="(minute,i) in parseInt(content.scoringDataArr[0].maxMin)" :key="i" class="op-score" :class="{selMinute: minute == answerData[index]}" @click="selScoring(minute,index)">
                          {{minute}}
                      </div>
                    </v-col>
                  </v-row>
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
    <v-container class="pa-0" v-else>
        <v-row class="px-10 z-index-2 banner-custom">
          <v-col cols="6" md="4" class="d-flex align-center position-relative">
            <a @click="$router.go(-1)" class="float-left">
              <v-icon size="70" class=" left-24p">
                  mdi-chevron-left
              </v-icon>
            </a>
          </v-col>
          <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
            <h2>{{lang.questionnaire}}</h2>
          </v-col>
          <v-col cols="12" md="4" class="d-flex align-center justify-end">
            <v-btn
              dark
              color="#7879ff"
              class="mr-8"
              tile
              @click="answerUsers"
              v-if="answerUserShow == false"
            >
              已答 {{answerDataList.length}}
              <v-icon right>
                  mdi-chevron-right
              </v-icon>
            </v-btn>
          </v-col>
        </v-row>
        <!----title---->
        <v-col cols="12" class="d-flex align-center hover-cursor-point mt-5 px-10">
            <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="primary" size="60" class="ma-5">
                <span class="white--text headline">{{contentData.users.name[0]}}</span>
            </v-avatar>
            <v-avatar v-else
              class="ma-5"
              size="60"
            >
              <v-img :src="contentData.users.avatar"></v-img>
            </v-avatar>
            <div>
              <p class="font-weight-black fs-15 mb-3"> {{lang.questionnaire}}  </p>
              <div class="d-flex align-center">
                <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
                <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                <p class="mb-0">{{contentData.users.name}}</p>
              </div>
            </div>
            <div class="ml-auto mr-5">
              <v-menu offset-y >
                <template v-slot:activator="{ attrs, on }">
                  <v-btn icon color="primary" v-bind="attrs" v-on="on" >
                    <v-icon size="30">mdi-chevron-down </v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item link >
                    <v-list-item-title class="px-2" @click="fixTop(contentData)">{{lang.toTop}}</v-list-item-title>
                  </v-list-item>
                  <v-list-item link >
                    <v-list-item-title class="px-2" @click="postRemove(contentData)">{{lang.remove}}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>
        </v-col>
        <div v-if="answerUserShow == false" class="px-10">
          <v-row class="ma-0 px-10 mt-5">
              <v-col cols="12" class="d-flex justify-center align-center">
                  <h2>{{contentData.questionnaires.title}}</h2>
              </v-col>
              <v-col cols="12">
                  <p>{{contentData.questionnaires.desc}}</p>
              </v-col>
          </v-row>
          <!----questionnaires---->
          <v-row class="ma-0 px-10">
              <v-col cols="12" v-for="(content, index) in contentData.questionnaires.content" :key="index">
                  <!--  single Datas  -->
                  <v-row v-if="content.type == 'single'">
                    <v-col cols="12" class="hover-cursor-point">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined >
                          <strong>单选题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.singleContentDataArr[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.singleContentDataArr[0])">
                      <AttachItemViewer :items="content.singleContentDataArr[0]" />
                    </v-col>
                    <v-col class="pl-6 hover-cursor-point" cols="12" v-for="(singleData, singleDataIndex) in content.singleContentDataArr" :key="`${index}_${singleDataIndex}`" v-if="singleDataIndex !== 0">
                      <div class="d-flex align-center cursor-pointer" @click="singleAnswer(`${index}_${singleDataIndex}`,index,content.type)" :class="{active: answerData.indexOf(`${index}_${singleDataIndex}`) > -1}"> 
                        <v-chip
                          class="mr-2"
                          color="success"
                          outlined
                        >
                          <strong>{{alphabet[singleDataIndex-1]}}</strong>
                        </v-chip>
                        <p class="mb-0 text-wrap"> {{singleData.text}}</p>
                      </div>
                      <AttachItemViewer :items="singleData" v-if="checkIfAttachExist(singleData)" />
                    </v-col>
                  </v-row>
                  <!--  multi Datas  -->
                  <v-row v-if="content.type == 'multi'">
                    <v-col cols="12" class="hover-cursor-point">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined >
                          <strong>多选题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.multiContentDataArr[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.multiContentDataArr[0])">
                      <AttachItemViewer :items="content.multiContentDataArr[0]" />
                    </v-col>
                    <v-col class="pl-6 hover-cursor-point" cols="12" v-for="(multiData, multiDataIndex) in content.multiContentDataArr" :key="`${index}_${multiDataIndex}`" v-if="multiDataIndex !== 0">
                      <div class="d-flex align-center cursor-pointer" @click="multiAnswer(`${index}_${multiDataIndex}`,index,content.type)"  :class="{active: answerData[index].indexOf(`${index}_${multiDataIndex}`) > -1}" v-if="alreadyAnswer == true"> 
                        <v-chip
                          class="mr-2"
                          color="success"
                          outlined
                        >
                          <strong>{{alphabet[multiDataIndex-1]}}</strong>
                        </v-chip>
                        <p class="mb-0 text-wrap"> {{multiData.text}}</p>
                      </div>
                      <div class="d-flex align-center cursor-pointer" @click="multiAnswer(`${index}_${multiDataIndex}`,index,content.type)"  :class="{active: multiAnswerArr.indexOf(`${index}_${multiDataIndex}`) > -1}" v-else>
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
                  <!--  qa Datas  -->
                  <v-row v-if="content.type == 'qa'">
                    <v-col cols="12" class="hover-cursor-point">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined >
                          <strong>问答题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.qaContentDataArr[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.qaContentDataArr[0])">
                      <AttachItemViewer :items="content.qaContentDataArr[0]" />
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                        clearable
                        solo
                        clear-icon="mdi-close-circle"
                        label=""
                        value=""
                        v-model="answerData[index]"
                        hide-details
                      ></v-textarea>
                    </v-col>
                  </v-row>
                  <v-row v-if="content.type == 'score'">
                    <v-col cols="12">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined >
                          <strong>评分题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.scoringDataArr[0].contentData[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.scoringDataArr[0].contentData[0])">
                      <AttachItemViewer :items="content.scoringDataArr[0].contentData[0]" />
                    </v-col>
                    <v-col cols="12">
                      <div v-for="(minute,i) in parseInt(content.scoringDataArr[0].maxMin)" :key="i" class="op-score" :class="{selMinute: minute == answerData[index]}" @click="selScoring(minute,index)">
                          {{minute}}
                      </div>
                    </v-col>
                  </v-row>
              </v-col>
          </v-row>
          <v-row class="d-flex justify-end px-10 mx-0 my-10">
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
          <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
          <CommentView></CommentView>
        </div>
        <div v-else>
          <router-view :answerUsers="answerDataList"></router-view>
        </div>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
import {createAnswerQuestionnaire,getAnswerQuestionnaire} from '~/api/postAnswer';
import FooterPost from '~/components/contents/footerPost'
import CommentView from '~/pages/school/posts/comments/commentView';
export default {
    components:{
        AttachItemViewer,
        FooterPost,
        CommentView
    },

    data:()=>({
        baseUrl:window.Laravel.base_url,
        lang,
        alphabet:['A','B','C','D','E','F','G','H','J','K','L','M','N',
                'O','P','Q','R','S','T','U','V','W','X','Y','Z' ],
        // answerData:{
        //   singleAnswer:[],
        //   multiAnswer:[],
        //   questionAnswer:[],
        //   statAnswer:[],
        //   scoringAnswer:[],
        //   postId:null
        // },
        answerData:[],
        checkCnt:0,
        multiAnswerArr:[],
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
          if(val.name == 'details.quesionnaire' || val.name == 'details.classQuesionnaire'){
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
        this.contentData.questionnaires.content = JSON.parse(this.contentData.questionnaires.content);
        await getAnswerQuestionnaire({postId:this.contentData.id}).then(res=>{
          this.answerDataList = res.data;
          this.answerDataList.map(answerData=>{
            if(answerData.userId == this.user.id){
              this.answerData = JSON.parse(answerData.answerData)
              // console.log(this.answerData)
              this.alreadyAnswer = true
            }
          })
        }).catch(err=>{
          console.log(err.response)
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
        answerUsers(){
          //console.log('answerUsers')
          console.log(this.answerDataList)
          if(this.answerDataList.length == 0){
            return this.$snackbar.showMessage({content: this.lang.noData, color: 'error'})
          }
          this.answerUserShow = true
          this.$router.push({name:'details.questionnaireUsers'})
        },
        singleAnswer(key,index,type){
          if(this.alreadyAnswer == true){
            return this.$snackbar.showMessage({content: '您已经回答了该帖子', color: 'error'})
          }
          this.$set(this.answerData,index,key)
        },
        multiAnswer(key,index,type){
          if(this.alreadyAnswer == true){
            return this.$snackbar.showMessage({content: '您已经回答了该帖子', color: 'error'})
          }
          let idx = this.multiAnswerArr.indexOf(key)
          if(idx > -1){
            this.multiAnswerArr.splice(idx,1)
          }else{
            this.multiAnswerArr.push(key)
          }
          this.$set(this.answerData,index,this.multiAnswerArr)
          
        },
        selScoring(minute,index){
          if(this.alreadyAnswer == true){
            return this.$snackbar.showMessage({content: '您已经回答了该帖子', color: 'error'})
          }
          // this.answerData[index] = minute
          this.$set(this.answerData,index,minute)
        },
        async submit(){
          if(this.alreadyAnswer == true){
            return this.$snackbar.showMessage({content: '您已经回答了该帖子', color: 'error'})
          }
          
          this.answerData.map(answer=>{
            this.checkCnt ++;
          })
          if(this.checkCnt != this.contentData.questionnaires.content.length){
            return this.$snackbar.showMessage({content: '请回答所有问题', color: 'error'})
          }
          this.isSubmit = true;
          await createAnswerQuestionnaire({answerData:this.answerData,schoolId:this.currentpath.params.schoolId,lessonId:this.currentpath.params.lessonId,postId:this.contentData.id}).then(res=>{
            //console.log(res)
            if(this.currentpath.params.lessonId){
              this.$router.push({name:'classSpace.news'})
            }else{
              this.$router.push({name:'schoolSpace.news'})
            }
            this.isSubmit = false;
          }).catch(err=>{
            this.isSubmit = false;
            console.log(err.response)
          })

        },
        updateFooterInfo(){
          
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