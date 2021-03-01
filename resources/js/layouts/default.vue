<template>
  <!-- <div class="main-layout">
    <navbar />

    <div class="container mt-4">
      <child />
    </div>
  </div> -->
  <v-app>
    <v-app-bar app></v-app-bar>

    <v-main>
      Hello World
    </v-main>
  </v-app>
</template>

<script>
import Navbar from '~/components/Navbar'

export default {
  name: 'MainLayout',

  components: {
    Navbar
  }
}
</script>
