<template>
  <v-menu
    bottom
    left
    min-width="200"
    offset-y
    origin="top right"
    transition="scale-transition"
  >
    <template v-slot:activator="{ attrs, on }">
      <v-btn
        class="ml-2"
        min-width="0"
        text
        v-bind="attrs"
        v-on="on"
      >
        <v-icon color="white">mdi-account</v-icon>
      </v-btn>
    </template>

    <v-list
      :tile="false"
      flat
      nav
    >
      <AppBarItem
        to="#"
      >
        <v-list-item-title>Profile</v-list-item-title>
      </AppBarItem>
      <AppBarItem
        to="#"
      >
        <v-list-item-title>Settings</v-list-item-title>
      </AppBarItem>
      <v-divider
        class="mb-2 mt-2"
      />
      <AppBarItem
        
      >
        <v-list-item-title @click="logout">Log out</v-list-item-title>
      </AppBarItem>
    </v-list>
  </v-menu>
</template>

<script>
import AppBarItem from '../app/BarItem'
export default {
  name: 'DefaultAccount',

  components : {
    AppBarItem,
  },

  data: () => ({
    profile: [
      { title: 'Profile' },
      { title: 'Settings' },
      { divider: true },
      { title: 'Log out' },
    ],
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')
      // Redirect to login.
      this.$router.push({ name: 'welcome' })
    },
  }
}
</script>
