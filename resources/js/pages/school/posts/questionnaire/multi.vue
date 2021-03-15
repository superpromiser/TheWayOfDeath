<template>
    <div>
        <div v-for="index in initialCnt" :key="index" class="mt-3">
            <QuestionItem :Label="lang.contentPlace" :index="index" :ref="index" @contentData="loadContentData"/>
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
        <v-snackbar
            timeout="3000"
            v-model="requiredText"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
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
        multiData : {
            type : 'multi',
            multiContentDataArr:[],
        },
        initialCnt:4,
        lang,
        requiredText:false,
    }),
    
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
            this.$router.push({name:'posts.questionnaire'});
        },
        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true;
                this.multiData.multiContentDataArr = [];
                return;
            }
            this.multiData.multiContentDataArr.push(data)
        }

    }
}
</script>

<style>

</style>