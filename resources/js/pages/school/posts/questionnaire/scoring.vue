<template>
  <div>
    <QuestionItem :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
    <div class="divider"></div>
    <v-row>
      <v-col cols=6>
        {{lang.maxMinutes}}
      </v-col>
      <v-col cols=6>
        <v-select
          :items="items"
          label="2"
          v-model="scoreData.scoringDataArr[0].maxMin"
        ></v-select>
      </v-col>
    </v-row>
    <v-row>
        <v-col>
            <v-btn color="primary" @click="addScoringContent">{{lang.submit}}</v-btn>
        </v-col>
    </v-row>
    <v-snackbar
        timeout="3000"
        v-model="requiredText"
        color="error"
        absolute
        top
        >
        {{lang.requiredText}}
    </v-snackbar>
  </div>
</template>

<script>
import QuestionItem from '~/components/questionItem';
import lang from '~/helper/lang.json';
export default {
  components:{
    QuestionItem,
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

  methods:{
    addScoringContent(){
      this.$refs.child.emitData();
      if(this.scoreData.scoringDataArr[0].contentData.length == 0){
        this.requiredText = true;
        return
      }
      
      this.$emit('contentData',this.scoreData);
      this.$router.push({name:'posts.questionnaire'});
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