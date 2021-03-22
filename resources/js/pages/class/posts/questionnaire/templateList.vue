<template>
    <v-container>
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
</template>

<script>
import {getQuestionnaireTemp} from '~/api/questionnaire'
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        templateList:[],
        isLoading:false,
        lang,
    }),

    async created(){
        this.isLoading = true;
        await getQuestionnaireTemp().then(res=>{
            console.log(res.data)
            this.isLoading = false
            this.templateList = res.data
        }).catch(err=>{
            this.isLoading = false
            console.log(err.response)
        })
    },

    methods:{
        submit(){
            this.$router.push({name:'classQuestionnaire.templateNew'})
        },
        selTemp(content){
            // console.log(content)
            this.$router.push({name:'classposts.questionnaire',query:{'tempData':content}})
        }
    }
}
</script>

<style>

</style>