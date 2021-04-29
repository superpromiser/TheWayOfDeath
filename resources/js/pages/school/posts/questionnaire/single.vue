<template>
    <v-container v-if="$isMobile()" class="pa-0 h-100 bg-gray-light-dark mb-16 pb-3">
        <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >单选题</p>
            <v-btn @click="addContent" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                {{lang.addOption}}
            </v-btn>
        </v-row>
        <div v-for="index in initialCnt" :key="index">
            <QuestionItem class="mt-2" :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
        </div>
        <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-white pa-3 ">
            <v-col cols="12" class="d-flex justify-space-between align-center pa-0">
                <v-btn color="#7879ff" block dark large @click="addSingleContent"> 确认发布 </v-btn>
            </v-col>
        </v-row>
    </v-container>
    <v-container v-else>
        <div v-if="isNew == true" v-for="index in initialCnt" :key="index" class="mt-3">
            <QuestionItem class="mt-10" :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
            <v-divider></v-divider>
        </div>
        
        <div v-if="isNew == false" v-for="(item, index) in singleData.singleContentDataArr" :key="index" class="mt-3">
            <QuestionItem class="mt-10" :item="item" :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
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
                
                <v-btn large rounded dark color="#7879ff" @click="addSingleContent">{{lang.submit}}</v-btn>
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
        },

    },
    
    data: () =>({
        singleData : {
            type : 'single',
            singleContentDataArr:[],
            index: null,
        },
        initialCnt: 3,
        lang,
        requiredText:false,
        isNew : true,
    }),

    computed:{
        currentPath(){
            return this.$route;
        }
    },
    created(){
        console.log(this.currentPath);
        if(this.currentPath.params.editDataArr !== undefined){
            this.isNew = false;
            this.singleData.singleContentDataArr = this.currentPath.params.editDataArr;
            this.singleData.index = this.currentPath.params.editDataIndex;
            console.log("hey!", this.singleData);
        }
        //console.log(this.type)
        if(this.type == undefined){
            this.$router.push({name:'posts.questionnaire'})
        }
    },
    
    methods:{
        addContent(){
            if(this.isNew == true){
                this.initialCnt ++;
            }
            else if (this.isNew == false){
                let contentData = {
                    imgUrl: [],
                    otherUrl: [],
                    text: '',
                    videoUrl: [],
                }
                this.singleData.singleContentDataArr.push(contentData)
            }
        },
        addSingleContent(){
            if(this.isNew == false){
                let initialLength = this.singleData.singleContentDataArr.length;
                for(let index = 0;  index < initialLength; index++){
                    this.$refs[index][0].emitData()
                }
                this.singleData.singleContentDataArr = this.singleData.singleContentDataArr.splice(0, initialLength );
            }
            else{
                for(let index = 1;  index <= this.initialCnt; index++){
                    this.$refs[index][0].emitData()
                }
            }
            if(this.singleData.singleContentDataArr.length<3){
                return
            }
            // this.$store.dispatch('content/storeSingleData',this.singleContentDataArr)
            //console.log("this.singleData",this.singleData)
            this.$emit('contentData',this.singleData);
            // //console.log(this.currentPath)
            if(this.type == 'post'){
                this.$router.push({name:'posts.questionnaire'});
            }else{
                this.$router.push({name:'questionnaire.templateNew'})
            }
            // this.$router.push({name:this.currentPath.matched[0].name})
        },
        loadContentData(data){
            if(data.text === ''){
                return this.$snackbar.showMessage({content: "标题不能为空", color: "error"})
            }
            this.singleData.singleContentDataArr.push(data);
        }
    }
}
</script>

<style>

</style>