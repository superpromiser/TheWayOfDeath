<template>
    <v-container class="pa-0">
        <v-container class="banner-custom mb-10 z-index-2">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.bulletin}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        tile
                        color="success"
                        class="mr-5"
                        @click="post"
                        >
                        <v-icon left>
                            mdi-book-plus 
                        </v-icon>
                        发布
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <!-- <v-divider class="thick-border"></v-divider> -->
        <v-container v-if="contentList.length" class="pa-0" v-for="content in contentList" :key="content.id" >
            <v-row class="px-5 mt-1">
                <BulletinBoardPost :content="content"></BulletinBoardPost>
                <FooterPost :footerInfo='content'></FooterPost>
            </v-row>
        </v-container>
        <InfiniteLoading 
            class="pb-3 w-100"
            @infinite="infiniteHandler"
        >   
            <div slot="spinner">
                <v-row class="pa-3">
                <v-col cols="12" class="pt-10">
                    <v-skeleton-loader
                    v-bind="attrs"
                    type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                    :loading="isLoadingContents"
                    ></v-skeleton-loader>
                </v-col>
                <v-divider></v-divider>
                <v-col cols="12" class="pt-10">
                    <v-skeleton-loader
                    v-bind="attrs"
                    type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                    :loading="isLoadingContents"
                    ></v-skeleton-loader>
                </v-col>
                <v-divider></v-divider>
                <v-col cols="12" class="pt-10">
                    <v-skeleton-loader
                    v-bind="attrs"
                    type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                    :loading="isLoadingContents"
                    ></v-skeleton-loader>
                </v-col>
                <v-divider></v-divider>
                <v-col cols="12" class="pt-10">
                    <v-skeleton-loader
                    v-bind="attrs"
                    type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                    :loading="isLoadingContents"
                    ></v-skeleton-loader>
                </v-col>
                <v-divider></v-divider>
                <v-col cols="12" class="pt-10">
                    <v-skeleton-loader
                    v-bind="attrs"
                    type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                    :loading="isLoadingContents"
                    ></v-skeleton-loader>
                </v-col>
                <v-divider></v-divider>
                <v-col cols="12" class="pt-10">
                    <v-skeleton-loader
                    v-bind="attrs"
                    type=" list-item-avatar-two-line, list-item-three-line,list-item,list-item-two-line, actions"
                    :loading="isLoadingContents"
                    ></v-skeleton-loader>
                </v-col>
                <v-divider></v-divider>
                </v-row>
            </div>
            <div slot="no-more" class="pa-3 ma-3 text-center">
                <v-chip
                class="ma-2"
                color="primary"
                outlined
                pill
                >
                暂无
                <v-icon right>
                    mdi-cancel 
                </v-icon>
                </v-chip>
            </div>
            <div slot="no-results" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
                <div class="w-100 text-center p-5 m-5 mt-10">
                    <v-icon size="150" color="grey darken-1">
                        mdi-magnify
                    </v-icon>
                    <h5>暂无</h5>
                </div>
            </div>
        </InfiniteLoading>
    </v-container>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import {getBulletinBoard} from '~/api/bulletinBoard';
import BulletinBoardPost from '~/components/contents/bulletinBoardPost'
import FooterPost from '~/components/contents/footerPost'
import lang from '~/helper/lang.json'
export default {
    components:{
        InfiniteLoading,
        BulletinBoardPost,
        FooterPost
    },
    data:()=>({
        isLoadingContents:false,
        attrs: {
            class: 'mb-6',
        },
        pageOfContent: 1,
        lastPageOfContent: 0,
        contentList: [],
        baseUrl:window.Laravel.base_url,
        lang,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    methods:{
        async infiniteHandler($state){
            let timeOut = 0;
            this.isLoadingContents = true;
            if (this.pageOfContent > 1) {
                timeOut = 1000;
            }
            let vm = this;
            await getBulletinBoard({page:this.pageOfContent,schoolId:this.currentPath.params.schoolId})
            .then(res=>{
                if(vm.pageOfContent == 1 && res.data.data.length == 0){
                    $state.complete();
                    return;
                }
                vm.lastpageOfContent = res.data.last_page;
                $.each(res.data.data, function(key, value){
                    console.log("value",value)
                    vm.contentList.push(value); 
                });
                if (vm.pageOfContent - 1 === vm.lastpageOfContent) {
                    $state.complete();
                }
                else {
                    $state.loaded();
                }
                vm.pageOfContent = vm.pageOfContent + 1;
            });
            this.isLoadingContents = false;
        },
        post(){
            this.$router.push({name:"posts.bulletinboard"})
        }
    }
}
</script>

<style>

</style>