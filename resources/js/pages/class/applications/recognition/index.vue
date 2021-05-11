<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white mb-16 pb-10-px">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >表彰</p>
                <v-btn @click="post" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    发布
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-container v-if="contentList.length" class="pa-0" v-for="content in contentList" :key="content.id" >
                <v-row class="mt-1 ma-0" v-if="content.recognitions">
                    <RecognitionPost :content="content"></RecognitionPost>
                    <FooterPost :footerInfo='content'></FooterPost>
                </v-row>
            </v-container>
            <InfiniteLoading 
                class="pb-3 w-100"
                @infinite="infiniteHandler"
            >   
                <div slot="spinner" class="pa-3 ma-3 text-center">
                    <v-progress-circular
                        indeterminate
                        color="#7879ff"
                    ></v-progress-circular>
                </div>
                <div slot="no-more" class="pa-3 ma-3 text-center">
                    <v-chip
                    class="ma-2"
                    color="#7879ff"
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
                        <v-icon size="60" color="grey darken-1">
                            mdi-magnify
                        </v-icon>
                        <h5>暂无</h5>
                    </div>
                </div>
            </InfiniteLoading>
        </v-container>
        
    </v-container>
    <v-container class="pa-0" v-else>
        <v-container class="banner-custom mb-10 z-index-2" color="white" sticky elevation="20">
            <v-row>
                <v-col cols="12" class="justify-space-between d-flex ma-0 align-center">
                    <a @click="$router.go(-1)">
                        <v-icon size="70">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                <!-- </v-col>
                <v-col> -->
                    <!-- <v-avatar
                        class="ma-3 ml-3"
                        size="50"
                        tile
                    >
                        <v-img :src="`${baseUrl}/asset/img/newIcon/问卷.png`" alt="postItem" ></v-img>
                    </v-avatar> -->
                    <h2>表彰</h2>
                <!-- </v-col>
                <v-col> -->
                    <v-btn
                        tile
                        color="#7879ff"
                        dark
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
        <v-container v-if="contentList.length" class="pa-0" v-for="content in contentList" :key="content.id" >
            <v-row class="px-5 mt-1" v-if="content.recognitions">
                <RecognitionPost :content="content"></RecognitionPost>
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
import {getRecognition} from '~/api/recognition';
import RecognitionPost from '~/components/contents/recognitionPost.vue'
import FooterPost from '~/components/contents/footerPost'
import lang from '~/helper/lang.json'
export default {
    components:{
        InfiniteLoading,
        RecognitionPost,
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
        viewList:[
            {
                text:'已维修',
                value:'done'
            },
            {
                text:'已发布',
                value:'progress'
            },
            {
                text:'已完成',
                value:'completed'
            },
            {
                text:'已取消',
                value:'cancel'
            },
        ],
        viewType:'progress',
        date:new Date().toISOString().substr(0, 10),
        menu:false
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
            await getRecognition({page:this.pageOfContent,schoolId:this.currentPath.params.schoolId,status:this.viewType,deadline:this.date,lessonId:this.currentPath.params.lessonId})
            .then(res=>{
                console.log(res.data)
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
            this.$router.push({name:"posts.Crecognition"})
        },
        selViewType(){
            console.log(this.viewType)
            this.pageOfContent = 1;
            this.lastPageOfContent = 0;
            this.contentList = [];
            this.infiniteHandler()
        },
        selDate(){
            console.log(this.date)
            this.pageOfContent = 1;
            this.lastPageOfContent = 0;
            this.contentList = [];
            this.infiniteHandler()
        }
    }
}
</script>

<style>

</style>