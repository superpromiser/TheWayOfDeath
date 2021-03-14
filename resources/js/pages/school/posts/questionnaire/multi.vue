<template>
    <div>
        <div v-for="index in initialCnt" :key="index" class="mt-3">
            <QuestionItem :Label="lang.contentPlace" :index="index"/>
            <div class="divider"></div>
        </div>
        <div class="mt-3" @click="addContent">
            <v-icon>
                mdi-plus
            </v-icon>
            <span >{{lang.addOption}}</span>
        </div>
        <v-row>
            <v-col>
                <v-btn color="primary" @click="addMultiContent">{{lang.submit}}</v-btn>
            </v-col>
        </v-row>
    </div>
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
        multiContentDataArr:[
            {
                text:'test1',
                imgUrl:['test1.jpg','test2.jpg'],
                otherUrl:['test1.pdf','test2.pdf'],
                videoUrl:['test1.mp4','test2.mp4']
            }
        ],
        initialCnt:4,
        lang,
    }),
    
    methods:{
        addContent(){
            this.initialCnt ++;
        },
        addMultiContent(){
            this.$store.dispatch('content/storeMultiData',this.multiContentDataArr)
            this.$router.push({name:'questionnaire.new'});
        }
    }
}
</script>

<style>

</style>