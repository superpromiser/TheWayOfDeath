<template>
    <v-container>
        <v-row>
            <v-col cols="12" >
                <v-banner class="pl-0-banner mb-10">
                    <div class="d-flex align-center">
                        <v-avatar
                            class="ma-3 ml-0"
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
                        color="green lighten-1"
                    >
                        提交
                    </v-btn>
                    </template>
                </v-banner>
            </v-col>
        </v-row>
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
                    label="说明（选填）"
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
                    :items="schoolTree"
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
                <v-btn block dark large color="blue accent-3">
                    <v-icon>
                        mdi-plus
                    </v-icon>单选题
                </v-btn>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-btn block dark large color="blue accent-3">
                    <v-icon>
                        mdi-plus
                    </v-icon>多选题
                </v-btn>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-btn block dark large color="blue accent-3">
                    <v-icon>
                        mdi-plus
                    </v-icon>问答题
                </v-btn>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-btn block dark large color="blue accent-3">
                    <v-icon>
                        mdi-plus
                    </v-icon>统计题
                </v-btn>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-btn block dark large color="blue accent-3">
                    <v-icon>
                        mdi-plus
                    </v-icon>评分题
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <QuestionItem Label="something"/>
        </v-row>
        <v-dialog
        v-model="dialog"
        max-width="290"
        >
            <span>test</span>
        </v-dialog>
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
            // chooseableSchoolTree : 'schooltree/chooseableSchoolTree'
            schoolTree : 'schooltree/schoolTree'
        })
    },


    methods:{
        updateImageFile(imageFile){
            console.log(imageFile)
        },
        selectedLesson(val){
            console.log(val)
        }
        
    }
}
</script>

<style>

</style>