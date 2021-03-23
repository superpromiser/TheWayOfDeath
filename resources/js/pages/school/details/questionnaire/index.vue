<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
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
                    color="green lighten-1"
                    class="mr-8"
                    tile
                    @click="answerUsers"
                >
                    已答
                    <v-icon right>
                        mdi-chevron-right
                    </v-icon>
                </v-btn>
            </template>
        </v-banner>
        <!----title---->
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
                  <v-col cols="12">
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
                  <v-col class="pl-6" cols="12" v-for="(singleData, singleDataIndex) in content.singleContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                    <div class="d-flex align-center cursor-pointer" @click="singleAnswer(singleData,singleDataIndex)" :class="{active: singleDataIndex == answerData.singleAnswer}"> 
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
                  <v-col cols="12">
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
                  <v-col class="pl-6" cols="12" v-for="(multiData, multiDataIndex) in content.multiContentDataArr" :key="multiDataIndex" v-if="multiDataIndex !== 0">
                    <div class="d-flex align-center cursor-pointer" @click="multiAnswer(multiData,multiDataIndex)" :class="{active: answerData.multiAnswer.indexOf(multiDataIndex) > -1}"> 
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
                  <v-col cols="12">
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
                      v-model="answerData.questionAnswer"
                      hide-details
                    ></v-textarea>
                  </v-col>
                </v-row>
                <!--  statistics Datas  -->
                <v-row v-if="content.type == 'stat'">
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
                </v-row>
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
                    <div v-for="(minute,i) in parseInt(content.scoringDataArr[0].maxMin)" :key="i" class="op-score" :class="{selMinute: minute == answerData.scoringAnswer}" @click="selScoring(minute)">
                        {{minute}}
                    </div>
                  </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row class="float-right m-3">
           <v-btn
                dark
                color="green lighten-1"
                class="mr-8"
                tile
                :loading="isSubmit"
                @click="submit"
            >
                {{lang.submit}}
            </v-btn>
        </v-row>
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
        answerData:{
          singleAnswer:null,
          multiAnswer:[],
          questionAnswer:'',
          statAnswer:'',
          scoringAnswer:null,
          postId:null
        },
        answerDataList:[],
        isSubmit:false,
        alreadyAnswer:false,
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

    async created(){
        console.log('------------',this.user)
        if(this.contentData == null){
          this.$router.push({name:'schoolSpace.news'})
        }
        this.contentData.questionnaires.content = JSON.parse(this.contentData.questionnaires.content);
        this.answerData.postId = this.contentData.id
        await getAnswerQuestionnaire({postId:this.answerData.postId}).then(res=>{
          console.log('getAnswerQuestionnaire',res.data)
          this.answerDataList = res.data;
          this.answerDataList.map(answerData=>{
            if(answerData.userId == this.user.id){
              this.answerData = answerData
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
          console.log('answerUsers')
        },
        singleAnswer(data,index){
          if(this.alreadyAnswer == true){
            alert('您已经回答了该帖子');
            return;
          }
          console.log(data,index)
          this.answerData.singleAnswer = index
        },
        multiAnswer(data,selIndex){
          if(this.alreadyAnswer == true){
            alert('您已经回答了该帖子');
            return;
          }
          console.log(data,selIndex)
          let index = this.answerData.multiAnswer.indexOf(selIndex)
          if(index > -1){
            this.answerData.multiAnswer.splice(index,1);
          }else{
            this.answerData.multiAnswer.push(selIndex)
          }
        },
        selScoring(minute){
          if(this.alreadyAnswer == true){
            alert('您已经回答了该帖子');
            return;
          }
          this.answerData.scoringAnswer = minute
        },
        async submit(){
          if(this.alreadyAnswer == true){
            alert('您已经回答了该帖子');
            return;
          }
          if(this.answerData.singleAnswer == null || this.answerData.multiAnswer.length == 0 || this.answerData.questionAnswer == '' || this.answerData.statAnswer == '' || this.answerData.scoringAnswer == null){
            alert('请回答所有问题');
            return
          }
          this.isSubmit = true;
          await createAnswerQuestionnaire(this.answerData).then(res=>{
            console.log(res)
            if(this.currentpath.params.classId){
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