<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/appIcon/基础沟通/投票.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.voting}}</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow mt-5">
            <v-col cols="12" sm="6" md="4">
                <v-select
                    class="mo-glow-v-select mt-0 pt-0"
                    color="#7879ff"
                    :items="typeItem"
                    :menu-props="{ top: false, offsetY: true }"
                    item-text="label"
                    item-value="value"
                    v-model="votingData.votingType"
                    label="投票人是否可见结果"
                    hide-details
                ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-select
                    class="mo-glow-v-select mt-0 pt-0"
                    color="#7879ff"
                    multiple
                    small-chips
                    :items="returnSchoolTree(currentPath.params.schoolId)"
                    :menu-props="{ top: false, offsetY: true }"
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
                        class="mo-glow-v-text mt-0 pt-0"
                        color="#7878ff"
                        v-model="votingData.deadline"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        label="最后期限"
                        v-bind="attrs"
                        v-on="on"
                        hide-details
                    ></v-text-field>
                    </template>
                    <v-date-picker
                    v-model="votingData.deadline"
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
                        @click="$refs.menu.save(votingData.deadline)"
                    >
                        {{lang.ok}}
                    </v-btn>
                    </v-date-picker>
                </v-menu>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-select
                    class="mo-glow-v-select mt-0 pt-0"
                    color="#7879ff"    
                    :items="maxVoteItem"
                    item-text="label"
                    :menu-props="{ top: false, offsetY: true }"
                    item-value="value"
                    v-model="votingData.maxVote"
                    label="调查范围"
                    hide-details
                ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-between">
                <span class="mo-glow-inverse"> 匿名投票 </span>
                <v-switch
                    v-model="votingData.anonyVote"
                    color="#7879ff"
                    hide-details
                    class="pt-0 mt-0"
                ></v-switch>
            </v-col>
         
            <v-col cols="12" v-for="index in initialCnt" :key="index" class="mt-3">
                <QuestionItem class="" :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
                <v-divider class="thick-border" light></v-divider>
            </v-col>
            
            <v-container>
                <v-row class="my-10 d-flex align-center mx-0">
                    <v-btn color="#49d29e" text @click="addContent" class="mr-auto mo-glow" >
                        <v-icon>
                            mdi-plus
                        </v-icon>
                        {{lang.addOption}}
                    </v-btn>
                </v-row>
            </v-container>
        </v-row>
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
    <quick-menu @clickDraft="something" @clickPublish="publishVotingData" :isPublishing="isCreating"></quick-menu>
    </v-container>
    <v-container class="pa-0" v-else>
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class="left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.voting}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        text
                        color="primary"
                        @click="tempList"
                    >
                        可用模板 0， 草稿 0
                    </v-btn>
                    <v-btn
                        dark
                        tile
                        color="#49d29e"
                        @click="publishVotingData"
                        :loading="isCreating"
                        class="mx-2"
                    >
                        提交
                    </v-btn>
                    <v-btn
                        tile
                        dark
                        color="#F19861"
                        :loading="isDraft"
                        @click="saveDraft"
                    >
                        {{lang.saveDraft}}
                    </v-btn>
                </v-col>
            </v-row>
            <!-- <div class="d-flex align-center w-50 justify-space-between">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <h2>{{lang.voting}}</h2>
            </div> -->
            <!-- <div class="d-flex align-center justify-center">
                <v-btn
                    text
                    color="primary"
                    @click="tempList"
                >
                    可用模板 0， 草稿 0
                </v-btn>
                <v-btn
                    tile
                    dark
                    color="#F19861"
                    class="mx-2"
                    :loading="isDraft"
                    @click="saveDraft"
                >
                    {{lang.saveDraft}}
                </v-btn>
                <v-btn
                    dark
                    tile
                    color="#49d29e"
                    @click="publishVotingData"
                    :loading="isCreating"
                    class="mr-8"
                >
                    提交
                </v-btn>
            </div> -->
        </v-container>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        :items="typeItem"
                        :menu-props="{ top: false, offsetY: true }"
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
                        :items="returnSchoolTree(currentPath.params.schoolId)"
                        :menu-props="{ top: false, offsetY: true }"
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
                            label="最后期限"
                            v-bind="attrs"
                            v-on="on"
                            hide-details
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="votingData.deadline"
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
                        :menu-props="{ top: false, offsetY: true }"
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
import quickMenu from '~/components/quickMenu'
export default {
    middleware:['auth','post'],
    components: {
        QuestionItem,
        quickMenu
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
        ],
        initialCnt:4,
        votingData:{
            votingType: '',
            viewList:[],
            deadline:'',
            maxVote: null,
            anonyVote:true,
            content:[],
            schoolId:null,
        },
        isCreating:false,
        isSuccessed:false,
        isDraft:false,
    }),

    computed: {
        ...mapGetters({
        }),
        currentPath(){
           return this.$route
        }
    },
    created(){
        this.votingData.schoolId = this.currentPath.params.schoolId
    },
    methods: {
        selectedLesson(val){
            //console.log(val)
        },  
        loadContentData(data){
            if(data.text === ''){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            this.votingData.content.push(data);
        },

        tempList(){
            this.$router.push({name:"voting.tempList"});
        },

        addContent(){
            this.initialCnt ++;
            let item = {
                label:this.initialCnt-1,
                value:this.initialCnt-1
            }
            this.maxVoteItem.push(item)
        },

        async publishVotingData(){
            for(let index = 1;  index <= this.initialCnt; index++){
                this.$refs[index][0].emitData()
            }
            if(this.votingData.content.length < 4){
                return
            }

            this.isCreating = true
            //console.log("votingData", this.votingData);
            await createVoting(this.votingData).then(res=>{
                //console.log(res)
                this.isCreating = false
                this.isSuccessed = true
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                //console.log(err.response);
                this.isCreating = false
            })
        },
        saveDraft(){

        },

        something(){

        }
    }
}
</script>

<style>

</style>