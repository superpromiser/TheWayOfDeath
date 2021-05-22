<template>
    <v-container v-if="$isMobile()" class="ma-0 pa-0 h-100">
        <v-container class="pa-0 h-100 bg-gray-light-dark mb-16 pb-3 pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.voting}}</p>
                <v-btn @click="addContent" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.addOption}}
                </v-btn>
            </v-row>
            <div class="cus-divider"></div>
            <v-row class="ma-0 bg-white">
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
                    <v-datetime-picker 
                        label="截止时间" 
                        v-model="votingData.deadline"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                    > </v-datetime-picker>
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
                        label="每人选择上限"
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
            </v-row>
            <v-row class="ma-0 bg-white mt-2" v-for="index in initialCnt" :key="index">
                <v-col cols="12" class="pa-0" >
                    <QuestionItem :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
                </v-col>
            </v-row>
            <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-white pa-3 ">
                <v-col cols="12" class="d-flex justify-space-between align-center pa-0">
                    <!-- <div class="text-center px-2">
                        <v-icon>mdi-buffer</v-icon>
                        <p class="mb-0 font-color-gray-dark">模板</p>
                    </div> -->
                    <v-btn color="#7879ff" block dark large @click="publishVotingData" :loading="isCreating"> 提交 </v-btn>
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
    <v-container class="pa-0" v-else>
        <div v-if="isPosting == true">
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
                            color="#999999"
                            @click="tempList"
                        >
                            可用模板 {{templateCnt}}， 草稿 {{draftCnt}}
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
                        <v-btn
                            dark
                            tile
                            color="#7879ff"
                            @click="publishVotingData"
                            :loading="isCreating"
                            class="mx-2"
                        >
                            提交
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
                        color="#7879ff"
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
                        color="#7879ff"
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
                        <v-datetime-picker 
                            label="截止时间" 
                            v-model="votingData.deadline"
                            :okText='lang.ok'
                            :clearText='lang.cancel'
                        > </v-datetime-picker>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-select
                            solo
                            :items="maxVoteItem"
                            item-text="label"
                            :menu-props="{ top: false, offsetY: true }"
                            item-value="value"
                            v-model="votingData.maxVote"
                            label="每人选择上限"
                            hide-details
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-around">
                        <span> 匿名投票 </span>
                        <v-switch
                            v-model="votingData.anonyVote"
                            color="#7879ff"
                            hide-details
                            inset
                            class="pt-0 mt-0"
                        ></v-switch>
                    </v-col>
                </v-row>
                <div v-for="index in initialCnt" :key="index" class="mt-3">
                    <QuestionItem class="mt-10" :Label="index == 1 ? lang.contentPlaceFirst : lang.contentPlace" :item="votingData.content[index-1]" :index="index" :ref="index" @contentData="loadContentData"/>
                    <v-divider></v-divider>
                </div>
                <v-btn color="#7879ff" text @click="addContent" class="mt-10">
                    <v-icon>
                        mdi-plus
                    </v-icon>
                    {{lang.addOption}}
                </v-btn>
            </v-container>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {createVoting,getTemplateCnt,createTemplate} from '~/api/voting'
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
        draftCnt:0,
        templateCnt:0,
        isPosting:false
    }),

    computed: {
        // ...mapGetters({
        //     tempData:'content/postTempData'
        // }),
        currentPath(){
           return this.$route
        }
    },
    async created(){
        if(this.currentPath.name == 'posts.voting'){
            this.isPosting = true
        }
        this.votingData.schoolId = this.currentPath.params.schoolId
        await getTemplateCnt({schoolId:this.currentPath.params.schoolId}).then(res=>{
            this.draftCnt = res.data.draftCnt
            this.templateCnt = res.data.templateCnt
        }).catch(err=>{
            console.log(err.response)
        })
    },
   
    watch:{
        currentPath:{
            handler(val){
                if(val.query.tempData){
                    this.isPosting = true
                    this.votingData.content = JSON.parse(val.query.tempData)
                }
            },
            deeper:true
        }
    },
    methods: {
        selectedLesson(val){
            //console.log(val)
        },  
        loadContentData(data){
            if(data.text === ''){
                return this.$snackbar.showMessage({content: this.lang.requireContent, color: "error"})
            }
            this.votingData.content.push(data);
        },

        tempList(){
            this.isPosting = false
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
            console.log(this.votingData)
            
            // return
            let dateNow = new Date();
            if(this.votingData.votingType.trim() == ''){
                this.votingData.content = [];
                return this.$snackbar.showMessage({content: this.lang.requireVotingType, color: "error"})
            }
            if(this.votingData.viewList.length == 0){
                this.votingData.content = [];
                return this.$snackbar.showMessage({content: this.lang.requireMember, color: "error"})
            }
            if(this.votingData.deadline == ""){
                this.votingData.content = [];
                return this.$snackbar.showMessage({content: this.lang.requireDeadline, color: "error"})
            }
            if( dateNow > this.votingData.deadline){
                this.votingData.content = [];
                return this.$snackbar.showMessage({content: this.lang.requireDeadlineOrder, color: "error"})
            }
            if(this.votingData.maxVote == null){
                this.votingData.content = [];
                return this.$snackbar.showMessage({content: this.lang.requireVotingMax, color: "error"})
            }
            if(this.votingData.content.length < 4){
                this.votingData.content = [];
                return this.$snackbar.showMessage({content: this.lang.voting+this.lang.requireContent, color: "error"})
            }

            
            
            this.votingData.deadline = this.TimeView(this.votingData.deadline)
            this.isCreating = true
            // return
            await createVoting(this.votingData).then(res=>{
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
            })
            this.isCreating = false
        },
        async saveDraft(){
            for(let index = 1;  index <= this.initialCnt; index++){
                this.$refs[index][0].emitData()
            }
            if(this.votingData.content.length < 4){
                return this.$snackbar.showMessage({content: this.lang.voting+this.lang.requireContent, color: "error"})
            }
            let draftData = {}
            draftData.tempType = 2
            draftData.content = this.votingData.content
            draftData.schoolId = this.currentPath.params.schoolId
            if(this.currentPath.params.lessonId){
                draftData.lessonId = this.currentPath.params.lessonId
            }
            let currentTime = Date.now();
            draftData.tempTitle = 'title-' + currentTime
            draftData.description = 'description-' + currentTime
            
            this.isDraft = true
            await createTemplate(draftData).then(res=>{
                this.isDraft = false
                this.draftCnt ++ 
            }).catch(err=>{
                console.log(err.response)
                this.isDraft = false
            })
        },

        something(){

        }
    }
}
</script>

<style>

</style>