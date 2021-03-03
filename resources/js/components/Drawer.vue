<template>
  <v-navigation-drawer
    v-model="drawer"
    dark
    width="260"
    @input="changedStatusToggle"
    app
    :permanent="!$vuetify.breakpoint.smAndDown"
  > 
    <template v-slot:prepend>
      <v-toolbar
        color="blue"
        height="74"
        >
        <v-toolbar-title class="d-flex align-center pl-4">
          <img :src="`${baseUrl}/asset/img/logo.png`" alt="Logo" class="logo-img">
        </v-toolbar-title>

        <v-spacer></v-spacer>

      </v-toolbar>
    </template>
    <!-- <v-list-item class="pa-2" color="blue accent-2">
      <v-list-item-avatar>
        <v-avatar
          color="blue accent-3"
          size="90"
          >
          <span class="white--text headline"> {{user.name[0]}}</span>
        </v-avatar>
        <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
      </v-list-item-avatar>

      <v-list-item-title>{{user.name}}</v-list-item-title>

    </v-list-item> -->

    <v-divider></v-divider>
    
      <v-list>
        <v-list-item>
          <v-list-item-icon>
            <v-icon>mdi-home</v-icon>
          </v-list-item-icon>

          <v-list-item-title>Home</v-list-item-title>
        </v-list-item>

        <v-list-group
          :value="true"
          prepend-icon="mdi-account-circle"
          
        >
          <template v-slot:activator>
            <v-list-item-title>Users</v-list-item-title>
          </template>

          <v-list-group
            :value="true"
            no-action
            sub-group
            class="py-1"
          >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title>Admin</v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item
              v-for="([title, icon], i) in admins"
              :key="i"
              link
            >
              <v-list-item-title v-text="title"></v-list-item-title>

              <v-list-item-icon>
                <v-icon v-text="icon"></v-icon>
              </v-list-item-icon>
            </v-list-item>
          </v-list-group>

          <v-list-group
            no-action
            sub-group
            class="py-1"
          >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title>Actions</v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item
              v-for="([title, icon], i) in cruds"
              :key="i"
              link
            >
              <v-list-item-title v-text="title"></v-list-item-title>

              <v-list-item-icon>
                <v-icon v-text="icon"></v-icon>
              </v-list-item-icon>
            </v-list-item>
          </v-list-group>
        </v-list-group>
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
      user : 'auth/user'
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
    admins: [
        ['Management', 'mdi-account-multiple-outline'],
        ['Settings', 'mdi-cog-outline'],
      ],
    cruds: [
      ['Create', 'mdi-plus-outline'],
      ['Read', 'mdi-file-outline'],
      ['Update', 'mdi-update'],
      ['Delete', 'mdi-delete'],
    ],
    baseUrl: window.base_url,
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
