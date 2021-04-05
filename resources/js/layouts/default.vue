<template>
  <v-app>
    <LoggedNavbar v-if="!$isMobile()"/> 
    <Drawer v-if="!$isMobile()"/>
    <v-main v-if="!$isMobile()" class="main-bg-pattern d-flex justify-center align-center ">
      <!-- <v-container class="h-out-navbar bg-white">
        <child />
      </v-container> -->
      <v-sheet
          class="h-out-navbar container pa-0"
          color="white"
          elevation="8"
          id="h-out-navbar"
        >
        <child />
      </v-sheet>
      <!-- <LoggedFooter /> -->
    </v-main>
    <v-main v-else class="mo-glow-bg pb-100">
      <child />
    </v-main>
    <MoBottomNav v-if="$isMobile()" />
  </v-app>
</template>

<script>
import MoBottomNav from '~/components/MoBottomNav'
import LoggedNavbar from '~/components/LoggedNavbar'
import LoggedFooter from '~/components/LoggedFooter'
import Drawer from '~/components/Drawer'

export default {
  name: 'MainLayout',

  components: {
    LoggedNavbar,
    LoggedFooter,
    Drawer,
    MoBottomNav
  }
}
</script>
