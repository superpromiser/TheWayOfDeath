<template>
  <v-container class="text-center">
    <h1 class="my-4 primary--text">
      Page Not Found 🤷‍♂️
    </h1>
    <img :src="`${baseUrl}/asset/img/404Gif.gif`" alt="404" class="">

    <div class="links">
      <router-link :to="{ name: 'welcome' }">
        <v-btn
          class="ma-2"
          color="light-green darken-1"
          dark
        >
          Go Home
        </v-btn>
      </router-link>
    </div>
  </v-container >
</template>

<script>
export default {
  name: 'NotFound',
  data: () => ({
    baseUrl:window.Laravel.base_url,
  }),
}
</script>
