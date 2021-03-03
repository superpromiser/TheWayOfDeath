<template>
  <transition name="page" mode="out-in">
    <slot>
      <router-view />
    </slot>
  </transition>
  <!-- <v-main name="page" mode="out-in">
    <v-container fluid>
      <router-view />
    </v-container>
  </v-main> -->
</template>

<script>
export default {
  name: 'Child'
}
</script>
