<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.questionnaire}}</h2>
            </div>
            <template v-slot:actions>
                <v-btn
                    dark
                    color="green lighten-1"
                    class="mr-8"
                    tile
                    @click="saveDraft"
                >
                    已答
                    <v-icon right>
                        mdi-chevron-right
                    </v-icon>
                </v-btn>
            </template>
        </v-banner>
        <!----title---->
        <v-row class="ma-0 px-5 px-md-10">
            <v-col cols="12" class="d-flex justify-center align-center">
                <h2>{{contentData.questionnaires.title}}</h2>
            </v-col>
            <v-col cols="12">
                <p>{{contentData.questionnaires.desc}}</p>
            </v-col>
        </v-row>
        <!----questionnaires---->
        <v-row class="ma-0 px-5 px-md-10">
            <v-col cols="12" v-for="(content, index) in contentData.questionnaires.content" :key="index">
                <!--  single Datas  -->
                <v-row v-if="content.type == 'single'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>单选题</strong>
                      </v-chip>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ content.singleContentDataArr[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(content.singleContentDataArr[0])">
                    <AttachItemViewer :items="content.singleContentDataArr[0]" />
                  </v-col>
                  <v-col class="pl-6" cols="12" v-for="(singleData, singleDataIndex) in content.singleContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                    <div class="d-flex align-center"> 
                      <v-chip
                        class="mr-2"
                        color="success"
                        outlined
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
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>多选题</strong>
                      </v-chip>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ content.multiContentDataArr[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(content.multiContentDataArr[0])">
                    <AttachItemViewer :items="content.multiContentDataArr[0]" />
                  </v-col>
                  <v-col class="pl-6" cols="12" v-for="(multiData, singleDataIndex) in content.multiContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                    <div class="d-flex align-center"> 
                      <v-chip
                        class="mr-2"
                        color="success"
                        outlined
                      >
                        <strong>{{alphabet[singleDataIndex-1]}}</strong>
                      </v-chip>
                      <p class="mb-0 text-wrap"> {{multiData.text}}</p>
                    </div>
                    <AttachItemViewer :items="multiData" v-if="checkIfAttachExist(multiData)" />
                  </v-col>
                </v-row>
                <!--  qa Datas  -->
                <v-row v-if="content.type == 'qa'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
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
                <v-row v-if="content.type == 'stat'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>统计题</strong>
                      </v-chip>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ content.statDataArr[0].contentData[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(content.statDataArr[0].contentData[0])">
                    <AttachItemViewer :items="content.statDataArr[0].contentData[0]" />
                  </v-col>
                </v-row>
                <!--  score Datas  -->
                <v-row v-if="content.type == 'score'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>评分题</strong>
                      </v-chip>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ content.scoringDataArr[0].contentData[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(content.scoringDataArr[0].contentData[0])">
                    <AttachItemViewer :items="content.scoringDataArr[0].contentData[0]" />
                  </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
export default {
    components:{
        AttachItemViewer,
    },

    data:()=>({
        baseUrl:window.Laravel.base_url,
        lang,
        alphabet:['A','B','C','D','E','F','G','H','J','K','L','M','N',
                'O','P','Q','R','S','T','U','V','W','X','Y','Z' ],
    }),

    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail'
        })
    },

    mounted(){
        console.log("this.currentpath",this.currentpath)
        console.log("this.contentData",this.contentData)
        this.contentData.questionnaires.content = JSON.parse(this.contentData.questionnaires.content);
    },

    methods:{
        checkIfAttachExist(data){
            let count = 0;
            count = count + data.imgUrl.length + data.videoUrl.length + data.otherUrl.length;
            if( count == 0 ) {
                return false;
            }
            else{
                return true;
            }
        },
    }
}
</script>

<style>

</style>