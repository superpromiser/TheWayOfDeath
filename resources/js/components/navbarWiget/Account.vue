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
      <template v-for="(p, i) in profile">
        <v-divider
          v-if="p.divider"
          :key="`divider-${i}`"
          class="mb-2 mt-2"
        />

        <AppBarItem
          v-else
          :key="`item-${i}`"
          to="#"
        >
          <v-list-item-title v-text="p.title" />
        </AppBarItem>
      </template>
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
}
</script>
