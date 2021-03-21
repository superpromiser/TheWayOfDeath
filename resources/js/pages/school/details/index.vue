<template>
  <v-container>
      <v-container>

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

    mounted(){
        // console.log(this.contentData)
        console.log('detail index')
    }
}
</script>

<style>

</style>