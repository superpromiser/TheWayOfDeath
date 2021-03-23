<template>
  <v-container class="pa-0">
      <div v-if="postNew == true">
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
                text
                color="primary"
                @click="selContent('template')"
            >
                可用模板 0， 草稿 0
            </v-btn>
            <v-btn
                dark
                color="green lighten-1"
                class="mr-8"
                :loading="isSubmit"
                @click="submit"
            >
                {{lang.submit}}
            </v-btn>
            <v-btn
                dark
                color="lighten-1"
                class="mr-md-8"
                :loading="isDraft"
                @click="saveDraft"
            >
                {{lang.saveDraft}}
            </v-btn>
            </template>
        </v-banner>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newQuestionnaireData.title"
                        label="标题"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newQuestionnaireData.description"
                        label="说明（选填）"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    >
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="newQuestionnaireData.deadline"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            solo
                            v-model="newQuestionnaireData.deadline"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            hide-details
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="newQuestionnaireData.deadline"
                        no-title
                        scrollable
                        >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                            @click="menu = false"
                        >
                            {{lang.cancel}}
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$refs.menu.save(date)"
                        >
                            {{lang.ok}}
                        </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        multiple
                        chips
                        :items="schoolTree"
                        item-text="lessonName"
                        item-value="lessonId"
                        @change="selectedLesson"
                        label="班级"
                        hide-details
                        v-model="newQuestionnaireData.viewList"
                    ></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span>匿名问卷</span>
                    <v-switch
                        v-model="newQuestionnaireData.questionnaireFlag"
                        color="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span>答卷人可见结果</span>
                    <v-switch
                        v-model="newQuestionnaireData.resultFlag"
                        color="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span>外部人员可作答</span>
                    <v-switch
                        v-model="newQuestionnaireData.answerFlag"
                        color="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
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
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('stat')">
                        <v-icon>
                            mdi-plus
                        </v-icon>统计题
                    </v-btn>
                </v-col>
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
              <v-col cols="12" v-for="(data, index) in newQuestionnaireData.content" :key="index">
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
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)" >
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
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)">
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
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)">
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
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)" >
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
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)">
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
        <router-view @contentData="saveContent"></router-view>
      </div>
      <v-snackbar
        timeout="3000"
        v-model="isSuccessed"
        color="success"
        absolute
        top
        >
        {{lang.successText}}
    </v-snackbar>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import lang from '~/helper/lang.json';
import QuestionItem from '~/components/questionItem';
import AttachItemViewer from '~/components/attachItemViewer';
import {getQuestionnaire,createQuestionnaire,updateQuestionnaire,deleteQuestionnaire} from '~/api/questionnaire';
import {getTemplate,createTemplate,updateTemplate,deleteTemplate} from '~/api/template';
export default {
  data: () => ({
      lang,
      baseUrl: window.Laravel.base_url,
      newQuestionnaireData : {
          title:'',
          description:'',
          viewList:[],
          deadline:'',
          questionnaireFlag:true,
          resultFlag:true,
          answerFlag:false,
          classId:null,
          content:[],
      },
      postNew:true,
      selType:'',
      dialog:false,
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      alphabet:['A','B','C','D','E','F','G','H','J','K','L','M','N',
                'O','P','Q','R','S','T','U','V','W','X','Y','Z' ],
      isSubmit:false,
      isDraft:false,
      isSuccessed:false,
  }),

  components: {
      QuestionItem,
      AttachItemViewer
  },

  computed: {
      ...mapGetters({
          schoolTree : 'schooltree/schoolTree',
      }),
      currentPath(){
        return this.$route;
      }
  },

  watch:{
    currentPath:{
      handler(val){
          if(val.name == 'classposts.questionnaire'){
            this.postNew = true
          }
      },
      deep:true
    },
  },

  created(){
    // getTemplate({contentId:1}).then(res=>{
    //   console.log(res)
    // }).catch(err=>{
    //   console.log(err.response)
    // })
    console.log(this.currentPath)
    this.newQuestionnaireData.classId = this.currentPath.params.classId
    if(this.currentPath.query.tempData){
      this.newQuestionnaireData.content = JSON.parse(this.currentPath.query.tempData)
      console.log(this.newQuestionnaireData.content[0])
    }
  },

  methods:{
    updateImageFile(imageFile){
        console.log(imageFile)
    },
    selectedLesson(val){
        console.log(val)
    },
    selContent(type){
        this.postNew = false;
        this.selType = type;
        switch(type){
            case 'single':
                this.$router.push({name:"classQuestionnaire.single"});
                break;
            case 'multi':
                this.$router.push({name:"classQuestionnaire.multi"});
                break;
            case 'question':
                this.$router.push({name:"classQuestionnaire.questionAnswer"});
                break;
            case 'stat':
                this.$router.push({name:"classQuestionnaire.statistics"});
                break;
            case 'scoring':
                this.$router.push({name:"classQuestionnaire.scoring"});
                break;
            case 'template':
                this.$router.push({name:"classQuestionnaire.templateList"});
                break;
            default:
                break;
        }
    },
    saveContent(data){
      this.postNew = true;
      switch(this.selType){
        case 'single':
          this.newQuestionnaireData.content.push(data)
          break;
        case 'multi':
          this.newQuestionnaireData.content.push(data)
          break;
        case 'question':
          this.newQuestionnaireData.content.push(data)
          break;
        case 'stat':
          this.newQuestionnaireData.content.push(data)
          break;
        case 'scoring':
          this.newQuestionnaireData.content.push(data)
          break;
        default:
          break;
      }
    },
    async submit(){
      console.log(this.newQuestionnaireData)
      this.isSubmit = true
      await createQuestionnaire(this.newQuestionnaireData).then(res => {
        console.log(res)
        this.isSuccessed = true;
        // this.newQuestionnaireData = null
        this.$router.push({name:'classSpace.news'})
      }).catch(err=>{
        console.log(err.response)
         if(err.response.status === 422){
            for(let i in err.response.data.errors){
                console.log(err.response.data.errors[i][0])
            }
        }
      })
      this.isSubmit = false
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
      let temp = Object.assign({}, this.newQuestionnaireData.content[index-1]);
      Object.assign(this.newQuestionnaireData.content[index-1], this.newQuestionnaireData.content[index] ) ;
      Object.assign(this.newQuestionnaireData.content[index], temp);
    },

    pushDown(index){
      let temp = Object.assign({}, this.newQuestionnaireData.content[index+1]);
      Object.assign(this.newQuestionnaireData.content[index+1], this.newQuestionnaireData.content[index] ) ;
      Object.assign(this.newQuestionnaireData.content[index], temp);
    },

    editContent(data, index){
      console.log(data, index);
    },

    deleteContent(index){
      this.newQuestionnaireData.content.splice(index, 1)
    },


    saveDraft(){
      console.log(this.newQuestionnaireData)
      this.isDraft = true;
      createTemplate({tempData:this.newQuestionnaireData,tempType:1,contentId:1}).then(res=>{
        console.log(res)
      }).catch(err=>{
        console.log(err.response)
      })
      this.isDraft = false;
    }

  }
}
</script>

<style>

</style>