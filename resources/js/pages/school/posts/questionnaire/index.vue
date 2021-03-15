<template>
  <v-container class="pa-0">
      <div v-if="postNew == true">
        <v-banner class=" mb-10" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3 ml-0"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>问卷</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                text
                color="primary"
            >
                可用模板 0， 草稿 0
            </v-btn>
            <v-btn
                dark
                color="green lighten-1"
                @click="submit"
            >
                {{lang.submit}}
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
                <v-row v-if="data.type == 'single'">
                  <v-col cols="12">
                    <p class="mb-0"> 
                      {{index + 1}}.  
                      <v-chip
                          class="ma-2"
                          color="success"
                          outlined
                        >
                        <strong>单选题</strong>
                      </v-chip>
                      <v-btn
                        fab
                        dark
                        x-small
                        color="primary"
                      >
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn
                        fab
                        dark
                        x-small
                        color="error"
                        class="ml-2"
                      >
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
                <v-row v-if="data.type == 'multi'">
                  <v-col cols="12">
                    <p class="mb-0"> 
                      {{index + 1}}.  
                      <v-chip
                          class="ma-2"
                          color="success"
                          outlined
                        >
                        <strong>多选题</strong>
                      </v-chip>
                      <v-btn
                        fab
                        dark
                        x-small
                        color="primary"
                      >
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn
                        fab
                        dark
                        x-small
                        color="error"
                        class="ml-2"
                      >
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
              </v-col>
            </v-row>
        </v-container>
      </div>
      <div v-else>
        <router-view @contentData="saveContent"></router-view>
      </div>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import AttachItemViewer from '~/components/attachItemViewer'
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
          type:0,
          content:[],
      },
      postNew:true,
      selType:'',
      dialog:false,
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      alphabet:['A','B','C','D','E','F','G','H','J','K','L','M','N',
                'O','P','Q','R','S','T','U','V','W','X','Y','Z' ],
  }),

  components: {
      QuestionItem,
      AttachItemViewer
  },

  computed: {
      ...mapGetters({
          schoolTree : 'schooltree/schoolTree',
          singleData:'content/singleData',
          multiData:'content/multiData',
          qaData:'content/qaData',
          statData:'content/statData',
          scoringData:'content/scoringData'
      })
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
                this.$router.push({name:"questionnaire.single"});
                break;
            case 'multi':
                this.$router.push({name:"questionnaire.multi"});
                break;
            case 'question':
                this.$router.push({name:"questionnaire.questionAnswer"});
                break;
            case 'stat':
                this.$router.push({name:"questionnaire.statistics"});
                break;
            case 'scoring':
                this.$router.push({name:"questionnaire.scoring"});
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
    submit(){
      console.log(this.newQuestionnaireData)
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
    }
  }
}
</script>

<style>

</style>