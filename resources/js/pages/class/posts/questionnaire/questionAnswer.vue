<template>
  <v-container>
    <div class="mt-3">
        <QuestionItem class="mt-10" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
        <v-divider></v-divider>
    </div>
    <v-container>
      <v-row class="my-10 d-flex align-center justify-end" v-if="$isMobile()">
        <v-btn class="ml-auto mr-3" large rounded dark color="#eb6846" @click="addQaContent">{{lang.submit}}</v-btn>
        <v-btn fab class="mo-glow " style="color:#eb6846" @click="$router.go(-1)"><v-icon>mdi-undo-variant</v-icon></v-btn>
      </v-row>
      <v-row class="my-10 d-flex align-center " v-else>
        <v-btn large rounded dark color="#49d29e" @click="addQaContent">{{lang.submit}}</v-btn>
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
  
  props:{
      type:{
          type:String,
          requireed:false
      }
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
          this.$router.push({name:'posts.Cquestionnaire'});
      }else{
          this.$router.push({name:'Cquestionnaire.templateNew'})
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