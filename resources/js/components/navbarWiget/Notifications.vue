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
    <v-list-item
        v-if="alarmData.length > 0"
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
        <v-list-item-avatar color="#49d29e" class="rounded-lg" v-if="alarm.type == 'NewReturnTeam'">
          <span>{{alarm.content.name[0]}}</span>
        </v-list-item-avatar>
        <v-list-item-content v-if="alarm.type == 'NewReturnTeam'">
          <v-list-item-title>{{alarm.content.name}} - {{TimeViewYMD(alarm.created_at)}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item v-else>
        通知
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
        console.log(res.data);
        this.$store.dispatch('alarm/storeAlarm', res.data);
        console.log("this.alarmData", this.alarmData)
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
      if(alarm.type == 'NewReturnTeam'){
        this.$router.push({name: 'classSpace.returnTeam', params: {schoolId: this.user.schoolId, gradeId: this.user.gradeId, lessonId: this.user.lessonId}})
      }
    }
  }
}
</script>
