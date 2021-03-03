<template>
  <v-app>
    <LoggedNavbar /> 
    <Drawer/>
    <v-main class="main-bg-pattern d-flex justify-center align-center ">
      <!-- <v-container class="h-out-navbar bg-white">
        <child />
      </v-container> -->
      <v-sheet
          class="h-out-navbar container"
          color="white"
          elevation="8"
        >
        <child />
      </v-sheet>
      <!-- <LoggedFooter /> -->
    </v-main>
  </v-app>
</template>

<script>
import LoggedNavbar from '~/components/LoggedNavbar'
import LoggedFooter from '~/components/LoggedFooter'
import Drawer from '~/components/Drawer'

export default {
  name: 'MainLayout',

  components: {
    LoggedNavbar,
    LoggedFooter,
    Drawer
  }
}
</script>
