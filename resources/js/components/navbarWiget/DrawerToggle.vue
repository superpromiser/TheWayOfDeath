<template>
  <v-btn
    class="ml-3 mr-4"
    elevation="1"
    fab
    small
    @click="toggleDrawer"
  >
    <v-icon>
      {{ mini ? 'mdi-format-list-bulleted' : 'mdi-dots-vertical' }}
    </v-icon>
  </v-btn>
</template>

<script>
 import { mapGetters } from 'vuex'

  export default {
    name: 'DrawerToggle',

    // computed: {

    //   mini: sync('app/mini'),
    // },
    computed: mapGetters({
      mini: 'toggledrawer/mini'
    }),
    data: () => ({
      
    }),
    methods: {
      toggleDrawer(){
        this.$store.dispatch('toggledrawer/toggleMiniDrawer', {
          mini: !this.mini,
        })
      }
    }
  }
</script>
