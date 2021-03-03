<template>
  <v-app>
    <LoggedNavbar /> 
    <Drawer/>
    <v-main>
      <child />
    </v-main>
    <!-- <LoggedFooter /> -->
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
