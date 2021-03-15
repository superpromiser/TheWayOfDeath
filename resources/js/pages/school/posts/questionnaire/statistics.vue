<template>
  <div>
      <QuestionItem :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
      <div class="divider"></div>
      <v-row>
        <v-col>
          {{lang.numberRange}}
        </v-col>
        <v-col>
          <v-text-field
            :label="lang.startingValue"
            v-model="statData.statDataArr[0].sValue"
          ></v-text-field>
          {{lang.to}}
          <v-text-field
            :label="lang.endValue"
            v-model="statData.statDataArr[0].eValue"
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
            v-model="statData.statDataArr[0].unit"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
          <v-col>
              <v-btn color="primary" @click="addStatContent">{{lang.submit}}</v-btn>
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
      this.$router.push({name:'posts.questionnaire'});
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