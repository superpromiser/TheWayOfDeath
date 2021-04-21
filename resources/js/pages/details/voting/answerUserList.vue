<template>
    <v-container class="mt-10">
        <v-banner v-for="answer in answerUsers" :key="answer.id">
            {{answer.user.name}}
        </v-banner>
    </v-container>
</template>

<script>
export default {
    props:{
        answerUsers:{
            type:Array,
            required:true
        }
    },
    data:()=>({

    }),
    created(){
        console.log('answeruserlist')
        if(this.answerUsers == null){
            if(this.currentpath.params.lessonId){
                this.$router.push({name:'classSpace.news'})
            }else{
                this.$router.push({name:'schoolSpace.news'})
            }
        }
    }
}
</script>

<style>

</style>