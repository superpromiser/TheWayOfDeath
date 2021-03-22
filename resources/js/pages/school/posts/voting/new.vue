<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.voting}}</h2>
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
                @click="publishVotingData"
                :loading="isCreating"
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
                        v-model="votingData.votingType"
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
                        v-model="votingData.viewList"
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
                        :return-value.sync="votingData.deadline"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            solo
                            v-model="votingData.deadline"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            hide-details
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="votingData.deadline"
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
                            @click="$refs.menu.save(votingData.deadline)"
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
                        v-model="votingData.maxVote"
                        label="调查范围"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span> 匿名投票 </span>
                    <v-switch
                        v-model="votingData.anonyVote"
                        color="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
            </v-row>
            <div v-for="index in initialCnt" :key="index" class="mt-3">
                <QuestionItem class="mt-10" :Label="index == 1 ? lang.contentPlaceFirst : lang.contentPlace" :index="index" :ref="index" @contentData="loadContentData"/>
                <v-divider></v-divider>
            </div>
            <v-btn color="primary" text @click="addContent" class="mt-10">
                <v-icon>
                    mdi-plus
                </v-icon>
                {{lang.addOption}}
            </v-btn>
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
        <v-snackbar
        timeout="3000"
        v-model="isSuccessed"
        color="success"
        absolute
        top
        >
        {{lang.successText}}
    </v-snackbar>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {createVoting} from '~/api/voting'
export default {
    components: {
        QuestionItem,
    },

    data: () => ({
        lang,
        menu: false,
        requiredText:false,
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
        initialCnt:4,
        votingData:{
            votingType: '',
            viewList:[],
            deadline:'',
            maxVote: null,
            anonyVote:true,
            content:[]
        },
        isCreating:false,
        isSuccessed:false
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
        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true
                this.votingData.content = []
                return;
            }
            this.votingData.content.push(data);
        },
        addContent(){
            this.initialCnt ++;
        },

        async publishVotingData(){
            for(let index = 1;  index <= this.initialCnt; index++){
                this.$refs[index][0].emitData()
            }
            if(this.votingData.content.length < 4){
                return
            }
            this.isCreating = true
            console.log("votingData", this.votingData);
            await createVoting(this.votingData).then(res=>{
                console.log(res)
                this.isCreating = false
                this.isSuccessed = true
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                console.log(err.response);
                this.isCreating = false
            })
        },
    }
}
</script>

<style>

</style>