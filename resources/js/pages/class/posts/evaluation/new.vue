<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/评价.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.evaluation}}</h2>
            </div>
            <template v-slot:actions>
                <v-btn
                    dark
                    color="green lighten-1"
                    @click="publishVotingData"
                    :loading="isCreating"
                    tile
                    class="mr-6"
                >
                    {{lang.submit}}
                </v-btn>
            </template>
        </v-banner>
        <v-container class="px-10">
            <v-row class="bg-light-yellow">
                <v-col cols="12" md="4" lg="4" class="fixed-height-out-contact border-type-1">
                    <v-list shaped class="bg-light-yellow">
                        <v-list-item-group
                            v-model="contactInfo"
                            multiple
                        >
                            <template v-for="(item, i) in contactInfoItems">
                            <v-divider
                                v-if="!item"
                                :key="`divider-${i}`"
                            ></v-divider>

                            <v-list-item
                                v-else
                                :key="`item-${i}`"
                                :value="item"
                                active-class="deep-purple--text text--accent-4"
                            >
                                <template v-slot:default="{ active }">
                                <v-list-item-content>
                                    <v-list-item-title v-text="item"></v-list-item-title>
                                </v-list-item-content>

                                <v-list-item-action>
                                    <v-checkbox
                                    :input-value="active"
                                    color="deep-purple accent-4"
                                    ></v-checkbox>
                                </v-list-item-action>
                                </template>
                            </v-list-item>
                            </template>
                        </v-list-item-group>
                    </v-list>
                </v-col>
                <v-col cols="12" md="8" lg="8" class="fixed-height-out-contact border-type-2">
                    <v-row v-for="(medalGroup, i) in medalData.medal" :key="i" class="pa-3">
                        <v-col cols="12">
                            <v-chip
                                class="ma-2"
                                color="primary"
                                outlined
                                pill
                                >
                                {{medalGroup.type}}
                                <v-icon right>
                                    mdi-medal-outline 
                                </v-icon>
                            </v-chip>
                        </v-col>
                        <v-col cols="6" sm="4" md="4" lg="3" class="d-flex justify-center" v-for="(medalItem, j) in medalGroup.menuList" :key="j">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <div class="medal-item" v-bind="attrs" v-on="on" @click="selectMedalItem(medalItem)">
                                        <div class="score-inline-score">
                                            <img src="data:image/png;base64,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" alt="">
                                            <span class="score-text">+{{medalItem.medalPoint}}分</span>
                                        </div>
                                        <img :src="`${baseUrl}/asset/img/icon/medal_empty.png`" :style="medalItem.medalImg" alt="" class="md-logo">
                                        <div class="medal-word-bg"></div>
                                        <div class="medal-content">
                                            <span class="medal-name">{{medalItem.medalText}}</span>
                                        </div>
                                        <v-icon v-if="medalItem.medalFlag == true" size="30" color="deep-purple accent-4" class="position-absolute" style="top: 10px; left:10px">
                                            mdi-check-decagram
                                        </v-icon>
                                    </div>
                                </template>
                                <span style="width: 100px"> {{medalItem.medalContent}}</span>
                            </v-tooltip>
                        </v-col>
                    </v-row>
                </v-col>
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
import { mapGetters } from 'vuex';
import lang from '~/helper/lang.json';
import QuestionItem from '~/components/questionItem';
import {createEvaluation} from '~/api/evaluation';
import medalData from '~/helper/medal.json';

export default {
    components: {
        QuestionItem,
    },

    data: () => ({
        lang,
        medalData,
        menu: false,
        requiredText:false,
        baseUrl: window.Laravel.base_url,
        contactInfo: [],
        contactInfoItems: [
            'Dog Photos',
            'Cat Photos',
            '',
            'Potatoes',
            'Carrots',
        ],
        initialCnt:4,
        selMedalList : [],
        isCreating:false,
        isSuccessed:false
    }),

    computed: {
        ...mapGetters({
            schoolTree : 'schooltree/schoolTree',
        }),
        currentPath(){
            return this.$route;
        }
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
            let answerData = {
                userList:[],
                selMedalList:[],
                classId:null
                // viewList:[],
                // postShow:[],
            }
            if(this.contactInfo.length == 0 || this.selMedalList.length == 0){
                return;
            }
            answerData.userList = this.contactInfo;
            answerData.selMedalList = this.selMedalList;
            answerData.classId = this.currentPath.params.lessonId;
            this.isCreating = true;
            console.log(answerData);
            await createEvaluation(answerData).then(res=>{
                console.log(res.data)
                this.isCreating = false
                this.$router.push({name:'classSpace.news'})
            }).catch(err=>{
                console.log(err.response)
                this.isCreating = false
            })
            
            // this.isCreating = true
            
        },
        selectMedalItem(medalItem){
            medalItem.medalFlag = ! medalItem.medalFlag
            this.selMedalList = [];
            for(let i=0;i<this.medalData.medal.length;i++){
                for(let j=0;j<this.medalData.medal[i].menuList.length;j++){
                    if(this.medalData.medal[i].menuList[j].medalFlag == true){
                        this.selMedalList.push(this.medalData.medal[i].menuList[j])
                    }
                }
            }
        }
    }
}
</script>

<style>

</style>