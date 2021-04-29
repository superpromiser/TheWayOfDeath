<template>

</template>

<script>
import lang from '~/helper/lang.json'
export default {
    props:{
        content:{
            type:Object,
            required:true
        }
    },
    data:() => ({
        lang,
        baseUrl:window.Laravel.base_url,
    }),
    created(){
        console.log(this.content)
    },

    computed:{
      currentPath(){
        return this.$route
      }
    },
}
</script>

<style>

</style>