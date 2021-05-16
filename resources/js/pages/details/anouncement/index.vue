<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()" >
        <v-container class="pt-0 px-0 h-100 bg-white">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.announcement}}</p>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0">
                <v-col cols="12" class="d-flex">
                    <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="primary" size="48">
                        <span class="white--text headline">{{contentData.users.name[0]}}</span>
                    </v-avatar>
                    <v-avatar v-else
                        size="48"
                    >
                        <v-img :src="contentData.users.avatar"></v-img>
                    </v-avatar>
                    <div class="ml-2 d-flex flex-column">
                        <p class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"> {{lang.questionnaire}}  </p>
                        <p class="mb-0 font-size-0-8"><span class="font-color-gray">{{TimeViewMD(contentData.created_at)}} 转发</span> {{contentData.users.name}}</p>
                    </div>
                </v-col>
            </v-row>
            <v-row class="ma-0">
                <v-col cols="12" class="py-1">
                    <p class="text-wrap mb-0">
                        <strong>标题:</strong>
                        {{contentData.anouncements.title}}
                    </p>
                </v-col>
                <v-col cols="12" class="py-1">
                    <p class="text-wrap mb-0">
                        <strong>落款:</strong>
                        {{contentData.anouncements.signName}}
                    </p>
                </v-col>
                <v-col cols="12" class="py-1">
                    <p class="text-wrap mb-0">
                        <strong>日期:</strong>
                        {{TimeViewYMD(contentData.anouncements.created_at)}}
                    </p>
                </v-col>
                <v-col cols="12" class="py-1">
                    <p class="text-wrap"><read-more more-str="全文" :text="contentData.anouncements.content[0].text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" v-if="checkIfAttachExist(contentData.anouncements.content[0])">
                    <AttachItemViewer :items="contentData.anouncements.content[0]" />
                </v-col>
            </v-row>
            <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
            <CommentView></CommentView>
        </v-container>
    </v-container>
    <v-container v-else>
        <v-row class="justify-center align-center z-index-2 banner-custom">
            <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
                mdi-chevron-left
            </v-icon>
            <h2 class="py-7">{{lang.announcement}}</h2>
        </v-row>
        <v-row>
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
                        <p class="font-weight-black fs-15 mb-3"> {{lang.announcement}}  </p>
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
        </v-row>
        <v-row class="pl-10 pt-0">
           <v-col cols="12">
              <p class="text-wrap mb-0">
                <strong>标题:</strong>
                {{contentData.anouncements.title}}
              </p>
            </v-col>
            <v-col cols="12">
              <p class="text-wrap mb-0">
                <strong>落款:</strong>
                {{contentData.anouncements.signName}}
              </p>
            </v-col>
            <v-col cols="12">
              <p class="text-wrap mb-0">
                <strong>日期:</strong>
                {{TimeViewYMD(contentData.anouncements.created_at)}}
              </p>
            </v-col>
            <v-col cols="12">
                <p class="text-wrap"><read-more more-str="全文" :text="contentData.anouncements.content[0].text" link="#" less-str="收起" :max-chars="250"></read-more></p>
            </v-col>
            <v-col cols="12" v-if="checkIfAttachExist(contentData.anouncements.content[0])">
                <AttachItemViewer :items="contentData.anouncements.content[0]" />
            </v-col>
        </v-row>
        <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
        <CommentView></CommentView>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
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
        // contentData:null
        lang,
        baseUrl:window.Laravel.base_url,
    }),
    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail'
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
        console.log(this.contentData)
        this.contentData.anouncements.content = JSON.parse(this.contentData.anouncements.content)
    },
    methods:{
        updateFooterInfo(){
            
        }
    }
}
</script>

<style>

</style>