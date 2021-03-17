<template>
  <v-container>

  </v-container>
</template>

<script>
import {EventBus} from '~/helper/event-bus.js';
export default {
    data:()=>({
        contentData:null
    }),

    computed:{
        currentpath(){
            return this.$route;
        }
    },

    mounted(){
        // console.log(this.currentpath)
        // this.contentData = JSON.parse(this.currentpath.query.content);
        // console.log(this.contentData)
        EventBus.$on("clicked-event", Count=> {  
            console.log(`Oh, that's great. It's gotten ${Count} clicks! :)`);  
        });  
    }
}
</script>

<style>

</style>