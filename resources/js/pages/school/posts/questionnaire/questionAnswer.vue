<template>
  <v-container>
    <div class="mt-3">
        <QuestionItem :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
        <v-divider></v-divider>
    </div>
    <v-row>
      <v-col>
          <v-btn color="primary" @click="addQaContent">{{lang.submit}}</v-btn>
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
      // this.$store.dispatch('content/storeQaData',this.qaContentDataArr)
      // this.$router.push({name:'questionnaire.new'});
      this.$emit('contentData',this.qaData);
      this.$router.push({name:'posts.questionnaire'});
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