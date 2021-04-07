<template>
  <v-container>
      {{lang.noData}}
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
export default {
  middleware:'auth',
  data:() => ({
    lang
  })
}
</script>

<style>

</style>