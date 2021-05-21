
<template>
  <v-container v-if="$isMobile()">
    <v-row>
      <v-col cols="12" class="d-flex" @click="showDetail(content)">
        <v-avatar v-if="content.users.name !== '' && content.users.avatar == '/'" color="#7879ff" size="48">
            <span class="white--text headline">{{content.users.name[0]}}</span>
        </v-avatar>
        <v-avatar v-else
          size="48"
        >
          <v-img :src="content.users.avatar"></v-img>
        </v-avatar>
        <div class="ml-2 d-flex flex-column">
          <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.schoolStory}}  </p>
          <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(content.created_at)}}  </span> {{content.users.name}}</p>
        </div>
      </v-col>
      <v-col cols="12" class=" font-size-0-8">
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>开始时间:</strong>
            {{TimeView(vacationData.startTime)}}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>结束时间:</strong>
            {{TimeView(vacationData.endTime)}}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>请假原因:</strong>
            {{vacationData.reason}}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>审批人:</strong>
            {{vacationData.teacherName}}
          </p>
        </div>
        <div class="d-flex align-center font-size-0-8">
          <p class="text-wrap mb-0">
            <strong>审批状态:</strong>
            <v-chip small v-if="vacationData.status == 'deny'" class="ma-2" color="pink" label text-color="white" >
              <v-icon left> mdi-cancel </v-icon> 否定
            </v-chip>
            <v-chip small v-else-if="vacationData.status == 'allow'" class="ma-2" color="success"  label text-color="white" >
              <v-icon left> mdi-hand   </v-icon> 允许
            </v-chip>
            <v-chip small v-else-if="vacationData.status == 'pending'" class="ma-2" color="orange"  label text-color="white" >
              <v-icon left> mdi-clock-outline   </v-icon> 待办的
            </v-chip>
          </p>
        </div>
        <div class="d-flex align-center font-size-0-8">
          <v-tooltip bottom v-if="vacationData.status == 'pending'">
            <v-icon
                small
                @click="replyItem(vacationData)"
            >
                mdi-reply
            </v-icon>
            <span>回复</span>
          </v-tooltip>
          <v-tooltip bottom v-if="vacationData.status == 'allow'">
            <v-icon
                small
                @click="denyItem(vacationData)"
            >
                mdi-cancel
            </v-icon>
            <span>否定</span>
          </v-tooltip>
          <v-tooltip bottom v-if="vacationData.status == 'deny'">
            <v-icon
                small
                @click="allowItem(vacationData)"
            >
                mdi-hand
            </v-icon>
            <span>允许</span>
          </v-tooltip>
        </div>
      </v-col>
    </v-row>
  </v-container>
  <v-container v-else>
    <v-col cols="12" class="d-flex align-center hover-cursor-point" @click="showDetail(content)">
      <v-avatar v-if="content.users.name !== '' && content.users.avatar == '/'" color="#7879ff" size="60" class="ma-5">
          <span class="white--text headline">{{content.users.name[0]}}</span>
      </v-avatar>
      <v-avatar v-else
        class="ma-5"
        size="60"
      >
        <v-img :src="content.users.avatar"></v-img>
      </v-avatar>
      <div>
        <p class="font-weight-black fs-15 mb-3"> {{lang.vacation}}  </p>
        <div class="d-flex align-center">
          <v-icon medium color="#7879ff" class="mr-2">mdi-clock-outline </v-icon>
          <p class="mb-0 mr-8">{{TimeView(content.created_at)}}</p>
          <v-icon medium color="#7879ff" class="mr-2">mdi-account </v-icon>
          <p class="mb-0">{{content.users.name}}</p>
        </div>
      </div>
      <div class="ml-auto" v-if="user.roleId < 3 || content.users.id == user.id">
        <v-menu offset-y >
          <template v-slot:activator="{ attrs, on }">
            <v-btn icon color="#7879ff" v-bind="attrs" v-on="on" >
              <v-icon size="30">mdi-chevron-down </v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item link v-if="user.roleId < 3" >
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
      <div class="d-flex align-center">
        <p class="text-wrap mb-0">
          <strong>开始时间:</strong>
          {{TimeView(vacationData.startTime)}}
        </p>
      </div>
      <div class="d-flex align-center">
        <p class="text-wrap mb-0">
          <strong>结束时间:</strong>
          {{TimeView(vacationData.endTime)}}
        </p>
      </div>
      <div class="d-flex align-center">
        <p class="text-wrap mb-0">
          <strong>请假原因:</strong>
          {{vacationData.reason}}
        </p>
      </div>
      <div class="d-flex align-center">
        <p class="text-wrap mb-0">
          <strong>审批人:</strong>
          {{vacationData.teacherName}}
        </p>
      </div>
      <div class="d-flex align-center">
        <p class="text-wrap mb-0">
          <strong>审批状态:</strong>
          <v-chip v-if="vacationData.status == 'deny'" class="ma-2" color="pink" label text-color="white" >
            <v-icon left> mdi-cancel </v-icon> 否定
          </v-chip>
          <v-chip v-else-if="vacationData.status == 'allow'" class="ma-2" color="success"  label text-color="white" >
            <v-icon left> mdi-hand   </v-icon> 允许
          </v-chip>
          <v-chip v-else-if="vacationData.status == 'pending'" class="ma-2" color="orange"  label text-color="white" >
            <v-icon left> mdi-clock-outline   </v-icon> 待办的
          </v-chip>
        </p>
      </div>
      <div class="d-flex align-center">
        <v-tooltip bottom v-if="vacationData.status == 'pending'">
          <v-icon
              small
              @click="replyItem(vacationData)"
          >
              mdi-reply
          </v-icon>
          <span>回复</span>
        </v-tooltip>
        <v-tooltip bottom v-if="vacationData.status == 'allow'">
          <v-icon
              small
              @click="denyItem(vacationData)"
          >
              mdi-cancel
          </v-icon>
          <span>否定</span>
        </v-tooltip>
        <v-tooltip bottom v-if="vacationData.status == 'deny'">
          <v-icon
              small
              @click="allowItem(vacationData)"
          >
              mdi-hand
          </v-icon>
          <span>允许</span>
        </v-tooltip>
      </div>
    </v-col>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
import {createReadCnt} from '~/api/alarm'
import {mapGetters} from 'vuex'
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
        vacationData: {},
    }),
    created(){
    //   this.shareData = JSON.parse(this.content.shares.content);
    //   console.log(this.content)
        this.vacationData = this.content.vacations

    },
    computed:{
      currentPath(){
        return this.$route
      },
      ...mapGetters({
        user:'auth/user',
        selectedSchoolItem : 'mo/selectedSchoolItem',
      })
    },
    methods:{

      showDetail(content){
        createReadCnt({postId:content.id}).then(res=>{
        }).catch(err=>{
          console.log(err.response)
        })
        createReadCnt({postId:content.id}).then(res=>{
        }).catch(err=>{
          console.log(err.response)
        })
        this.$store.dispatch('content/storePostDetail',content)
        if(this.currentPath.params.lessonId){
          this.$router.push({name:'details.classDefault'});
        }else{
          this.$router.push({name:'details.schoolDefault'});
        }
      },
      
    }

}
</script>

<style>

</style>