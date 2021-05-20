<template>
    <v-container  class="ma-0 pa-0 h-100" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white mb-16 pb-10-px pt-12" v-if="showDetail == false">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{homeworkData.homeworkType}}</p>
                <v-btn @click="viewDetail" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    查看详情
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex">
                    <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="#7879ff" size="48">
                        <span class="white--text headline">{{contentData.users.name[0]}}</span>
                    </v-avatar>
                    <v-avatar v-else size="48" >
                        <v-img :src="contentData.users.avatar"></v-img>
                    </v-avatar>
                    <div class="ml-2 d-flex flex-column">
                        <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{homeworkData.homeworkType}}  </p>
                        <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(contentData.created_at)}} 转发</span> {{contentData.users.name}}</p>
                    </div>
                </v-col>
            </v-row>
            <v-row class="ma-0">
                <v-col cols="12">
                    <div class="d-flex align-center">
                        <p class="text-wrap mb-0">
                        <strong>作业科目:</strong>
                        {{homeworkData.subjectName}}
                        </p>
                    </div>
                    <div class="d-flex align-center">
                        <p class="text-wrap mb-0">
                        <strong>作业类型:</strong>
                        {{homeworkData.homeworkType}}
                        </p>
                    </div>
                    <div class="d-flex align-center">
                        <p class="text-wrap mb-0 w-100">
                        <strong>作业内容:</strong>
                        {{homeworkData.content.text}}
                        </p>
                    </div>
                </v-col>
                <v-col cols="12" class="py-0" v-if="checkIfAttachExist(homeworkData.content)">
                    <AttachItemViewer :items="homeworkData.content" />
                </v-col>
                <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
                <CommentView></CommentView>
            </v-row>
        </v-container>
        <v-container class="pa-0" v-else>
            <router-view :contentData="contentData"></router-view>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
        <div v-if="showDetail == false">
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
                        <h2>{{homeworkData.homeworkType}}</h2>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex align-center justify-end">
                        <v-btn
                            dark
                            tile
                            color="#7879ff"
                            v-if="user.roleId == 3 || user.roleId == 5 || user.roleId == 7"
                            @click="viewDetail"
                        >
                            查看详情
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
            <v-col cols="12" class="d-flex align-center hover-cursor-point mt-5 px-5">
                <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="#7879ff" size="60" class="ma-5">
                    <span class="white--text headline">{{contentData.users.name[0]}}</span>
                </v-avatar>
                <v-avatar v-else
                    class="ma-5"
                    size="60"
                    >
                    <v-img :src="contentData.users.avatar"></v-img>
                </v-avatar>
                <div>
                    <p class="font-weight-black fs-15 mb-3"> {{contentData.homework.homeworkType}}  </p>
                    <div class="d-flex align-center">
                        <v-icon medium color="#7879ff" class="mr-2">mdi-clock-outline </v-icon>
                        <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
                        <v-icon medium color="#7879ff" class="mr-2">mdi-account </v-icon>
                        <p class="mb-0">{{contentData.users.name}}</p>
                    </div>
                </div>
                <div class="ml-auto mr-5">
                    <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                        <v-btn icon color="#7879ff" v-bind="attrs" v-on="on" >
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
            <v-col cols="12" class="pl-10 pt-0 mt-5">
            <div class="d-flex align-center">
                <p class="text-wrap mb-0">
                <strong>作业科目:</strong>
                {{homeworkData.subjectName}}
                </p>
            </div>
            <div class="d-flex align-center">
                <p class="text-wrap mb-0">
                <strong>作业类型:</strong>
                {{homeworkData.homeworkType}}
                </p>
            </div>
            <div class="d-flex align-center">
                <p class="text-wrap mb-0">
                <strong>作业内容:</strong>
                {{homeworkData.content.text}}
                </p>
            </div>
            </v-col>
            <v-col cols="12" class="pl-10 pt-0">
            <v-row>
                <v-col cols="12" v-if="checkIfAttachExist(homeworkData.content)">
                <AttachItemViewer :items="homeworkData.content" />
                </v-col>
            </v-row>
            </v-col>
            <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
            <CommentView></CommentView>
        </div>
        <div v-else>
            <router-view :contentData="contentData"></router-view>
        </div>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
import AttachItemViewer from '~/components/attachItemViewer';
import FooterPost from '~/components/contents/footerPost'
import CommentView from '~/pages/school/posts/comments/commentView';
export default {
    components:{
        AttachItemViewer,
        FooterPost,
        CommentView
    },
    data:()=>({
        baseUrl:window.Laravel.base_url,
        lang,
        homeworkData:null,
        showDetail:false,
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
            if(this.$isMobile()){
                this.$router.push({name:'home'})
            }
            else{
                if(this.currentpath.params.lessonId){
                    this.$router.push({name:'classSpace.news'})
                }else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }
        }
        console.log("this.contentData",this.contentData)
        this.homeworkData = this.contentData.homework
    },
    methods:{
        viewDetail(){
            console.log('viewDetail')
            this.showDetail = true
        },
        updateFooterInfo(){
            
        }
    }

}
</script>

<style>

</style>