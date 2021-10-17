<template>
  <v-container class="px-10 z-index-2 banner-custom">
    <v-row>
      <v-col cols="6" md="4" class="d-flex align-center position-relative">
        <a @click="$router.go(-1)">
          <v-icon size="70" class=" left-24p">
            mdi-chevron-left
          </v-icon>
        </a>
      </v-col>
      <v-col
        cols="6"
        md="4"
        class="d-flex align-center justify-start justify-md-center"
      >
        <h2>{{ title }}</h2>
      </v-col>
      <v-col cols="12" md="4" class="d-flex align-center justify-end"> </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  props: {
    title: String,
    required: true
  }
};
</script>

<style></style>
