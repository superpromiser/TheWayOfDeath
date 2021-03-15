<template>
    <v-container>
        <div v-for="index in initialCnt" :key="index" class="mt-3">
            <QuestionItem class="mt-10" :Label="index == 1 ? lang.contentPlaceFirst : lang.contentPlace" :index="index" :ref="index" @contentData="loadContentData"/>
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
                
                <v-btn large rounded dark color="green lighten-1" @click="addSingleContent">{{lang.submit}}</v-btn>
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
    data: () =>({
        singleData : {
            type : 'single',
            singleContentDataArr:[],
        },
        initialCnt:4,
        lang,
        requiredText:false
    }),
    methods:{
        addContent(){
            this.initialCnt ++;
        },
        addSingleContent(){
            for(let index = 1;  index <= this.initialCnt; index++){
                this.$refs[index][0].emitData()
            }
            if(this.singleData.singleContentDataArr.length<4){
                return
            }
            // this.$store.dispatch('content/storeSingleData',this.singleContentDataArr)
            this.$emit('contentData',this.singleData);
            this.$router.push({name:'posts.questionnaire'});
        },
        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true
                this.singleData.singleContentDataArr = []
                return;
            }
            this.singleData.singleContentDataArr.push(data);
        }
    }
}
</script>

<style>

</style>