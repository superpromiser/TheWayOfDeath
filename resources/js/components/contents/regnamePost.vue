<template>
  <v-container v-if="$isMobile()">
    <v-row>
      <v-col cols="12" class="d-flex" @click="showDetail">
        <v-avatar v-if="content.users.name !== '' && content.users.avatar == '/'" color="primary" size="48">
            <span class="white--text headline">{{content.users.name[0]}}</span>
        </v-avatar>
        <v-avatar v-else
          size="48"
        >
          <v-img :src="content.users.avatar"></v-img>
        </v-avatar>
        <div class="ml-2 d-flex flex-column">
          <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.regname}}  </p>
          <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(content.created_at)}} 转发</span> {{content.users.name}}</p>
        </div>
      </v-col>
      <v-col cols="12" class="font-size-0-8">
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>标题:</strong>
            {{content.regnames.title}}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>开始时间:</strong>
            {{TimeViewYMD(content.regnames.startTime)}}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>截止时间:</strong>
            {{TimeViewYMD(content.regnames.endTime)}}
          </p>
        </div>
      </v-col>
      <v-col cols="12 py-0">
        <p class="text-wrap mb-0 font-size-0-75"><read-more more-str="全文" :text="regnameData[0].text" link="#" less-str="收起" :max-chars="250"></read-more></p>
      </v-col>
      <v-col cols="12" class="py-0" v-if="checkIfAttachExist(regnameData[0])">
        <AttachItemViewer :items="regnameData[0]" />
      </v-col>
      <v-col cols="12 py-0">
        <v-btn
          rounded
          small
          color="#7879ff"
          outlined
          class="ma-1 ml-0"
          @click="showDetail(content)"
        >
          <v-icon left>
            mdi-eye
          </v-icon>
          {{lang.viewDetail}}
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
  <v-container v-else>
    <v-col cols="12" class="d-flex align-center hover-cursor-point">
      <v-avatar v-if="content.users.name !== '' && content.users.avatar == '/'" color="primary" size="60" class="ma-5">
            <span class="white--text headline">{{content.users.name[0]}}</span>
        </v-avatar>
        <v-avatar v-else
          class="ma-5"
          size="60"
        >
          <v-img :src="content.users.avatar"></v-img>
        </v-avatar>
      <div>
        <p class="font-weight-black fs-15 mb-3"> {{lang.regname}}  </p>
        <div class="d-flex align-center">
          <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
          <p class="mb-0 mr-8">{{TimeView(content.created_at)}}</p>
          <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
          <p class="mb-0">{{content.users.name}}</p>
        </div>
      </div>
      <div class="ml-auto" v-if="user.roleId < 3 || content.users.id == user.id">
        <v-menu offset-y >
          <template v-slot:activator="{ attrs, on }">
            <v-btn icon color="primary" v-bind="attrs" v-on="on" >
              <v-icon size="30">mdi-chevron-down </v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item link  v-if="user.roelId < 3">
              <v-list-item-title class="px-2" @click="fixTop(content)" v-if="content.fixTop == null">{{lang.toTop}}</v-list-item-title>
              <v-list-item-title class="px-2" @click="relaseTop(content.id)" v-else>{{lang.toRelase}}</v-list-item-title>
            </v-list-item>
            <v-list-item link >
              <v-list-item-title class="px-2" @click="postRemove(content)">{{lang.remove}}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-col>
    <v-col cols="12" class="pl-10 pt-0">
      <v-row>
        <v-col cols="12">
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>标题:</strong>
                {{content.regnames.title}}
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>开始时间:</strong>
                {{TimeViewYMD(content.regnames.startTime)}}
              </p>
            </div>
            <div class="d-flex align-center">
              <p class="text-wrap mb-0">
                <strong>截止时间:</strong>
                {{TimeViewYMD(content.regnames.endTime)}}
              </p>
            </div>
        </v-col>
        <v-col cols="12 py-0">
          <p class="text-wrap"><read-more more-str="全文" :text="regnameData[0].text" link="#" less-str="收起" :max-chars="250"></read-more></p>
        </v-col>
        <v-col cols="12" v-if="checkIfAttachExist(regnameData[0])">
          <AttachItemViewer :items="regnameData[0]" />
        </v-col>
        <v-col cols="12 py-0">
            <v-btn
                tile
                color="success"
                outlined
                class="ma-1 ml-0"
                @click="showDetail(content)"
              >
                <v-icon left>
                  mdi-eye
                </v-icon>
                {{lang.viewDetail}}
              </v-btn>
        </v-col>
      </v-row>
    </v-col>
  </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import {createReadCnt} from '~/api/alarm'
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
        regnameData: {},
    }),
    created(){
      this.regnameData = JSON.parse(this.content.regnames.content);
    },
    computed:{
      currentPath(){
        return this.$route;
      },
      ...mapGetters({
          user: 'auth/user',
      })
    },
    methods:{

      showDetail(content){
        createReadCnt({postId:content.id}).then(res=>{
          console.log(res.data)
        }).catch(err=>{
          console.log(err.response)
        })
        // console.log(this.user)
        // return
        this.$store.dispatch('content/storePostDetail',content);
        if(this.user.roleId !== 4 || this.user.roleId !== 5){
            this.$router.push({name:'details.regnameResult'});
        }
        else{
            this.$router.push({name:'details.regnameAnswer'});
        }
      },
      
    }

}
</script>

<style>

</style>