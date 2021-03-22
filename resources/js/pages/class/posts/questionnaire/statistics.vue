<template>
  <v-container>
      <div class="mt-3 mb-10">
          <QuestionItem class="mt-10" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
          <v-divider></v-divider>
      </div>
      <v-row>
        <v-col cols="12" md="6">
          <v-row>
            <v-col cols="12">{{lang.numberRange}}</v-col>
            <v-col cols="12" class="d-flex align-end justify-content-around">
              <v-text-field
                :label="lang.startingValue"
                v-model="statData.statDataArr[0].sValue"
                hide-details
              ></v-text-field>
              <p class="mb-0 mx-5">{{lang.to}}</p>
              <v-text-field
                :label="lang.endValue"
                v-model="statData.statDataArr[0].eValue"
                hide-details
              ></v-text-field>
            </v-col>
          </v-row>
        </v-col>
        <v-col class="12" md="6">
          <v-row>
            <v-col cols="12">{{lang.unit}}</v-col>
            <v-col cols="12">
              <v-text-field
                :label="lang.endValue"
                v-model="statData.statDataArr[0].unit"
                hide-details
              ></v-text-field>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-container>
        <v-row class="my-10 d-flex align-center">
            <v-btn large rounded dark color="green lighten-1" @click="addStatContent">{{lang.submit}}</v-btn>
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

  data: () => ({
    statData : {
      statDataArr:[
        {
          contentData:[
          ],
          sValue:'',
          eValue:'',
          unit:''
        }
      ],
      type : 'stat'
    },
    lang,
    requiredText:false,
  }),

  methods:{
    addStatContent(){
      this.$refs.child.emitData()
      console.log(this.statData.statDataArr[0])
      if(this.statData.statDataArr[0].contentData.length == 0 || this.statData.statDataArr[0].sValue == '' || this.statData.statDataArr[0].eValue == '' || this.statData.statDataArr[0].unit == ''){
        this.requiredText = true;
        this.statData.statDataArr[0].contentData = [];
        return;
      }
      
      this.$emit('contentData',this.statData);
      if(this.type == 'post'){
          this.$router.push({name:'classposts.questionnaire'});
      }else{
          this.$router.push({name:'classQuestionnaire.templateNew'})
      }
    },
    loadContentData(data){
      console.log(data)
      if(data.text === ''){
        this.statData.statDataArr[0].contentData = []
        return;
      }
      this.statData.statDataArr[0].contentData.push(data);
    }
  }

}
</script>

<style>

</style>