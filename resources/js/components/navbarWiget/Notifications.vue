<template>
  <v-menu
    bottom
    left
    offset-y
    origin="top right"
    transition="scale-transition"
  >
    <template v-slot:activator="{ attrs, on }">
      <v-btn
        class="ml-2"
        min-width="0"
        text
        v-bind="attrs"
        v-on="on"
      >
        <v-icon v-if="alarmData == null || alarmData.length == 0" color="white">mdi-bell</v-icon>
        <v-badge
          bordered
          color="red"
          overlap
          v-else
        >
          <template v-slot:badge>
            <span v-if="alarmData.length > 0">{{alarmData.length}}</span>
          </template>

          <v-icon color="white">mdi-bell</v-icon>
        </v-badge>
      </v-btn>
    </template>

    <v-list
      flat
      nav
    > 
      <v-list-item v-if="alarmData == null || alarmData.length == 0">
        通知
      </v-list-item>
      <v-list-item
        v-else
        v-for="(alarm, i) in alarmData"
        :key="i"
        @click="onClickAlarm(alarm)"
        class="nav-v-list-item"
      > 
        <v-list-item-avatar v-if="alarm.type == 'NewGuest'">
          <span>v</span>
        </v-list-item-avatar>
        <v-list-item-content v-if="alarm.type == 'NewGuest'">
          <v-list-item-title>{{ alarm.content.memberName }} 来拜访 {{alarm.content.name}}</v-list-item-title>
        </v-list-item-content>
        <v-list-item-avatar v-if="alarm.type == 'NewReturnTeam'">
          <span>v</span>
        </v-list-item-avatar>
        <v-list-item-content v-if="alarm.type == 'NewReturnTeam'">
          <v-list-item-title>{{ alarm.content.memberName }} 来拜访 {{alarm.content.name}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
import {mapGetters} from 'vuex';
import AppBarItem from '../app/BarItem'
import {getAlarm} from '~/api/alarm'

export default {
  name: 'DefaultNotifications',

  components : {
    AppBarItem
  },

  computed:{
    ...mapGetters({
      alarmData: 'alarm/alarmData',
      user: 'auth/user'
    })
  },

  data: () => ({

  }),

  async created(){
    this.listen()
    if(this.alarmData == null){
      await getAlarm()
      .then((res) => {
        res.data.map(alarm=>{
          alarm.content = JSON.parse(alarm.content);
        })
        this.$store.dispatch('alarm/storeAlarm', res.data);
      }).catch((err) => {
        console.log(err);
      });
    }
  },

  methods:{
    listen(){
      Echo.private('newguest.'+ this.user.id)
        .listen('NewGuest', (alarm) => {
          console.log(alarm)
          alarm.guest.content = JSON.parse(alarm.guest.content);
          this.alarmData.push(alarm.guest);
          this.$store.dispatch('alarm/storeAlarm', this.alarmData);
        });
      Echo.private('newReturnTeam.'+ this.user.id)
        .listen('NewReturnTeam', (alarm) => {
          console.log("!!!!!!!!!",alarm)
          alarm.returnTeam.content = JSON.parse(alarm.returnTeam.content);
          this.alarmData.push(alarm.returnTeam);
          this.$store.dispatch('alarm/storeAlarm', this.alarmData);
        });
    },

    onClickAlarm(alarm){
      console.log(alarm);
      
    }
  }
}
</script>
