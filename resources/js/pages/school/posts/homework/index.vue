<template>
    <v-container>
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/newIcon/作业.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.homework}}</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                text
                color="primary"
                @click="templateList"
            >
                可用模板 {{tempCnt}}， 草稿 {{draftCnt}}
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
                tile
                dark
                color="#49d29e"
                class="mr-8"
                :loading="isSubmit"
                @click="submit"
            >
                {{lang.submit}}
            </v-btn>
            </template>
        </v-banner>
        <div v-if="showRule == false">
            <v-row class="mt-1 align-center">
                <v-col cols="6">
                    <p class="">科目</p>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="homeworkData.title"
                        solo
                        label="科目"
                        clearable
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="mt-1 align-center">
                <v-col cols="6">
                    <p class="">类型</p>
                </v-col>
                <v-col cols="6">
                    <v-select
                        :items="homeworkType"
                        label=""
                        item-text="label"
                        item-value="value"
                        solo
                        v-model="homeworkData.type"
                    ></v-select>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="mt-1 align-center hover-cursor-point" @click="setRule">
                <v-col cols="6">
                    <p class="">发布规则</p>
                </v-col>
                <v-col cols="6" class="text-right">
                    <span>即使发布</span>
                    <v-icon
                        right  
                    >
                        mdi-chevron-right
                    </v-icon>
                        
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <QuestionItem :Label="lang.contentPlaceFirst" :emoji="true" :contact="true"  ref="child" @contentData="loadContentData"></QuestionItem>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
        <v-snackbar
            timeout="3000"
            v-model="isSuccessed"
            color="error"
            absolute
            top
            >
            {{lang.successText}}
        </v-snackbar>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {getHomeworkData,createHomeworkData} from '~/api/homework'
export default {
    components:{
        QuestionItem,
    },
    data:()=>({
        lang,
        isSubmit:false,
        isDraft:false,
        tempCnt:0,
        draftCnt:0,
        baseUrl:window.Laravel.base_url,
        homeworkData:{
            title:'',
            type:'offline',
            content:null,
            deadline:'',
            monitorName:'',
            parentCheck:false,
        },
        homeworkType:[
            {
                label:'分为常规作业',
                value:'offline'
            },
            {
                label:'在线作业',
                value:'online'
            },
            {
                label:'在线测试',
                value:'test'
            }
        ],
        showRule:false
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name == 'posts.homework'){
                    this.showRule = false
                }
                if(val.query.rule){
                    this.homeworkData = val.query.rule
                    console.log(this.homeworkData)
                }
            },
            deep:true
        }
    },
    created(){
        this.$router.push({name:'posts.homework'})
    },
    methods:{
        submit(){
            console.log("submit")
            this.$refs.child.emitData()
            if(this.homeworkData.content == null){
                return
            }
            if(this.homeworkData.title == ''){
                return
            }
            
            console.log("this.homeworkData",this.homeworkData)
        },
        templateList(){
            console.log("go to template list")
        },
        saveDraft(){
            console.log("save draft")
        },
        setRule(){
            this.showRule = true
            console.log('setRule')
            this.$router.push({name:'homework.setRule'});
        },
        loadContentData(data){
            console.log(data)
            if(data.text == ''){
                this.homeworkData.content = []
                return
            }
            this.homeworkData.content = data
        }
    }
}
</script>

<style>

</style>