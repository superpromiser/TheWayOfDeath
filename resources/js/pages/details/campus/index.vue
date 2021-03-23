<template>
  <v-container>
      <v-container>
          campus
          {{contentData}}
      </v-container>
  </v-container>
</template>

<script>
import EventBus from '~/helper/event-bus';
import {mapGetters} from 'vuex';
export default {
    data:()=>({
        // contentData:null
    }),

    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail'
        })
    },
    created(){
        if(this.contentData == null){
            this.$router.push({name:"schoolSpace.news"})
        }
    },
    mounted(){
        console.log(this.contentData)
    }
}
</script>

<style>

</style>