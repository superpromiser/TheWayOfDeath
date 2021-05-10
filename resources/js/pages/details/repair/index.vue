<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()" >
        <v-container class="pt-0 px-0 h-100 bg-white">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >维修工单</p>
                <v-btn v-if="this.user.roleId == 6" @click="repairUpdate('Undone')" :loading="isIncomplete" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    未完成
                </v-btn>
                <v-btn v-if="this.user.roleId == 6" @click="repairUpdate('done')" :loading="isComplete" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    己完成
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>

        <v-row class="justify-center align-center z-index-2 banner-custom ">
            <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
                mdi-chevron-left
            </v-icon>
            <h2 class="py-7">维修工单</h2>
            <div class="ml-auto position-absolute put-align-center" style="top:50%; right:20px" v-if="this.user.roleId == 6">
                <v-btn class="mr-3" @click="repairUpdate('Undone')" :loading="isIncomplete">
                    未完成
                </v-btn>
                <v-btn dark color="#7879ff" @click="repairUpdate('done')" :loading="isComplete">
                    己完成
                </v-btn>
            </div>
            <div class="ml-auto position-absolute put-align-center" style="top:50%; right:20px" v-else>
                <div v-if="contentData.repairdata.status == 'progress'">
                    <v-btn class="mr-3" @click="repairUpdate('cancel')" :loading="isCancelPost">
                        取诮发布
                    </v-btn>
                </div>
                <div v-if="contentData.repairdata.status == 'done'">
                    <v-btn class="mr-3" @click="repairUpdate('progress')" :loading="isIncomplete">
                        未完成
                    </v-btn>
                    <v-btn dark color="#7879ff" @click="repairUpdate('completed')" :loading="isComplete">
                        确认完成
                    </v-btn>
                </div>
            </div>
        </v-row>
        <v-row class="pl-5 mt-5 ma-0">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0" >姓名 </p>
                <p class="mb-0" >{{contentData.repairdata.userName}} </p>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="ma-0 pl-5">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0" >交接人姓名 </p>
                <p class="mb-0" >{{contentData.repairdata.viewListName}} </p>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="ma-0 pl-5">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0" >维修物品 </p>
                <p class="mb-0" >{{contentData.repairdata.repairType}} </p>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="ma-0 pl-5">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0" >发布时间 </p>
                <p class="mb-0" >{{TimeViewSam(contentData.repairdata.deadline)}} </p>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-col cols="12" class="pl-5 pt-0">
            <v-row class="ma-0">
                <v-col cols="12">
                <p class="text-wrap"><read-more more-str="全文" :text="description.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" v-if="checkIfAttachExist(description)">
                <AttachItemViewer :items="description" />
                </v-col>
            </v-row>
        </v-col>
        
        </v-container>
    </v-container>
    <v-container v-else class="pa-0">
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class="left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>维修工单</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <div v-if="contentData.repairdata.status == 'progress'">
                        <v-btn class="mr-3" @click="cancel('cancel')" :loading="isCancel">
                            取诮发布
                        </v-btn>
                    </div>
                    <div v-if="contentData.repairdata.status == 'done'">
                        <v-btn class="mr-3" @click="reasonFlag = true">
                            未完成
                        </v-btn>
                        <v-btn dark color="#7879ff" @click="post('completed')" :loading="isPost">
                            确认完成
                        </v-btn>
                    </div>
                    <div v-if="contentData.repairdata.status == 'Undone'">
                        <v-btn class="mr-3" @click="cancel('cancel')" :loading="isCancel">
                            关闭
                        </v-btn>
                        <v-btn dark color="#7879ff" @click="post('progress')" :loading="isPost">
                            重新发送
                        </v-btn>
                    </div>
                    <div v-if="contentData.repairdata.status == 'cancel'">
                        <v-btn dark color="#7879ff" @click="post('progress')" :loading="isPost">
                            重新发送
                        </v-btn>
                    </div>
                </v-col>
            </v-row>
        </v-container>
        <v-col cols="12" class="d-flex align-center hover-cursor-point mt-5 px-5">
            <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="primary" size="60" class="ma-5">
                    <span class="white--text headline">{{contentData.users.name[0]}}</span>
                </v-avatar>
                <v-avatar v-else
                class="ma-5"
                size="60"
                >
                <v-img :src="contentData.users.avatar"></v-img>
                </v-avatar>
            <div>
                <div class="d-flex align-center mb-3">
                <p class="font-weight-black fs-15 mb-0"> 维修工单  </p>
                <v-chip class="ma-2" color="#999999" label text-color="white" v-if="contentData.repairdata.status == 'cancel'">
                    <v-icon left> mdi-label </v-icon> 取消
                </v-chip>
                <v-chip class="ma-2" color="#EB5846" label text-color="white" v-if="contentData.repairdata.status == 'Undone'">
                    <v-icon left> mdi-label </v-icon> 未完成
                </v-chip>
                <v-chip class="ma-2" color="#F19861" label text-color="white" v-if="contentData.repairdata.status == 'progress'">
                    <v-icon left> mdi-label </v-icon> 已发布
                </v-chip>
                <v-chip class="ma-2" color="#FEB31A" label text-color="white" v-if="contentData.repairdata.status == 'done'">
                    <v-icon left> mdi-label </v-icon> 已维修
                </v-chip>
                <v-chip class="ma-2" color="#4AD2A0" label text-color="white" v-if="contentData.repairdata.status == 'completed'">
                    <v-icon left> mdi-label </v-icon> 已完成
                </v-chip>
                </div>
                <div class="d-flex align-center">
                <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
                <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                <p class="mb-0">{{contentData.users.name}}</p>
                </div>
            </div>
            <div class="ml-auto mr-5">
                <v-menu offset-y >
                <template v-slot:activator="{ attrs, on }">
                    <v-btn icon color="primary" v-bind="attrs" v-on="on" >
                    <v-icon size="30">mdi-chevron-down </v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item link >
                    <v-list-item-title class="px-2" @click="fixTop(contentData)">{{lang.toTop}}</v-list-item-title>
                    </v-list-item>
                    <v-list-item link >
                    <v-list-item-title class="px-2" @click="postRemove(contentData)">{{lang.remove}}</v-list-item-title>
                    </v-list-item>
                </v-list>
                </v-menu>
            </div>
        </v-col>
        <div class="px-10">
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0" >姓名 </p>
                    <p class="mb-0" >{{contentData.repairdata.userName}} </p>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0" >交接人姓名 </p>
                    <p class="mb-0" >{{contentData.repairdata.viewListName}} </p>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0" >维修物品 </p>
                    <p class="mb-0" >{{contentData.repairdata.repairType}} </p>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0" v-if="contentData.repairdata.reason">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0" >reason </p>
                    <p class="mb-0" >{{contentData.repairdata.reason}} </p>
                </v-col>
            </v-row>
            <v-divider light v-if="contentData.repairdata.reason"></v-divider>
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0" >发布时间 </p>
                    <p class="mb-0" >{{TimeViewSam(contentData.repairdata.deadline)}} </p>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-col cols="12" class="pa-0">
                <v-row class="ma-0">
                    <v-col cols="12" class=" py-0">
                    <p class="text-wrap"><read-more more-str="全文" :text="description.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                    </v-col>
                    <v-col cols="12" v-if="checkIfAttachExist(description)">
                    <AttachItemViewer :items="description" />
                    </v-col>
                </v-row>
            </v-col>
            <v-row justify="center">
                <v-dialog
                    v-model="reasonFlag"
                    persistent
                    max-width="600px"
                >
                    <v-card>
                        <v-card-title>
                            <!-- <span class="headline">添加围栏</span> -->
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                    <v-textarea
                                        label=""
                                        required
                                        v-model="reason"
                                    ></v-textarea>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="reasonFlag = false"
                            >
                                关闭
                            </v-btn>
                            <v-btn
                                color="blue darken-1"
                                text
                                :loading="isSaving"
                                @click="saveReason"
                            >
                                保存
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>
        </div>
        
        <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
        <CommentView></CommentView>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
