<template>
  <v-container>
    <div class="mt-3">
        <QuestionItem class="mt-10" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
        <v-divider></v-divider>
    </div>
    <v-container>
      <v-row class="my-10 d-flex align-center">
          <v-btn large rounded dark color="green lighten-1" @click="addQaContent">{{lang.submit}}</v-btn>
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
import QuestionItem from '~/components/questionItem'
import lang from '~/helper/lang.json'
export default {
  components:{
    QuestionItem,
  },

  data: () => ({
    qaData : {
      type : 'qa',
      qaContentDataArr:[],
    },
    lang,
    requiredText:false,
  }),

  methods:{
    addQaContent(){
      this.$refs.child.emitData()
      if(this.qaData.qaContentDataArr.length == 0){
        return
      }
      this.$emit('contentData',this.qaData);
      if(this.type == 'post'){
          this.$router.push({name:'classposts.questionnaire'});
      }else{
          this.$router.push({name:'classQuestionnaire.templateNew'})
      }
    },
    loadContentData(data){
      if(data.text === ''){
        this.requiredText = true;
        this.qaData.qaContentDataArr = [];
        return;
      }
      this.qaData.qaContentDataArr.push(data)
    }
  },
}
</script>

<style>

</style>