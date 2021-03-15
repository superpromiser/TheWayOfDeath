<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>投票</h2>
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
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        :items="typeItem"
                        item-text="label"
                        item-value="value"
                        v-model="newVoteData.type"
                        label="投票人是否可见结果"
                        hide-details
                    ></v-select>
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
                <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    >
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="votingResult.deadline"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            solo
                            v-model="votingResult.deadline"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            hide-details
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="votingResult.deadline"
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
                        :items="maxVoteItem"
                        item-text="label"
                        item-value="value"
                        v-model="votingResult.maxVote"
                        label="调查范围"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span> 匿名投票 </span>
                    <v-switch
                        v-model="votingResult.anonyVote"
                        color="primary"
                        value="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
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
        menu: false,
        baseUrl: window.Laravel.base_url,
        typeItem : [
            { 
                label : "投票后可见", 
                value : "投票后可见" 
            },
            { 
                label : "投票前后均可见", 
                value : "投票前后均可见" 
            },
            { 
                label : "投票前后均不可见", 
                value : "投票前后均不可见" 
            },
            
        ],
        maxVoteItem : [
            { 
                label : "1", 
                value : 1 
            },
            { 
                label : "2", 
                value : 2 
            },
            { 
                label : "3", 
                value : 3
            },
            { 
                label : "4", 
                value : 4
            },
            { 
                label : "5", 
                value : 5
            },
            { 
                label : "6", 
                value : 6
            },
            { 
                label : "7", 
                value : 7
            },
            { 
                label : "8", 
                value : 8
            },
            { 
                label : "9", 
                value : 9
            },
            { 
                label : "10", 
                value : 10
            },
            
        ],
        newVoteData : {
            type : ''
        },
        votingResult:{
            vResult:'投票后可见',
            viewList:[],
            postShow:[],
            vScope:'',
            maxVote: null,
            deadline:'',
            anonyVote:true,
            content:{
                votingDataArr:[],
            },
        },
    }),

    computed: {
        ...mapGetters({
            schoolTree : 'schooltree/schoolTree',
        })
    },

    methods: {
        selectedLesson(val){
            console.log(val)
        },  
    }
}
</script>

<style>

</style>