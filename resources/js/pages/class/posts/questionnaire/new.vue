<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>问卷</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                text
                color="primary"
            >
                可用模板 0， 草稿 0
            </v-btn>
            <v-btn
                dark
                color="#7879ff"
                class="mr-md-8"
            >
                提交
            </v-btn>
            </template>
        </v-banner>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newQuestionnaireData.title"
                        label="标题"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newQuestionnaireData.description"
                        label="说明"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    >
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="newQuestionnaireData.deadline"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            solo
                            v-model="newQuestionnaireData.deadline"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            hide-details
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="newQuestionnaireData.deadline"
                        no-title
                        scrollable
                        locale="zh-cn"
                        >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                            @click="menu = false"
                        >
                            {{lang.cancel}}
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$refs.menu.save(date)"
                        >
                            {{lang.ok}}
                        </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        multiple
                        chips
                        :menu-props="{ top: false, offsetY: true }"
                        :items="returnSchoolTree(currentPath.params.schoolId)"
                        item-text="lessonName"
                        item-value="lessonId"
                        @change="selectedLesson"
                        label="班级"
                        hide-details
                    ></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span>匿名问卷</span>
                    <v-switch
                        v-model="newQuestionnaireData.questionnaireFlag"
                        color="primary"
                        value="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span>答卷人可见结果</span>
                    <v-switch
                        v-model="newQuestionnaireData.resultFlag"
                        color="primary"
                        value="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span>外部人员可作答</span>
                    <v-switch
                        v-model="newQuestionnaireData.answerFlag"
                        color="primary"
                        value="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
            </v-row>
            <v-row class="d-flex">
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('single')">
                        <v-icon>
                            mdi-plus
                        </v-icon>单选题
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('multi')">
                        <v-icon>
                            mdi-plus
                        </v-icon>多选题
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('question')">
                        <v-icon>
                            mdi-plus
                        </v-icon>问答题
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('stat')">
                        <v-icon>
                            mdi-plus
                        </v-icon>统计题
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="blue accent-3" @click="selContent('scoring')">
                        <v-icon>
                            mdi-plus
                        </v-icon>评分题
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>

import { mapGetters } from 'vuex'
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
export default {
    data: () => ({
        lang,
        baseUrl: window.Laravel.base_url,
        newQuestionnaireData : {
            title:'',
            description:'',
            viewList:[],
            deadline:'',
            questionnaireFlag:true,
            resultFlag:true,
            answerFlag:false,
            type:0,
            content:{
                singleContentDataArr:[],
                multiContentDataArr:[],
                questionAnswerDataArr:[],
                statisticsDataArr:[],
                scoringQuestoinsDataArr:[],
            },
        },
        dialog:false,
        date: new Date().toISOString().substr(0, 10),
        menu: false,
    }),

    components: {
        QuestionItem,
    },

    computed: {
        ...mapGetters({
            singleData:'content/singleData',
            multiData:'content/multiData',
            qaData:'content/qaData',
            statData:'content/statData',
            scoringData:'content/scoringData'
        }),
        currentPath(){
            return this.$route
        }
    },

    mounted(){
        this.newQuestionnaireData.content.singleContentDataArr.push(this.singleData)
        this.newQuestionnaireData.content.multiContentDataArr.push(this.multiData)
        this.newQuestionnaireData.content.questionAnswerDataArr.push(this.qaData)
        this.newQuestionnaireData.content.statisticsDataArr.push(this.statData)
        this.newQuestionnaireData.content.scoringQuestoinsDataArr.push(this.scoringData)
        //console.log(this.newQuestionnaireData.content)
    },

    methods:{
        updateImageFile(imageFile){
            //console.log(imageFile)
        },
        selectedLesson(val){
            //console.log(val)
        },
        selContent(type){
            switch(type){
                case 'single':
                    this.$router.push({name:"questionnaire.single"});
                    break;
                case 'multi':
                    this.$router.push({name:"questionnaire.multi"});
                    break;
                case 'question':
                    this.$router.push({name:"questionnaire.questionAnswer"});
                    break;
                case 'stat':
                    this.$router.push({name:"questionnaire.statistics"});
                    break;
                case 'scoring':
                    this.$router.push({name:"questionnaire.scoring"});
                    break;
                default:
                    break;
            }
        }
        
    }
}
</script>

<style>

</style>