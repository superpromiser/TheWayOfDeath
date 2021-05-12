<template>
  <v-app>
    <LoggedNavbar v-if="!$isMobile()"/> 
    <Drawer v-if="!$isMobile()"/>
    <v-main v-if="!$isMobile()" class="main-bg-pattern d-flex justify-center align-center ">
      <!-- <v-container class="h-out-navbar bg-white">
        <child />
      </v-container> -->
      <v-sheet
          class="h-out-navbar container pa-0"
          color="white"
          elevation="8"
          id="h-out-navbar"
        >
        <child />
      </v-sheet>
      <!-- <LoggedFooter /> -->
    </v-main>
    <v-main v-else class="bg-white">
      <child />
    </v-main>
    <MoBottomNav v-if="$isMobile() && !isPostOrDetail" />
    <Snackbar></Snackbar>
  </v-app>
</template>

<script>
import MoBottomNav from '~/components/MoBottomNav'
import LoggedNavbar from '~/components/LoggedNavbar'
import LoggedFooter from '~/components/LoggedFooter'
import Snackbar from '~/components/Snackbar.vue'
import Drawer from '~/components/Drawer'

export default {
  name: 'MainLayout',

  data: ()=> ({
    isPostOrDetail: false,
  }),

  computed:{
    currentPath(){
      return this.$route
    }
  },

  watch:{
    currentPath:{
      handler(val){
        if ((val.path.includes('post')&&val.path.includes('schoolSpace')) || 
          (val.path.includes('post')&&val.path.includes('classSpace')) || 
          (val.path.includes('detail')&&val.path.includes('schoolSpace')) ||
          (val.path.includes('member')&&val.path.includes('select')) ||
          (val.path.includes('texteditor')) ||
          (val.path.includes('profile')&&val.path.includes('myfile')) ||
          (val.path.includes('chat')&&val.path.includes('mobile')&&val.path.includes('detail')) ||
          (val.path.includes('schoolSpace')&&val.path.includes('application')) ||
          (val.path.includes('classSpace')&&val.path.includes('application'))
          ){
          this.isPostOrDetail = true;
        }
        else{
          this.isPostOrDetail = false;
        }
        
        if(val.name === "home"){
          this.$store.dispatch('mo/onMoBottomNavValue', 0);
          this.$store.dispatch('mo/onMoBottomNavIsNewPost', false);
        }
        else if(val.name=="chatMobile" || val.name=="mochat.news" || val.name=="mochat.detail" || val.name=="mochat.contact"){
          this.$store.dispatch('mo/onMoBottomNavValue', 1);
          this.$store.dispatch('mo/onMoBottomNavIsNewPost', false);
        }
        else if(val.name=="circle"){
          this.$store.dispatch('mo/onMoBottomNavValue', 3);
          this.$store.dispatch('mo/onMoBottomNavIsNewPost', false);
        }
        else if(val.name=="profile.list"){
          this.$store.dispatch('mo/onMoBottomNavValue', 4);
          this.$store.dispatch('mo/onMoBottomNavIsNewPost', false);
        }
        else if(val.name=="mo.newPost"){
          this.$store.dispatch('mo/onMoBottomNavValue', -1);
          this.$store.dispatch('mo/onMoBottomNavIsNewPost', true);
        }
        else{
          this.$store.dispatch('mo/onMoBottomNavValue', null);
          this.$store.dispatch('mo/onMoBottomNavIsNewPost', false);
        }
      },
      deep: true
    }
  },
  
  components: {
    LoggedNavbar,
    LoggedFooter,
    Drawer,
    MoBottomNav,
    Snackbar
  }
}
</script>
