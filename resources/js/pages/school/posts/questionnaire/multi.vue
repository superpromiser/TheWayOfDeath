<template>
    <v-container v-if="$isMobile()" class="pa-0 h-100 bg-gray-light-dark mb-16 pb-3 pt-12">
        <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >多选题</p>
            <v-btn @click="addContent" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                {{lang.addOption}}
            </v-btn>
        </v-row>
        <div v-for="index in initialCnt" :key="index">
            <QuestionItem class="mt-2" :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
        </div>
        <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-white pa-3 ">
            <v-col cols="12" class="d-flex justify-space-between align-center pa-0">
                <v-btn color="#7879ff" block dark large @click="addMultiContent"> 确认发布 </v-btn>
            </v-col>
        </v-row>
    </v-container>
    <v-container v-else>
        <div v-for="index in initialCnt" :key="index" class="mt-3">
            <QuestionItem class="mt-10" :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
            <v-divider></v-divider>
        </div>
        <v-container>
            <v-row class="my-10 d-flex align-center">
                <v-btn color="primary" text @click="addContent" class="mr-5" >
                    <v-icon>
                        mdi-plus
                    </v-icon>
                    {{lang.addOption}}
                </v-btn>
                
                <v-btn large rounded dark color="#7879ff" @click="addMultiContent">{{lang.submit}}</v-btn>
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
    </v-container>
</template>

<script>
import QuestionItem from '~/components/questionItem';
import { Fragment } from 'vue-fragment';
import lang from '~/helper/lang.json';
export default {
    components:{
        QuestionItem,
        Fragment,
    },
    props:{
        type:{
            type:String,
            requireed:false
        }
    },

    created(){
        //console.log('----------------------',this.type)
        if(this.type == undefined){
            this.$router.push({name:'posts.questionnaire'})
        }
    },

    data: () =>({
        multiData : {
            type : 'multi',
            multiContentDataArr:[],
        },
        initialCnt:4,
        lang,
        requiredText:false,
    }),
    
    computed:{
        currentPath(){
            return this.$route
        }
    },
    
    methods:{
        addContent(){
            this.initialCnt ++;
        },
        addMultiContent(){
            for(let index = 1;  index <= this.initialCnt; index++){
                this.$refs[index][0].emitData()
            }
            if(this.multiData.multiContentDataArr.length<4){
                return
            }
            
            this.$emit('contentData',this.multiData);
            if(this.type == 'post'){
                this.$router.push({name:'posts.questionnaire'});
            }else{
                this.$router.push({name:'questionnaire.templateNew'})
            }
        },
        loadContentData(data){
            if(data.text === ''){
                return this.$snackbar.showMessage({content: "标题不能为空", color: "error"})
            }
            this.multiData.multiContentDataArr.push(data)
        }

    }
}
</script>

<style>

</style>