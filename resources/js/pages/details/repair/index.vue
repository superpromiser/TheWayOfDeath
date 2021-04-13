<template>
    <v-container>
        <v-col cols="12" class="d-flex align-center">
            <a @click="$router.go(-1)" class="float-left">
                <v-icon size="70">
                    mdi-chevron-left
                </v-icon>
            </a>
            <v-avatar class="ma-3 school-card-avatar" tile >
                <v-img :src="`${baseUrl}/asset/img/newIcon/维修工单.png`" alt="postItem" ></v-img>
            </v-avatar>
            <div>
                <p class="font-weight-black fs-15 mb-3"> 维修工单  </p>
                <div class="d-flex align-center">
                <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
                <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                <p class="mb-0">{{contentData.users.name}}</p>
                </div>
            </div>
            <div class="ml-auto" v-if="this.user.roleId == 6">
                <v-btn class="mr-3" @click="incomplete" :loading="isIncomplete">
                    未完成
                </v-btn>
                <v-btn dark color="#7879ff" @click="complete" :loading="isComplete">
                    己完成
                </v-btn>
            </div>
            <div class="ml-auto" v-else-if="this.user.roleId == 5">
                <v-btn class="mr-3" @click="incomplete" :loading="isIncomplete">
                    取诮发布
                </v-btn>
                <v-btn dark color="#7879ff" @click="complete" :loading="isComplete">
                    确认完成
                </v-btn>
            </div>
            <div class="ml-auto" v-else>
                <v-btn class="mr-3" @click="incomplete" :loading="isIncomplete">
                    未完成
                </v-btn>
                <v-btn dark color="#7879ff" @click="complete" :loading="isComplete">
                    确认完成
                </v-btn>
            </div>
        </v-col>
        <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0" >姓名 </p>
                <p class="mb-0" >{{contentData.repairdata.userName}} </p>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0" >交接人姓名 </p>
                <p class="mb-0" >{{contentData.repairdata.viewListName}} </p>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0" >维修物品 </p>
                <p class="mb-0" >{{contentData.repairdata.repairType}} </p>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-col cols="12" class="pl-10 pt-0">
            <v-row>
                <v-col cols="12">
                <p class="text-wrap"><read-more more-str="全文" :text="description.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" v-if="checkIfAttachExist(description)">
                <AttachItemViewer :items="description" />
                </v-col>
            </v-row>
        </v-col>
        <v-divider light></v-divider>
        <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0" >发布时间 </p>
                <p class="mb-0" >{{TimeViewSam(contentData.repairdata.deadline)}} </p>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';

export default {
    components:{
        AttachItemViewer,
    },
    data:()=>({
        // contentData:null
        lang,
        baseUrl:window.Laravel.base_url,
        description:null,
        status:'',
        isIncomplete:false,
        isComplete:false
    }),
    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail',
            user:'auth/user'
        })
    },
    created(){
        if(this.contentData == null){
            if(this.currentpath.params.lessonId){
                this.$router.push({name:'classSpace.news'})
            }else{
                this.$router.push({name:'schoolSpace.news'})
            }
        }
        this.description = JSON.parse(this.contentData.repairdata.content);
        console.log(this.contentData)
    },
    methods:{
        incomplete(){
            console.log('incomplete')
        },
        complete(){
            console.log('complete')
        }
    }

}
</script>

<style>

</style>