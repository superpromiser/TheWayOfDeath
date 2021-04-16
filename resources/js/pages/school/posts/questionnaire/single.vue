<template>
    <v-container v-if="$isMobile()">
        <div v-for="index in initialCnt" :key="index" class="mt-3">
            <QuestionItem class="mt-3" :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
            <v-divider light class="thick-border"></v-divider>
        </div>
        <v-container>
            <v-row class="my-10 d-flex align-center ">
                <v-btn color="#49d29e" text @click="addContent" class="mr-auto mo-glow" >
                    <v-icon>
                        mdi-plus
                    </v-icon>
                    {{lang.addOption}}
                </v-btn>
                
                <v-btn class="ml-auto mr-3" large rounded dark color="#eb6846" @click="addSingleContent">{{lang.submit}}</v-btn>
                <v-btn fab class="mo-glow " style="color:#eb6846" @click="$router.go(-1)"><v-icon>mdi-undo-variant</v-icon></v-btn>
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
                
                <v-btn large rounded dark color="#49d29e" @click="addSingleContent">{{lang.submit}}</v-btn>
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