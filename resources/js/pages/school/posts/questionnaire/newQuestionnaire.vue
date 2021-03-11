<template>
    <v-container>
        <v-row>
            <v-col cols="12" >
                <v-banner>
                    <div class="d-flex align-center">
                        <v-avatar
                            class="ma-3"
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
                    </template>
                </v-banner>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="6" md="4">
                <v-text-field
                    v-model="newQuestionnaireData.title"
                    label="标题"
                ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-text-field
                    v-model="newQuestionnaireData.description"
                    label="说明（选填）"
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
                        v-model="newQuestionnaireData.deadline"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
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
        </v-row>
        <v-row>
            <v-col>
                <v-banner>
                    调查范围
                </v-banner>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="6" md="4">
                <v-banner>
                    匿名问卷
                    <v-switch></v-switch>
                </v-banner>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-banner>
                    答卷人可见结果
                    <v-switch></v-switch>
                </v-banner>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-banner>
                    外部人员可作答
                    <v-switch></v-switch>
                </v-banner>
            </v-col>
        </v-row>
        <v-row>
            <v-banner>
                <span @click="firstContent">单选题</span> 
            </v-banner>
        </v-row>
        <v-row>
            <v-banner>
                <span @click="secondContent">多选题</span> 
            </v-banner>
        </v-row>
        <v-row>
            <v-banner>
               <span @click="thirdContent">问答题</span> 
            </v-banner>
        </v-row>
        <v-row>
            <v-banner>
               <span @click="forthContent">统计题</span> 
            </v-banner>
        </v-row>
        <v-row>
            <v-banner>
               <span @click="fifthContent">评分题</span> 
            </v-banner>
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
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
        date: new Date().toISOString().substr(0, 10),
        menu: false,
    }),
    methods:{
        firstContent(){
            console.log('firstContent')
        },

        secondContent(){
            console.log('secondContent')
        },

        thirdContent(){
            console.log('thirdContent')
        },

        forthContent(){
            console.log('forthContent')
        },

        fifthContent(){
            console.log('fifthContent')
        }
    }
}
</script>

<style>

</style>