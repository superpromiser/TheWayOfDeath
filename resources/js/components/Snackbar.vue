<template>
  <!-- <v-snackbar v-model="show" :color="color">
    {{ message }}
    <v-btn text @click="show = false">Close</v-btn>
  </v-snackbar> -->
  <v-snackbar
    v-if="$isMobile()"
    timeout="3000"
    v-model="show"
    color="#999999"
    rounded="pill"
    absolute
    dark
    top
    class="z-index-10 position-fixed mo-snackbar"
  >
    {{ message }}
  </v-snackbar>
  <v-snackbar
    v-else
    timeout="3000"
    v-model="show"
    :color="color"
    absolute
    top
    class="z-index-10 position-fixed"
  >
    {{ message }}
    <template v-slot:action="{ attrs }">
      <v-btn v-bind="attrs" icon dark @click="show = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      message: "",
      color: ""
    };
  },

  created() {
    this.$store.subscribe((mutation, state) => {
      if (mutation.type === "snackbar/showMessage") {
        this.message = state.snackbar.content;
        this.color = state.snackbar.color;
        this.show = true;
      }
    });
  }
};
</script>
