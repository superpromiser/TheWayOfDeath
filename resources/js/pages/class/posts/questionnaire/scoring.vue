<template>
  <v-container>
    <div class="mt-3 mb-10">
      <QuestionItem :class="$isMobile() ? '': 'mt-10'" :Label="lang.contentPlace" ref="child" @contentData="loadContentData"/>
      <v-divider class="thick-border" light></v-divider>
    </div>
    <v-row>
      <v-col cols="12" md="6" class="d-flex align-center" v-if="$isMobile()">
        <v-select
          class="mo-glow-v-select mt-0 pt-0"
          color="#7879ff"
          :items="items"
          :menu-props="{ top: false, offsetY: true }"
          :label="lang.maxMinutes"
          v-model="scoreData.scoringDataArr[0].maxMin"
          hide-details
        ></v-select>
        <!-- <v-row>
          <v-col cols="12">{{lang.maxMinutes}}</v-col>
          <v-col cols="12">
            <v-select
              :items="items"
              label="2"
              v-model="scoreData.scoringDataArr[0].maxMin"
              hide-details
            ></v-select>
          </v-col>
        </v-row> -->
      </v-col>
      <v-col cols="12" md="6" class="d-flex align-end" v-else>
        <p class="mb-0 mr-5">{{lang.maxMinutes}}</p>
        <v-select
          :menu-props="{ top: false, offsetY: true }"
          :items="items"
          :label="lang.maxMinutes"
          v-model="scoreData.scoringDataArr[0].maxMin"
          hide-details
        ></v-select>
        <!-- <v-row>
          <v-col cols="12">{{lang.maxMinutes}}</v-col>
          <v-col cols="12">
            <v-select
              :items="items"
              label="2"
              v-model="scoreData.scoringDataArr[0].maxMin"
              hide-details
            ></v-select>
          </v-col>
        </v-row> -->
      </v-col>
    </v-row>
    <v-container>
      <v-row class="my-10 d-flex align-center justify-end" v-if="$isMobile()">
        <v-btn class="ml-auto mr-3" large rounded dark color="#eb6846" @click="addScoringContent">{{lang.submit}}</v-btn>
        <v-btn fab class="mo-glow " style="color:#eb6846" @click="$router.go(-1)"><v-icon>mdi-undo-variant</v-icon></v-btn>
      </v-row>
      <v-row class="my-10 d-flex align-center " v-else>
        <v-btn large rounded dark color="#49d29e" @click="addScoringContent">{{lang.submit}}</v-btn>
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
  props:{
    type:{
        type:String,
        requireed:false
    }
  },
  data:() => ({
    lang,
    scoreData : {
      scoringDataArr:[
        {
          contentData:[],
          maxMin:2
        }
      ],
      type : "score"
    },
    items:[
      '2','3','4','5','6','7','8','9','10'
    ],
    requiredText:false,
  }),

  methods:{
    addScoringContent(){
      this.$refs.child.emitData();
      if(this.scoreData.scoringDataArr[0].contentData.length == 0){
        return this.$snackbar.showMessage({content: "标题不能为空", color: "error"})
      }
      
      this.$emit('contentData',this.scoreData);
      if(this.type == 'post'){
          this.$router.push({name:'posts.Cquestionnaire'});
      }else{
          this.$router.push({name:'Cquestionnaire.templateNew'})
      }
    },
    loadContentData(data){
      if(data.text === ''){
        this.scoreData.scoringDataArr[0].contentData = []
        return;
      }
      this.scoreData.scoringDataArr[0].contentData.push(data)
    }
  }
}
</script>

<style>

</style>