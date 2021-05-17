<template>
    <v-container class="pa-0 h-100 bg-gray-light-dark pb-16">
        <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{previewData.title}}详情 </p>
        </v-row>

        <!----questionnaire preview----->
        <v-container v-if="previewData.type == 'questionnaire'" class="pa-0 bg-white mt-2 mb-3">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex justify-center align-center ">
                  <h3>{{previewData.data.title}}</h3>
              </v-col>
              <v-col cols="12" class="pt-0">
                  <p class="mb-0">{{previewData.data.description}}</p>
              </v-col>
          </v-row>
          <v-row class="ma-0">
              <v-col cols="12" class="pt-0" v-for="(content, index) in previewData.data.content" :key="index">
                  <!--  single Datas  -->
                  <v-row v-if="content.type == 'single'">
                    <v-col cols="12" class="hover-cursor-point">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined small>
                          <strong>单选题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.singleContentDataArr[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.singleContentDataArr[0])">
                      <AttachItemViewer :items="content.singleContentDataArr[0]" />
                    </v-col>
                    <v-col class="pl-6 hover-cursor-point pt-0" cols="12" v-for="(singleData, singleDataIndex) in content.singleContentDataArr" :key="`${index}_${singleDataIndex}`" v-if="singleDataIndex !== 0">
                      <div class="d-flex align-center cursor-pointer"> 
                        <v-chip
                          class="mr-2"
                          color="success"
                          outlined
                          small
                        >
                          <strong>{{alphabet[singleDataIndex-1]}}</strong>
                        </v-chip>
                        <p class="mb-0 text-wrap"> {{singleData.text}}</p>
                      </div>
                      <AttachItemViewer :items="singleData" v-if="checkIfAttachExist(singleData)" />
                    </v-col>
                  </v-row>
                  <!--  multi Datas  -->
                  <v-row v-if="content.type == 'multi'">
                    <v-col cols="12" class="hover-cursor-point">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined small>
                          <strong>多选题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.multiContentDataArr[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.multiContentDataArr[0])">
                      <AttachItemViewer :items="content.multiContentDataArr[0]" />
                    </v-col>
                    <v-col class="pl-6 hover-cursor-point pt-0" cols="12" v-for="(multiData, multiDataIndex) in content.multiContentDataArr" :key="`${index}_${multiDataIndex}`" v-if="multiDataIndex !== 0">
                      <div class="d-flex align-center cursor-pointer"> 
                        <v-chip
                          class="mr-2"
                          color="success"
                          outlined
                          small
                        >
                          <strong>{{alphabet[multiDataIndex-1]}}</strong>
                        </v-chip>
                        <p class="mb-0 text-wrap"> {{multiData.text}}</p>
                      </div>
                      <AttachItemViewer :items="multiData" v-if="checkIfAttachExist(multiData)" />
                    </v-col>
                  </v-row>
                  <!--  qa Datas  -->
                  <v-row v-if="content.type == 'qa'">
                    <v-col cols="12" class="hover-cursor-point">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined small>
                          <strong>问答题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.qaContentDataArr[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.qaContentDataArr[0])">
                      <AttachItemViewer :items="content.qaContentDataArr[0]" />
                    </v-col>
                    
                  </v-row>
                  <!--  statistics Datas  -->
                  <!-- <v-row v-if="content.type == 'stat'">
                    <v-col cols="12">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined small>
                          <strong>统计题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.statDataArr[0].contentData[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.statDataArr[0].contentData[0])">
                      <AttachItemViewer :items="content.statDataArr[0].contentData[0]" />
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                        clearable
                        solo
                        clear-icon="mdi-close-circle"
                        :label="`${content.statDataArr[0].sValue}~${content.statDataArr[0].eValue}`"
                        value=""
                        v-model.number="answerData.statAnswer"
                        hide-details
                      ></v-textarea>
                    </v-col>
                  </v-row> -->
                  <!--  score Datas  -->
                  <v-row v-if="content.type == 'score'">
                    <v-col cols="12">
                      <p class="mb-0 d-flex align-center"> 
                        {{index + 1}}.  
                        <v-chip class="ma-2" color="success" outlined  small>
                          <strong>评分题</strong>
                        </v-chip>
                      </p>
                      <p class="text-wrap pl-3 mb-0">{{ content.scoringDataArr[0].contentData[0].text }}</p>
                    </v-col>
                    <v-col v-if="checkIfAttachExist(content.scoringDataArr[0].contentData[0])">
                      <AttachItemViewer :items="content.scoringDataArr[0].contentData[0]" />
                    </v-col>
                    <v-col cols="12">
                      <div v-for="(minute,i) in parseInt(content.scoringDataArr[0].maxMin)" :key="i" class="op-score">
                          {{minute}}
                      </div>
                    </v-col>
                  </v-row>
              </v-col>
          </v-row>
        </v-container>

        <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-white pa-3 ">
          <v-col cols="12" class="d-flex justify-space-between align-center pa-0">
            <v-btn color="#7879ff" class="submit-mo-post-btn" block dark large @click="submit" :loading="isSubmit"> 确认发布 </v-btn>
          </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';

import { createQuestionnaire } from '~/api/questionnaire';
export default {

    components:{
        AttachItemViewer,
    },

    computed:{
        ...mapGetters({
            previewData: 'mo/previewData'
        }),
    },

    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        alphabet:['A','B','C','D','E','F','G','H','J','K','L','M','N',
                'O','P','Q','R','S','T','U','V','W','X','Y','Z' ],
        isSubmit: false,

    }),

    created(){
        console.log("this.previewData", this.previewData);
        this.previewData.schoolId = this.currentPath.params.schoolId
        this.previewData.classId = this.currentPath.params.lessonId
        if(this.previewData == null){
            return this.$router.go(-1);
        }
    },

    methods:{
        async submit(){
            if(this.previewData.type == 'questionnaire'){
                this.previewData.data.deadline = this.TimeView(this.previewData.data.deadline)
                this.isSubmit = true
                await createQuestionnaire(this.previewData.data).then(res => {
                    this.$store.dispatch('mo/onPreviewData', null);
                    if(this.$isMobile()){
                        this.$router.push({name:'home'})
                    }
                    else{
                        this.$router.push({name:'schoolSpace.news'})
                    }
                }).catch(err=>{
                    console.log(err)
                })
                this.isSubmit = false
            }
        }
    }
}
</script>

<style>

</style>