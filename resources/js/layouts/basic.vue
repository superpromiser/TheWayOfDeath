<template>
  <v-app>
    <BeforeLogNavbar v-if="$isMobile() == false" />
    <v-main class="">
      <child />
    </v-main>
    <BeforeLogFooter v-if="$isMobile() == false"  />
    <Snackbar></Snackbar>
  </v-app>
</template>

<script>
import BeforeLogNavbar from '../components/BeforeLogNavbar'
import LoggedNavbar from '../components/LoggedNavbar'
import BeforeLogFooter from '../components/BeforeLogFooter'
import LoggedFooter from '../components/LoggedFooter'
import Snackbar from '~/components/Snackbar.vue'

export default {
  name: 'BasicLayout',
  components: {
    BeforeLogNavbar,
    LoggedNavbar,
    BeforeLogFooter,
    LoggedFooter,
    Snackbar
  },
  data: () => ({
    isLogged : false,

  }),
}
</script>

