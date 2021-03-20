<template>
  <v-container>
    <div class="mt-3 mb-10">
      <QuestionItem class="mt-10" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
      <v-divider></v-divider>
    </div>
    <v-row>
      <v-col cols="12" md="6" class="d-flex align-end">
        <p class="mb-0 mr-5">{{lang.maxMinutes}}</p>
        <v-select
          :items="items"
          :label="lang.maxMinutes"
          v-model="scoreData.scoringDataArr[0].maxMin"
          hide-details
        ></v-select>
        <!-- <v-row>
          <v-col cols="12">{{lang.maxMinutes}}</v-col>
          <v-col cols="12">
            <v-select
              :items="items"
              label="2"
              v-model="scoreData.scoringDataArr[0].maxMin"
              hide-details
            ></v-select>
          </v-col>
        </v-row> -->
      </v-col>
    </v-row>
    <v-container>
      <v-row class="my-10 d-flex align-center">
        <v-btn large rounded dark color="green lighten-1" @click="addScoringContent">{{lang.submit}}</v-btn>
      </v-row>
    </v-container>
    <v-snackbar
        timeout="3000"
        v-model="requiredText"
        color="error"
        absolute
        top
        >
        {{lang.requiredText}}
    </v-snackbar>
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
      console.log(this.type)
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
          maxMin:2
        }
      ],
      type : "score"
    },
    items:[
      '2','3','4','5','6','7','8','9','10'
    ],
    requiredText:false,
  }),

  computed:{
      currentPath(){
          return this.$route
      }
  },
    
  methods:{
    addScoringContent(){
      this.$refs.child.emitData();
      if(this.scoreData.scoringDataArr[0].contentData.length == 0){
        this.requiredText = true;
        return
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
        return;
      }
      this.scoreData.scoringDataArr[0].contentData.push(data)
    }
  }
}
</script>

<style>

</style>