<template>
  <v-container class="pa-0">
      <div v-if="templateNew == true">
        <div class="px-10 mb-10 z-index-2 banner-custom" color="white" sticky elevation="20">
           <v-row>
              <v-col cols="6" md="4" class="d-flex align-center position-relative">
                  <a @click="$router.go(-1)">
                      <v-icon size="70" class=" left-24p">
                          mdi-chevron-left
                      </v-icon>
                  </a>
              </v-col>
              <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                  <h2>{{lang.questionnaire}}模板</h2>
              </v-col>
              <v-col cols="12" md="4" class="d-flex align-center justify-end">
                  <v-btn
                      tile
                      dark
                      color="green lighten-1"
                      class="mx-2"
                      :loading="isSubmit"
                      @click="submit"
                  >
                      {{lang.submit}}
                  </v-btn>
              </v-col>
          </v-row>
        </div>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    solo
                    v-model="newQuestionnaireTemplateData.temTitle"
                    label="模板名称"
                    hide-details
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    solo
                    v-model="newQuestionnaireTemplateData.title"
                    label="标题"
                    hide-details
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    solo
                    v-model="newQuestionnaireTemplateData.description"
                    label="说明（选填）"
                    hide-details
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <UploadImage @upImgUrl="upImgUrl" @clearedImg="clearedImg" :solo="true" uploadLabel="模板封面" />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('single')">
                        <v-icon>
                            mdi-plus
                        </v-icon>单选题
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('multi')">
                        <v-icon>
                            mdi-plus
                        </v-icon>多选题
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('question')">
                        <v-icon>
                            mdi-plus
                        </v-icon>问答题
                    </v-btn>
                </v-col>
                <!-- <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('stat')">
                        <v-icon>
                            mdi-plus
                        </v-icon>统计题
                    </v-btn>
                </v-col> -->
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('scoring')">
                        <v-icon>
                            mdi-plus
                        </v-icon>评分题
                    </v-btn>
                </v-col>
            </v-row>
            <!--  View Datas  -->
            <v-row class="mt-10">
              <!--  View Divider  -->
              <v-col cols="12">
                <v-divider></v-divider>
              </v-col>
              <!--  View Datas  -->
              <v-col cols="12" v-for="(data, index) in newQuestionnaireTemplateData.content" :key="index">
                <!--  single Datas  -->
                <v-row v-if="data.type == 'single'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>单选题</strong>
                      </v-chip>
                     <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0"  >
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireTemplateData.content.length-1)" >
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)" >
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)" >
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.singleContentDataArr[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.singleContentDataArr[0])">
                    <AttachItemViewer :items="data.singleContentDataArr[0]" />
                  </v-col>
                  <v-col class="pl-6" cols="12" v-for="(singleData, singleDataIndex) in data.singleContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                    <div> 
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
                <v-row v-if="data.type == 'multi'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>多选题</strong>
                      </v-chip>
                      <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0">
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireTemplateData.content.length-1)">
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)" >
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)" >
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.multiContentDataArr[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.multiContentDataArr[0])">
                    <AttachItemViewer :items="data.multiContentDataArr[0]" />
                  </v-col>
                  <v-col class="pl-6" cols="12" v-for="(multiData, singleDataIndex) in data.multiContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                    <div> 
                      <v-chip
                        class="mr-2"
                        color="success"
                        outlined
                      >
                        <strong>{{alphabet[singleDataIndex-1]}}</strong>
                      </v-chip>
                      <p class="mb-0 text-wrap"> {{multiData.text}}</p>
                    </div>
                    <AttachItemViewer :items="multiData" v-if="checkIfAttachExist(multiData)" />
                  </v-col>
                </v-row>
                <!--  qa Datas  -->
                <v-row v-if="data.type == 'qa'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>问答题</strong>
                      </v-chip>
                     <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0">
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireTemplateData.content.length-1)">
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)">
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)">
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.qaContentDataArr[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.qaContentDataArr[0])">
                    <AttachItemViewer :items="data.qaContentDataArr[0]" />
                  </v-col>
                </v-row>
                <!--  statistics Datas  -->
                <v-row v-if="data.type == 'stat'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>统计题</strong>
                      </v-chip>
                     <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0">
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireTemplateData.content.length-1)" >
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)">
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)">
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.statDataArr[0].contentData[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.statDataArr[0].contentData[0])">
                    <AttachItemViewer :items="data.statDataArr[0].contentData[0]" />
                  </v-col>
                </v-row>
                <!--  score Datas  -->
                <v-row v-if="data.type == 'score'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>评分题</strong>
                      </v-chip>
                     <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0">
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireTemplateData.content.length-1)">
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)">
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)">
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.scoringDataArr[0].contentData[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.scoringDataArr[0].contentData[0])">
                    <AttachItemViewer :items="data.scoringDataArr[0].contentData[0]" />
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
        </v-container>
      </div>
      <div v-else>
        <router-view @contentData="saveContent" :type="'temp'"></router-view>
      </div>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import AttachItemViewer from '~/components/attachItemViewer'
