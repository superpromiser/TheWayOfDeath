<template>
  <v-app>
    <LoggedNavbar v-if="isLogged" />
    <BeforeLogNavbar v-else />
    <v-main class="">
      <child />
    </v-main>
    <LoggedFooter v-if="isLogged" />
    <BeforeLogFooter v-else />
  </v-app>
</template>

<script>
import BeforeLogNavbar from '../components/BeforeLogNavbar'
import LoggedNavbar from '../components/LoggedNavbar'
import BeforeLogFooter from '../components/BeforeLogFooter'
import LoggedFooter from '../components/LoggedFooter'

export default {
  name: 'BasicLayout',
  components: {
    BeforeLogNavbar,
    LoggedNavbar,
    BeforeLogFooter,
    LoggedFooter
  },
  data: () => ({
    isLogged : false,

  }),
}
</script>

