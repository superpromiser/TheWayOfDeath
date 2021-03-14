<template>
    <v-container>
        <div v-for="index in initialCnt" :key="index" class="mt-3">
            <QuestionItem :Label="lang.contentPlace" :index="index" :ref="'child' + index" @contentData="loadContentData"/>
            <v-divider></v-divider>
        </div>
        <div class="mt-3" @click="addContent">
            <v-icon>
                mdi-plus
            </v-icon>
            <span >{{lang.addOption}}</span>
        </div>
        <v-row>
            <v-col>
                <v-btn color="primary" @click="addSingleContent">{{lang.submit}}</v-btn>
            </v-col>
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
        signleContentDataArr:[
        ],
        initialCnt:4,
        lang,
        requiredText:false
    }),
    methods:{
        addContent(){
            this.initialCnt ++;
        },
        addSingleContent(){
            console.log(this.initialCnt)
            for(let index = 1;  index <= this.initialCnt; index++){
                let ref = `child${index}`
                this.$refs[ref][0].emitData()
            }
            this.$store.dispatch('content/storeSingleData',this.signleContentDataArr)
            this.$router.push({name:'questionnaire.new'});
        },
        loadContentData(data){
            console.log(data)
            if(data.text == ''){
                this.requiredText = true;
                return;
            }
            this.signleContentDataArr.push(data);
        }
    }
}
</script>

<style>

</style>