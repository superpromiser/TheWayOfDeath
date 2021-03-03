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
          size="90"
        ></v-avatar>
        <!-- <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img> -->
      </v-list-item-avatar>

      <v-list-item-title>John Leider</v-list-item-title>

    </v-list-item>

    <v-divider></v-divider>
    <div class="px-3">
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
          active-class="pink--text primary"
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
              class="py-1"
            >
              <v-list-item-title v-text="title"></v-list-item-title>

              <v-list-item-icon>
                <v-icon v-text="icon"></v-icon>
              </v-list-item-icon>
            </v-list-item>
          </v-list-group>
        </v-list-group>
      </v-list>
    </div>
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
