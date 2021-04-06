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
                    <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.questionnaire}}</h2>
            </div>
            <template v-slot:actions>
                <v-btn
                    dark
                    color="#49d29e"
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
            </template>
        </v-banner>
        <!----title---->
        <div v-if="answerUserShow == false">
          <v-row class="ma-0 px-5 px-md-10">
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
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
import {createAnswerQuestionnaire,getAnswerQuestionnaire} from '~/api/postAnswer';

export default {
    components:{
        AttachItemViewer,
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
              console.log(this.answerData)
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
            alert(lang.noData)
            return
          }
          this.answerUserShow = true
          this.$router.push({name:'details.questionnaireUsers'})
        },
        singleAnswer(key,index,type){
          if(this.alreadyAnswer == true){
            alert('您已经回答了该帖子');
            return;
          }
          this.$set(this.answerData,index,key)
        },
        multiAnswer(key,index,type){
          if(this.alreadyAnswer == true){
            alert('您已经回答了该帖子');
            return;
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
            alert('您已经回答了该帖子');
            return;
          }
          // this.answerData[index] = minute
          this.$set(this.answerData,index,minute)
        },
        async submit(){
          if(this.alreadyAnswer == true){
            alert('您已经回答了该帖子');
            return;
          }
          
          this.answerData.map(answer=>{
            this.checkCnt ++;
          })
          if(this.checkCnt != this.contentData.questionnaires.content.length){
            alert('请回答所有问题');
            return
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