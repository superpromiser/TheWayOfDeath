<template>
  <v-container>
      {{contentData}}
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

    mounted(){
        //console.log(this.contentData)
    }
}
</script>

<style>

</style>