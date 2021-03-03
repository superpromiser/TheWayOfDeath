<template>
  <v-navigation-drawer
    v-model="drawer"
    :mini-variant.sync="mini"
    src="https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg"
    dark
    width="260"
    @input="changedStatusToggle"
  >
    <v-list-item class="px-2">
      <v-list-item-avatar>
        <v-avatar
          color="blue accent-3"
          size="56"
        ></v-avatar>
        <!-- <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img> -->
      </v-list-item-avatar>

      <v-list-item-title>John Leider</v-list-item-title>

    </v-list-item>

    <v-divider></v-divider>

    <v-list dense>
      <v-list-item
        v-for="item in items"
        :key="item.title"
        link
      >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import { mapGetters, } from 'vuex'
export default {
  name: 'DefaultDrawer',

  components: {
    
  },

  computed: {
    ...mapGetters({
      mini : 'toggledrawer/mini',
      // drawer : 'toggledrawer/drawer'
    }),
    drawer: {
      get() {
        return this.$store.state.toggledrawer.drawer;
      },
      set(value) {
        this.$store.dispatch('toggledrawer/turnDrawer', {
          drawer: value,
        })
      }
    }
    // ...mapActions(['toggledrawer/turnDrawer'])
  },
  
  data: () => ({
    items: [
      { title: 'Home', icon: 'mdi-home-city' },
      { title: 'My Account', icon: 'mdi-account' },
      { title: 'Users', icon: 'mdi-account-group-outline' },
    ],
    // drawer: null
  }),

  methods:{
    changedStatusToggle(val){
      if(val == false){
        this.$store.dispatch('toggledrawer/turnDrawer', {
          drawer: val,
        })
      }
    }
  }
}
</script>

<style lang="sass">
#default-drawer
  .v-list-item
    margin-bottom: 8px

  .v-list-item::before,
  .v-list-item::after
    display: none

  .v-list-group__header__prepend-icon,
  .v-list-item__icon
    margin-top: 12px
    margin-bottom: 12px
    margin-left: 4px

  &.v-navigation-drawer--mini-variant
    .v-list-item
      justify-content: flex-start !important
</style>
