<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.classStory}}</p>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0">
                <v-col cols="12">
                    <p class="text-wrap"><read-more more-str="全文" :text="schoolStory.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" v-if="checkIfAttachExist(schoolStory)">
                    <AttachItemViewer :items="schoolStory" />
                </v-col>
            </v-row>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
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
                    <h2>{{lang.classStory}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    
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
                    <p class="font-weight-black fs-15 mb-3"> {{lang.classStory}}  </p>
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
        <v-col cols="12" class="pl-10 pt-0 mt-5">
            <v-row>
                <v-col cols="12">
                <p class="text-wrap"><read-more more-str="全文" :text="schoolStory.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" v-if="checkIfAttachExist(schoolStory)">
                <AttachItemViewer :items="schoolStory" />
                </v-col>
            </v-row>
        </v-col>
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
        schoolStory: {},
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
        this.schoolStory = JSON.parse(this.contentData.classstory.content);
        console.log(this.contentData)
    }
}
</script>

<style>

</style>