<template>
    <v-container>
        <v-container v-if="istemplateNew == true">
            <div v-if='templateList.length == 0'>
                {{lang.noData}}
            </div>
            <div v-for="template in templateList" :key="template.id" v-else>
                <div @click="selTemp(template.content)">
                    {{template}}
                </div>
            </div>
            <v-btn
                dark
                color="green lighten-1"
                class="mr-8"
                @click="submit"
            >
                {{lang.submit}}
            </v-btn>
        </v-container>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-container>
</template>

<script>
import {getQuestionnaireTemp} from '~/api/questionnaire'
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        templateList:[],
        isLoading:false,
        lang,
        istemplateNew:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        this.isLoading = true;
        if(this.currentPath.name == 'questionnaire.templateList'){
            this.istemplateNew = true
        }
        await getQuestionnaireTemp().then(res=>{
            //console.log(res.data)
            this.isLoading = false
            this.templateList = res.data
        }).catch(err=>{
            this.isLoading = false
            //console.log(err.response)
        })
    },

    watch:{
        currentPath:{
            handler(val){
                if(val.name=="questionnaire.templateList"){
                    this.istemplateNew = true
                }
            },
            deep:true
        }
    },
    methods:{
        submit(){
            this.istemplateNew = false
            this.$router.push({name:'questionnaire.templateNew'})
        },
        selTemp(content){
            // //console.log(content)
            this.$router.push({name:'posts.questionnaire',query:{'tempData':content}})
        }
    }
}
</script>

<style>

</style>