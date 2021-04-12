<template>
  <v-container>
    <v-col cols="12" class="d-flex align-center hover-cursor-point" @click="showDetail">
      <v-avatar class="ma-3 school-card-avatar" tile >
        <v-img :src="`${baseUrl}/asset/img/newIcon/交接班.png`" alt="postItem" ></v-img>
      </v-avatar>
      <div>
        <p class="font-weight-black fs-15 mb-3"> 交接班管理  </p>
        <div class="d-flex align-center">
          <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
          <p class="mb-0 mr-8">{{TimeView(content.created_at)}}</p>
          <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
          <p class="mb-0">{{content.users.name}}</p>
        </div>
      </div>
      <div class="ml-auto">
        <v-menu offset-y >
          <template v-slot:activator="{ attrs, on }">
            <v-btn icon color="primary" v-bind="attrs" v-on="on" >
              <v-icon size="30">mdi-chevron-down </v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item link >
              <v-list-item-title class="px-2">{{lang.toTop}}</v-list-item-title>
            </v-list-item>
            <v-list-item link >
              <v-list-item-title class="px-2" @click="postRemove(content)">{{lang.remove}}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-col>
    <v-col cols="12" class="pl-10 pt-0">
        <div class="d-flex align-center">
            <p class="text-wrap mb-0">
            <strong>姓名:</strong>
            {{content.shift_mng.prevName}}
            </p>
        </div>
        <div class="d-flex align-center">
            <p class="text-wrap mb-0">
            <strong>交接人姓名:</strong>
            {{content.shift_mng.nextName}}
            </p>
        </div>
        <div class="d-flex align-center">
            <p class="text-wrap mb-0">
            <strong>归程队成员:</strong>
            {{TimeViewSam(content.shift_mng.scheduleDate)}}
            </p>
        </div>
        <div class="d-flex align-center">
            <p class="text-wrap mb-0">
            <strong>交接物品:</strong>
            {{content.shift_mng.itemList}}
            </p>
        </div>
    </v-col>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
export default {
    components:{
        AttachItemViewer,
    },

    props:{
        content:{
            type:Object,
            required:true
        }
    },
    data:() => ({
        lang,
        baseUrl:window.Laravel.base_url,
        smsData: {},
    }),
    
    created(){
    },
    methods:{

      showDetail(){
        this.$store.dispatch('content/storePostDetail',this.content)
        this.$router.push({name:'details.sms'});
      },
      
    }

}
</script>

<style>

</style>