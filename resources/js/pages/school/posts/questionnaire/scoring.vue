<template>
  <v-container v-if="$isMobile()" class="pa-0 h-100 bg-gray-light-dark mb-16 pb-3 pt-12">
    <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
      <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
        mdi-chevron-left
      </v-icon>
      <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >评分题</p>
    </v-row>
    <div v-if="isNew == true">
        <QuestionItem class="mt-2" :Label="lang.contentPlace" ref="childNew" @contentData="loadContentData"/>
        <v-divider light class="thick-border"></v-divider>
        <v-row class="ma-0 mt-2 bg-white">
          <v-col cols="12" md="6" class="d-flex align-end">
            <p class="mb-0 mr-5">{{lang.maxMinutes}}</p>
            <v-select
              :items="items"
              :menu-props="{ top: false, offsetY: true }"
              :label="lang.maxMinutes"
              v-model="scoreData.scoringDataArr[0].maxMin"
              hide-details
            ></v-select>
          </v-col>
        </v-row>
    </div>
    <div v-if="isNew == false">
        <QuestionItem class="mt-2" :Label="lang.contentPlace" :item="scoreData.scoringDataArr[0].contentData[0]" ref="childEdit" @contentData="loadContentData"/>
        <v-divider light class="thick-border"></v-divider>
        <v-row class="ma-0 px-10">
          <v-col cols="12" md="6" class="d-flex align-end">
            <p class="mb-0 mr-5">{{lang.maxMinutes}}</p>
            <v-select
              :items="items"
              :menu-props="{ top: false, offsetY: true }"
              :label="lang.maxMinutes"
              v-model="scoreData.scoringDataArr[0].maxMin"
              hide-details
            ></v-select>
          </v-col>
        </v-row>
    </div>
    <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-white pa-3 ">
      <v-col cols="12" class="d-flex justify-space-between align-center pa-0">
        <v-btn color="#7879ff" block dark large @click="addScoringContent"> 确认发布 </v-btn>
      </v-col>
    </v-row>
  </v-container>
  <v-container class="pa-0" v-else>
    <v-container class="px-10 z-index-2 banner-custom">
        <v-row>
          <v-col cols="6" md="4" class="d-flex align-center position-relative">
            <a @click="$router.go(-1)">
                <v-icon size="70" class=" left-24p">
                    mdi-chevron-left
                </v-icon>
            </a>
          </v-col>
          <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
              <h2>评分题</h2>
          </v-col>
          <v-col cols="12" md="4" class="d-flex align-center justify-end">
            <v-btn tile dark color="#7879ff" class="mx-2" @click="addScoringContent" >
                {{lang.submit}}
            </v-btn>
          </v-col>
        </v-row>
    </v-container>
    <!-- <div class="mt-3 mb-10 px-10">
      <QuestionItem class="" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
      <v-divider light class="thick-border"></v-divider>
    </div> -->
    <div v-if="isNew == true" class="mt-3 px-10">
        <QuestionItem :Label="lang.contentPlace" ref="childNew" @contentData="loadContentData"/>
        <v-divider light class="thick-border"></v-divider>
        <v-row class="ma-0 px-10">
          <v-col cols="12" md="6" class="d-flex align-end">
            <p class="mb-0 mr-5">{{lang.maxMinutes}}</p>
            <v-select
              :items="items"
              :menu-props="{ top: false, offsetY: true }"
              :label="lang.maxMinutes"
              v-model="scoreData.scoringDataArr[0].maxMin"
              hide-details
            ></v-select>
          </v-col>
        </v-row>
    </div>
    <div v-if="isNew == false" class="mt-3 px-10">
        <QuestionItem class="mt-10" :Label="lang.contentPlace" :item="scoreData.scoringDataArr[0].contentData[0]" ref="childEdit" @contentData="loadContentData"/>
        <v-divider light class="thick-border"></v-divider>
        <v-row class="ma-0 px-10">
          <v-col cols="12" md="6" class="d-flex align-end">
            <p class="mb-0 mr-5">{{lang.maxMinutes}}</p>
            <v-select
              :items="items"
              :menu-props="{ top: false, offsetY: true }"
              :label="lang.maxMinutes"
              v-model="scoreData.scoringDataArr[0].maxMin"
              hide-details
            ></v-select>
          </v-col>
        </v-row>
    </div>
    
  </v-container>
</template>

<script>
import QuestionItem from '~/components/questionItem';
import lang from '~/helper/lang.json';
export default {
  components:{
    QuestionItem,
  },

  props:{
      type:{
          type:String,
          requireed:false
      }
  },

  created(){
      //console.log(this.type)
      if(this.currentPath.params.editDataArr !== undefined){
          this.isNew = false;
          this.scoreData.scoringDataArr = this.currentPath.params.editDataArr;
          this.scoreData.index = this.currentPath.params.editDataIndex;
      }
      if(this.type == undefined){
          this.$router.push({name:'posts.questionnaire'})
      }
  },
  
  data:() => ({
    lang,
    scoreData : {
      scoringDataArr:[
        {
          contentData:[],
          maxMin:'2'
        }
      ],
      type : "score",
      index:null,
    },
    items:[
      '2','3','4','5','6','7','8','9','10'
    ],
    requiredText:false,
    isNew:true,
  }),

  computed:{
      currentPath(){
          return this.$route
      }
  },
    
  methods:{
    addScoringContent(){
      // this.$refs.child.emitData();
      if(this.isNew == true){
        this.$refs.childNew.emitData();
      }else{
        this.$refs.childEdit.emitData();
      }
      if(this.scoreData.scoringDataArr[0].contentData.length == 0){
        return this.$snackbar.showMessage({content: "标题不能为空", color: "error"})
      }
      
      this.$emit('contentData',this.scoreData);
      if(this.type == 'post'){
          this.$router.push({name:'posts.questionnaire'});
      }else{
          this.$router.push({name:'questionnaire.templateNew'})
      }
    },
    loadContentData(data){
      if(data.text === ''){
        this.scoreData.scoringDataArr[0].contentData = []
        return this.$snackbar.showMessage({content: "标题不能为空", color: "error"})
      }
      this.scoreData.scoringDataArr[0].contentData = []
      this.scoreData.scoringDataArr[0].contentData.push(data)
    }
  }
}
</script>

<style>

</style>