import UploadImage from '~/components/UploadImage';
import {createQuestionnaireTemp,updateQuestionnaire,deleteQuestionnaire} from '~/api/questionnaire'
export default {
  data: () => ({
      lang,
      baseUrl: window.Laravel.base_url,
      newQuestionnaireTemplateData : {
          temTitle : '',
          imgUrl : '',
          title:'',
          description:'',
          // viewList:[],
          tempType:1,
          content:[],
      },
      templateNew:true,
      selType:'',
      dialog:false,
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      alphabet:['A','B','C','D','E','F','G','H','J','K','L','M','N',
                'O','P','Q','R','S','T','U','V','W','X','Y','Z' ],
      isSubmit:false,
  }),

  components: {
      QuestionItem,
      AttachItemViewer,
      UploadImage
  },

  computed: {
      currentPath(){
        return this.$route;
      }
  },

  watch:{
    currentPath:{
      handler(val){
          if(val.name == 'questionnaire.templateNew'){
            this.templateNew = true
          }
      },
      deep:true
    }
  },

  methods:{
    updateImageFile(imageFile){
        //console.log(imageFile)
    },
    selectedLesson(val){
        //console.log(val)
    },
    selContent(type){
        this.templateNew = false;
        this.selType = type;
        switch(type){
            case 'single':
                this.$router.push({name:"questionnaireTemplate.single"});
                break;
            case 'multi':
                this.$router.push({name:"questionnaireTemplate.multi"});
                break;
            case 'question':
                this.$router.push({name:"questionnaireTemplate.questionAnswer"});
                break;
            case 'stat':
                this.$router.push({name:"questionnaireTemplate.statistics"});
                break;
            case 'scoring':
                this.$router.push({name:"questionnaireTemplate.scoring"});
                break;
            default:
                break;
        }
    },
    saveContent(data){
      this.templateNew = true;
      switch(this.selType){
        case 'single':
          this.newQuestionnaireTemplateData.content.push(data)
          break;
        case 'multi':
          this.newQuestionnaireTemplateData.content.push(data)
          break;
        case 'question':
          this.newQuestionnaireTemplateData.content.push(data)
          break;
        case 'stat':
          this.newQuestionnaireTemplateData.content.push(data)
          break;
        case 'scoring':
          this.newQuestionnaireTemplateData.content.push(data)
          break;
        default:
          break;
      }
    },
    async submit(){
      //console.log(this.newQuestionnaireTemplateData)
      this.isSubmit = true
      await createQuestionnaireTemp(this.newQuestionnaireTemplateData).then(res=>{
        this.isSubmit = false
        this.$router.push({name:'questionnaire.templateList'})
        //console.log(res.data)
      }).catch(err=>{
        this.isSubmit = false
        //console.log(err.response)
      })

    },

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

    pushUp(index){
      let temp = Object.assign({}, this.newQuestionnaireTemplateData.content[index-1]);
      Object.assign(this.newQuestionnaireTemplateData.content[index-1], this.newQuestionnaireTemplateData.content[index] ) ;
      Object.assign(this.newQuestionnaireTemplateData.content[index], temp);
    },

    pushDown(index){
      let temp = Object.assign({}, this.newQuestionnaireTemplateData.content[index+1]);
      Object.assign(this.newQuestionnaireTemplateData.content[index+1], this.newQuestionnaireTemplateData.content[index] ) ;
      Object.assign(this.newQuestionnaireTemplateData.content[index], temp);
    },

    editContent(data, index){
      //console.log(data, index);
    },

    deleteContent(index){
      this.newQuestionnaireTemplateData.content.splice(index, 1)
    },

    upImgUrl(value) {
      this.newQuestionnaireTemplateData.imgUrl = value;
    },
    clearedImg(){
      this.newQuestionnaireTemplateData.imgUrl = ''
    },

  }
}
</script>

<style>

</style>