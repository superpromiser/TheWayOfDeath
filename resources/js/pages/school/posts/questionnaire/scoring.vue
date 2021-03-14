<template>
  <div>
    <QuestionItem :Label="lang.contentPlace" />
    <div class="divider"></div>
    <v-row>
      <v-col cols=6>
        {{lang.maxMinutes}}
      </v-col>
      <v-col cols=6>
        <v-select
          :items="items"
          label="Standard"
          v-model="maxMin"
        ></v-select>
      </v-col>
    </v-row>
    <v-row>
          <v-col>
              <v-btn color="primary" @click="addScoringContent">{{lang.submit}}</v-btn>
          </v-col>
      </v-row>
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
    scoringDataArr:[
      {
        contentData:[],
        maxMin:''
      }
    ],
    items:[
      '2','3','4','5','6','7','8','9','10'
    ]

  }),

  methods:{
    addScoringContent(){
      this.$store.dispatch('content/storeScoringData',this.scoringDataArr);
      this.$router.push({name:'questionnaire.new'})
    }
  }
}
</script>

<style>

</style>