import {updateRepairData} from '~/api/repair';
import FooterPost from '~/components/contents/footerPost'
import CommentView from '~/pages/school/posts/comments/commentView';
export default {
    components:{
        AttachItemViewer,
        FooterPost,
        CommentView
    },
    data:()=>({
        // contentData:null
        lang,
        baseUrl:window.Laravel.base_url,
        description:null,
        status:'',
        reason:'',
        isCancel:false,
        isPost:false,
        isSaving:false,
        reasonFlag:false
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
        async cancel(status){
            
            this.isCancel = true
            await updateRepairData({status:status,repairId:this.contentData.repairdata.id}).then(res=>{
                console.log(res.data)
                this.isCancel = false
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                this.isCancel = false
                console.log(err.response)
            })
        },
        async post(status){
            console.log(status)
            // switch(status){
            //     case ''
            // }
            // this.isComplete = true
            this.isPost = true
            await updateRepairData({status:status,repairId:this.contentData.repairdata.id}).then(res=>{
                console.log(res.data)
                this.isPost = false
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                this.isPost = false
                console.log(err.response)
            })
        },
        saveReason(){
           let status = '';
            if(this.user.roleId == 6){
                status = 'Undone'
            }else{
                status = 'progress'
            }

            this.isSaving = true
            updateRepairData({status:status,repairId:this.contentData.repairdata.id,reason:this.reason}).then(res=>{
                console.log(res.data)
                this.isSaving = false
                this.$router.push({name:'schoolSpace.news'})
                this.reasonFlag = false
            }).catch(err=>{
                this.isSaving = false
                this.reasonFlag = false
                console.log(err.response)
            })
        },
        updateFooterInfo(){
            
        }
    }

}
</script>

<style>

</style>