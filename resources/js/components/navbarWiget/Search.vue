<template>
  <v-text-field
    placeholder="Search"
    class="mr-16"
    color="light-green lighten-3"
    hide-details
    style="max-width: 220px"
  >
    <template
      v-if="$vuetify.breakpoint.mdAndUp"
      v-slot:append-outer
    >
      <v-btn
        class="mt-n2 ml-n2"
        fab
        small
        elevation="2"
        height="35"
        width="35"
      >
        <v-icon>mdi-magnify</v-icon>
      </v-btn>
    </template>
  </v-text-field>
</template>

<script>
  export default {
    name: 'DefaultSearch',
  }
</script>
