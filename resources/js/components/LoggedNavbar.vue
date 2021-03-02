<template>
  <v-app-bar
    color="blue accent-2"
    height="70" 
    app
    >
    <v-app-bar-nav-icon
      class="hidden-md-and-up"
      @click="drawer = !drawer"
    />

    <DrawerToggle class="hidden-sm-and-down" />

    <v-toolbar-title class="d-flex align-center pl-4">
      <img :src="`${baseUrl}/asset/img/logo.png`" alt="Logo" class="logo-img">
    </v-toolbar-title>

    <v-spacer />

    <DefaultSearch class="hidden-sm-and-down" />

    <DefaultNotifications />

    <DefaultAccount />

  </v-app-bar>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'
import DrawerToggle from './navbarWiget/DrawerToggle'
import DefaultSearch from './navbarWiget/Search'
import DefaultNotifications from './navbarWiget/Notifications'
import DefaultAccount from './navbarWiget//Account'

export default {
  components: {
    LocaleDropdown,
    DrawerToggle,
    DefaultSearch,
    DefaultNotifications,
    DefaultAccount
  },

  data: () => ({
    appName: window.config.appName,
    baseUrl: window.base_url,
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
