<template>
  <v-container class="h-100 pa-0">
      <v-row class="h-100 ma-0">
          <ChatList />
          <v-col cols="12" sm="12" md="9" class="h-100 bg-light-yellow" ></v-col>
      </v-row>
  </v-container>
</template>

<script>
import ChatList from './chatlist'
export default {
    components:{
        ChatList,
    }
}
</script>

<style>

</style>