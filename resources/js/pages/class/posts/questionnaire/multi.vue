<template>
<v-container v-if="$isMobile()">
        <div v-for="index in initialCnt" :key="index" class="mt-3">
            <QuestionItem :Label="index == 1 ? lang.contentPlaceFirst : `${lang.contentOptionPlace}${index-1}`" :index="index" :ref="index" @contentData="loadContentData"/>
            <v-divider light class="thick-border"></v-divider>
        </div>
        <v-container>
            <v-row class="my-10 d-flex align-center">
                <v-btn color="#7879ff" text @click="addContent" class="mr-auto mo-glow" >
                    <v-icon>
                        mdi-plus
                    </v-icon>
                    {{lang.addOption}}
                </v-btn>

                <v-btn class="ml-auto mr-3" large rounded dark color="#eb6846" @click="addMultiContent">{{lang.submit}}</v-btn>
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
            if(this.type == 'post'){
                this.$router.push({name:'posts.Cquestionnaire'});
            }else{
                this.$router.push({name:'Cquestionnaire.templateNew'})
            }
        },
        loadContentData(data){
            if(data.text === ''){
                this.multiData.multiContentDataArr = [];
                return this.$snackbar.showMessage({content: "标题不能为空", color: "error"})
            }
            this.multiData.multiContentDataArr.push(data)
        }

    }
}
</script>

<style>

</style>