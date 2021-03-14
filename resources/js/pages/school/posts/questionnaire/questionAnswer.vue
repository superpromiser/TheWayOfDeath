<template>
  <div>
    <div class="mt-3">
        <QuestionItem :Label="lang.contentPlace"/>
        <div class="divider"></div>
    </div>
    <v-row>
      <v-col>
          <v-btn color="primary" @click="addQaContent">{{lang.submit}}</v-btn>
      </v-col>
    </v-row>
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
    qaContentDataArr:[
      {
        text:'test1',
        imgUrl:['test1.jpg','test2.jpg'],
        otherUrl:['test1.pdf','test2.pdf'],
        videoUrl:['test1.mp4','test2.mp4']
      }
    ],
    lang,
  }),

  methods:{
    addQaContent(){
          this.$store.dispatch('content/storeQaData',this.qaContentDataArr)
          this.$router.push({name:'questionnaire.new'});
        }
  },
}
</script>

<style>

</style>