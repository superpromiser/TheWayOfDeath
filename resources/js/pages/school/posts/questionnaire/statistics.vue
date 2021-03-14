<template>
  <div>
      <QuestionItem :Label="lang.contentPlace"/>
      <div class="divider"></div>
      <v-row>
        <v-col>
          {{lang.numberRange}}
        </v-col>
        <v-col>
          <v-text-field
            :label="lang.startingValue"
            v-model="statDataArr.sValue"
          ></v-text-field>
          {{lang.to}}
          <v-text-field
            :label="lang.endValue"
            v-model="statDataArr.eValue"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          {{lang.unit}}
        </v-col>
        <v-col>
          <v-text-field
            :label="lang.endValue"
            v-model="statDataArr.unit"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
          <v-col>
              <v-btn color="primary" @click="addStatContent">{{lang.submit}}</v-btn>
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

  data: () => ({
    statDataArr:{
        QuestionItemData:[
          {
            text:"test",
            imgUrl:['test1.jpg','test2.jpg'],
            otherUrl:['test1.pdf','test2.pdf'],
            videoUrl:['test1.mp4','test2.mp4']
          },
        ],
        sValue:0,
        eValue:0,
        unit:''
      },
    lang,
  }),

  methods:{
    addStatContent(){
      this.$store.dispatch('content/storeStatData',this.statDataArr);
      this.$router.push({name:"questionnaire.new"});
    }
  }

}
</script>

<style>

</style>