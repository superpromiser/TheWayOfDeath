<template>
  <v-container>
      {{lang.noData}}
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {getDashboardData} from '~/api/tablet'
export default {
  data:() => ({
    lang
  }),
  created(){
    getDashboardData().then(res=>{
      console.log('getdashboardData',res.data)
    }).catch(err=>{
      console.log(err.response)
    })
  },

}
</script>

<style>

</style>