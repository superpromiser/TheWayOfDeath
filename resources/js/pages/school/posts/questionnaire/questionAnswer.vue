<template>
  <div>
    <div class="mt-3">
        <QuestionItem :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
        <div class="divider"></div>
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
  </div>
</template>

<script>
import QuestionItem from '~/components/questionItem'
import lang from '~/helper/lang.json'
export default {
  components:{
    QuestionItem,
  },

  data: () => ({
    qaContentDataArr:[],
    lang,
    requiredText:false,
  }),

  methods:{
    addQaContent(){
      this.$refs.child.emitData()
      if(this.qaContentDataArr.length == 0){
        return
      }
      this.$store.dispatch('content/storeQaData',this.qaContentDataArr)
      this.$router.push({name:'questionnaire.new'});
    },
    loadContentData(data){
      if(data.text === ''){
        this.requiredText = true;
        this.qaContentDataArr = [];
        return;
      }
      this.qaContentDataArr.push(data)
    }
  },
}
</script>

<style>

</style>