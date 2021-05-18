<template>
<v-container v-if="$isMobile()" class="pa-0 h-100 bg-gray-light-dark mb-16 pb-3 pt-12">
    <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
      <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
        mdi-chevron-left
      </v-icon>
      <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >问答题</p>
    </v-row>
    <div>
        <QuestionItem class="mt-2" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
    </div>
    <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-white pa-3 ">
      <v-col cols="12" class="d-flex justify-space-between align-center pa-0">
        <v-btn color="#7879ff" block dark large @click="addQaContent"> 确认发布 </v-btn>
      </v-col>
    </v-row>
  </v-container>
  <v-container v-else>
    <div class="mt-3">
        <QuestionItem :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
        <v-divider class="thick-border" light></v-divider>
    </div>
    <v-container>
      <v-row class="my-10 d-flex align-center ">
        <v-btn large rounded dark color="#7879ff" @click="addQaContent">{{lang.submit}}</v-btn>
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
        this.qaData.qaContentDataArr = [];
        return this.$snackbar.showMessage({content: "标题不能为空", color: "error"})
      }
      this.qaData.qaContentDataArr.push(data)
    }
  },
}
</script>

<style>

</style>