<template>
  <v-app-bar
  color="white" app
  >
    <v-toolbar-title>
      <img :src="`${baseUrl}/asset/img/logo_original.png`" alt="Logo" class="logo-img">
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn text>
      <v-icon left>
        mdi-apple
      </v-icon> 
      IOS
    </v-btn>
    <v-btn text>
      <v-icon left>
        mdi-android
      </v-icon> 
      Android
    </v-btn>
    <v-btn text>
      <v-icon left>
        mdi-microsoft-windows
      </v-icon> 
      Windows
    </v-btn>
    <v-btn text>
      <v-icon left>
        mdi-apple-finder
      </v-icon> 
      Mac
    </v-btn>
    <v-btn text @click="guestMng">
      <v-icon left>
        mdi-account-arrow-right-outline
      </v-icon> 
      陌生访客管理
    </v-btn>
  </v-app-bar>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName,
    baseUrl:window.Laravel.base_url,
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
    },
    guestMng(){
      this.$router.push({name:'guestRequest'})
    }
  }
}
</script>
