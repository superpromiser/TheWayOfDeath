<template>
  <v-container>
      {{lang.noData}}
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {getDashboardData} from '~/api/tablet'
import {mapGetters} from 'vuex'
export default {
  data:() => ({
    lang
  }),
  computed:{
    ...mapGetters({
      user:'auth/user'
    })
  },
  created(){
    
    
  },

}
</script>

<style>

</style>