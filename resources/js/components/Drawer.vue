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
    <!-------------User Info--------------->
    <v-list-item class="pa-2" color="blue accent-2">
      <v-list-item-avatar>
        <v-avatar
          color="blue accent-3"
          size="40"
          >
          <span class="white--text headline"> {{user? user.name[0] : ''}}</span>
        </v-avatar>
      </v-list-item-avatar>
      <v-list-item-title>{{user? user.name : ''}}</v-list-item-title>
    </v-list-item>
    <!-------------User Info--------------->
    <v-divider></v-divider>
    <!----------------Menu------------------>
    <v-list>
      <v-list-group
        :value="true"
        prepend-icon="mdi-account-circle"
      >
        <template v-slot:activator>
          <v-list-item-title>系统设置</v-list-item-title>
        </template>
          <v-list-item
            link
            to="/admin/userlist"
            v-if="user.role.roleName == 'manager'"
            >
            <v-list-item-title>名单</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-account-group</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/assignRole"
            v-if="user.role.roleName == 'admin'"
            >
            <v-list-item-title>角色</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-account-box-multiple</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/school"
            v-if="user.role.roleName == 'admin'"
            >
            <v-list-item-title>学校</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-school</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/grade"
            v-if="user.role.roleName == 'admin'"
            >
            <v-list-item-title>创建年级</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-medal</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/class"
            v-if="user.role.roleName == 'admin'"
            >
            <v-list-item-title>班级</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-google-classroom</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/stream"
            v-if="user.role.roleName == 'manager'"
            >
            <v-list-item-title>stream</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-view-stream</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/imei"
            v-if="user.role.roleName == 'manager'"
            >
            <v-list-item-title>IMEI管理</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-sd</v-icon>
            </v-list-item-icon>
          </v-list-item>
      </v-list-group>
      <v-list-group
        :value="true"
        prepend-icon="mdi-account-circle"
      >
        <template v-slot:activator>
          <v-list-item-title>系统设置</v-list-item-title>
        </template>
          <v-list-item
            link
            to="/schoolspace/1"
            >
            <v-list-item-title>名单</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-account-group</v-icon>
            </v-list-item-icon>
          </v-list-item>
      </v-list-group>
      <v-list-item>
        <v-list-item-icon>
          <v-icon>mdi-home</v-icon>
        </v-list-item-icon>

        <v-list-item-title>{{lang.home}}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import { mapGetters, } from 'vuex'
import lang from '~/helper/lang.json'
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
  
  mounted() {
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
    baseUrl: window.Laravel.base_url,
    lang,
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
