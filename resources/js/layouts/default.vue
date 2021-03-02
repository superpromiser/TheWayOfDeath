<template>
  <v-app>
    <LoggedNavbar /> 
    <v-main>
      <child />
    </v-main>
    <LoggedFooter />
  </v-app>
</template>

<script>
import LoggedNavbar from '~/components/LoggedNavbar'
import LoggedFooter from '~/components/LoggedFooter'

export default {
  name: 'MainLayout',

  components: {
    LoggedNavbar,
    LoggedFooter
  }
}
</script>
