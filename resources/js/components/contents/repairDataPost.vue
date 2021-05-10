<template>
  <v-container v-if="$isMobile()">
    <v-row>
      <v-col cols="12" class="d-flex">
        <v-avatar v-if="content.users.name !== '' && content.users.avatar == '/'" color="primary" size="48">
            <span class="white--text headline">{{content.users.name[0]}}</span>
        </v-avatar>
        <v-avatar v-else
          size="48"
        >
          <v-img :src="content.users.avatar"></v-img>
        </v-avatar>
        <div class="ml-2 d-flex flex-column">
          <div class="d-flex align-center mb-auto">
            <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color">维修工单</p>
            <v-chip class="ma-2" color="pink" label text-color="white" v-if="content.repairdata.status == 'done'">
              <v-icon left> mdi-label </v-icon> 已完成
            </v-chip>
          </div>
          <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(content.created_at)}} 转发</span> {{content.users.name}}</p>
        </div>
      </v-col>
      <v-col cols="12" class="py-0 font-size-0-8">
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
          <strong>姓名:</strong>
          {{content.repairdata.userName}}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
          <strong>交接人姓名:</strong>
          {{content.repairdata.viewListName}}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
          <strong>维修物品:</strong>
          {{content.repairdata.repairType}}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
          <strong>发布时间:</strong>
          {{TimeViewSam(content.repairdata.deadline)}}
          </p>
        </div>
      </v-col>
      <v-col cols="12" class="pb-0">
        <p class="text-wrap mb-0 font-size-0-75"><read-more more-str="全文" :text="description.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
      </v-col>
      <v-col cols="12" class="" v-if="checkIfAttachExist(description)">
        <AttachItemViewer :items="description" />
      </v-col>
    </v-row>
  </v-container>
  <v-container v-else>
    <v-col cols="12" class="d-flex align-center hover-cursor-point" @click="showDetail(content)">
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
        <div class="d-flex align-center mb-3">
          <p class="font-weight-black fs-15 mb-0"> 维修工单  </p>
          <v-chip class="ma-2" color="#999999" label text-color="white" v-if="content.repairdata.status == 'cancel'">
              <v-icon left> mdi-label </v-icon> 取消
          </v-chip>
          <v-chip class="ma-2" color="#EB5846" label text-color="white" v-if="content.repairdata.status == 'Undone'">
              <v-icon left> mdi-label </v-icon> 未完成
          </v-chip>
          <v-chip class="ma-2" color="#F19861" label text-color="white" v-if="content.repairdata.status == 'progress'">
              <v-icon left> mdi-label </v-icon> 已发布
          </v-chip>
          <v-chip class="ma-2" color="#FEB31A" label text-color="white" v-if="content.repairdata.status == 'done'">
              <v-icon left> mdi-label </v-icon> 已维修
          </v-chip>
          <v-chip class="ma-2" color="#4AD2A0" label text-color="white" v-if="content.repairdata.status == 'completed'">
              <v-icon left> mdi-label </v-icon> 已完成
          </v-chip>
        </div>
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
              <v-list-item-title class="px-2" @click="fixTop(content)">{{lang.toTop}}</v-list-item-title>
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
            {{content.repairdata.userName}}
            </p>
        </div>
        <div class="d-flex align-center">
            <p class="text-wrap mb-0">
            <strong>交接人姓名:</strong>
            {{content.repairdata.viewListName}}
            </p>
        </div>
        <div class="d-flex align-center">
            <p class="text-wrap mb-0">
            <strong>维修物品:</strong>
            {{content.repairdata.repairType}}
            </p>
        </div>
        <div class="d-flex align-center" v-if="content.repairdata.reason">
            <p class="text-wrap mb-0">
            <strong>未完成原因:</strong>
            {{content.repairdata.reason}}
            </p>
        </div>
        <div class="d-flex align-center">
            <p class="text-wrap mb-0">
            <strong>发布时间:</strong>
            {{TimeViewSam(content.repairdata.deadline)}}
            </p>
        </div>
        <v-col cols="12" class="pt-0">
            <v-row>
                <v-col cols="12" class="pl-0">
                  <p class="text-wrap"><read-more more-str="全文" :text="description.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" class="pl-0" v-if="checkIfAttachExist(description)">
                  <AttachItemViewer :items="description" />
                </v-col>
            </v-row>
        </v-col>
        
    </v-col>
   
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
import {createReadCnt} from '~/api/alarm'
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
        description: {},
    }),
    
    created(){
        this.description = JSON.parse(this.content.repairdata.content)
    },
    computed:{
      currentPath(){
        return this.$route
      }
    },
    methods:{

      showDetail(content){
        createReadCnt({postId:content.id}).then(res=>{
          console.log(res.data)
        }).catch(err=>{
          console.log(err.response)
        })
        this.$store.dispatch('content/storePostDetail',this.content)
        if(this.currentPath.params.lessonId){
          this.$router.push({name:'details.classRepair'});
        }else{
          this.$router.push({name:'details.schoolRepair'});
        }
        
      },
      
    }

}
</script>

<style>

</style>