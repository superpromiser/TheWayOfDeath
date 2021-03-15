<template>
    <v-container>
        <div v-for="index in initialCnt" :key="index" class="mt-3">
            <QuestionItem class="mt-10" :Label="index == 1 ? lang.contentPlaceFirst : lang.contentPlace" :index="index" :ref="'child' + index" @contentData="loadContentData"/>
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
        signleContentDataArr:[],
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
            if(this.signleContentDataArr.length<4){
                return
            }
            // this.$store.dispatch('content/storeSingleData',this.signleContentDataArr)
            this.$emit('contentData',this.signleContentDataArr);
            this.$router.push({name:'posts.questionnaire'});
        },
        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true
                this.signleContentDataArr = []
                return;
            }
            this.signleContentDataArr.push(data);
        }
    }
}
</script>

<style>

</style>