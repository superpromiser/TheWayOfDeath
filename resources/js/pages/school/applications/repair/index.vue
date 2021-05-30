<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white mb-16 pb-10-px pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >维修工单</p>
                <v-btn v-if="user.roleId == 1 || user.roleId == 2 || user.roleId == 3 || user.roleId == 7"
                     @click="post" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    发布
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0">
                <v-col cols="12" class="py-0">
                    <v-select
                        :items="viewList"
                        label="Solo field"
                        single-line
                        color="#7879ff"
                        @change="selViewType"
                        v-model="viewType"
                        item-text='text'
                        item-value="value"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" class="pt-0">
                    <v-menu
                        v-model="menu"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            color="#7879ff"
                            v-model="date"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            hide-details
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="date"
                        @input="menu = false"
                        @change="selDate"
                        color="#7879ff"
                        ></v-date-picker>
                    </v-menu>
                </v-col>
            </v-row>
            <v-container v-if="contentList.length && content.repairdata" class="pa-0" v-for="content in contentList" :key="content.id" >
                <v-row class="mt-1 ma-0" v-if="content.repairdata">
                    <RepairDataPost :content="content"></RepairDataPost>
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
            <v-row class="ma-0">
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
                    <h2>维修工单</h2>
                <!-- </v-col>
                <v-col> -->
                    <v-btn
                        tile
                        color="#7879ff"
                        dark
                        class="mr-5"
                        @click="post"
                        v-if="user.roleId == 1 || user.roleId == 2 || user.roleId == 3 || user.roleId == 7"
                        >
                        <v-icon left>
                            mdi-book-plus 
                        </v-icon>
                        发布
                    </v-btn>
                    <span v-else> </span>
                </v-col>
            </v-row>
        </v-container>
        <v-row class="px-5 ma-0">
            <v-col>
                <v-select
                    :items="viewList"
                    label="Solo field"
                    solo
                    @change="selViewType"
                    v-model="viewType"
                    item-text='text'
                    item-value="value"
                ></v-select>
            </v-col>
            <v-col>
                <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="date"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
                    </template>
                    <v-date-picker
                    v-model="date"
                    @input="menu = false"
                    @change="selDate"
                    ></v-date-picker>
                </v-menu>
            </v-col>
        </v-row>
        <!-- <v-divider class="thick-border"></v-divider> -->
        <v-container v-if="contentList.length && content.repairdata" class="pa-0" v-for="content in contentList" :key="content.id" >
            <v-row class="px-5 mt-1 ma-0" v-if="content.repairdata">
                <RepairDataPost :content="content"></RepairDataPost>
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
            <div slot="no-results" class="position-relative row ma-0 p-2 h-50 d-flex justify-content-center align-items-center">
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
import {getRepairData} from '~/api/repair';
import RepairDataPost from '~/components/contents/repairDataPost'
import FooterPost from '~/components/contents/footerPost'
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex'
export default {
    components:{
        InfiniteLoading,
        RepairDataPost,
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
                text:'全部',
                value:'all'
            },
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
            {
                text:'未完成',
                value:'Undone'
            },
        ],
        viewType:'progress',
        date:new Date().toISOString().substr(0, 10),
        menu:false
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            user:'auth/user'
        })
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.query.fix){
                    let index = this.contentList.findIndex(content=>content.id == this.currentPath.query.fix)
                    if(index > -1){
                        let fixVal = this.contentList[index]
                        this.contentList.splice(index,1)
                        let currentTime = this.TimeView(Date.now())
                        fixVal.fixTop = currentTime;
                        this.contentList.unshift(fixVal)
                    }
                }
                if(val.query.release){
                    let index = this.contentList.findIndex(content=>content.id == this.currentPath.query.release)
                    if(index > -1){
                        let releaseVal = this.contentList[index]
                        releaseVal.fixTop = null
                        this.contentList.splice(index,1)
                        this.contentList.push(releaseVal)
                    }
                }
                if(val.query.remove){
                    let index = this.contentList.findIndex(content=>content.id == this.currentPath.query.remove)
                    if(index > -1){
                        this.contentList.splice(index,1)
                    }
                }
            },
            deeper:true
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
            await getRepairData({page:this.pageOfContent,schoolId:this.currentPath.params.schoolId,status:this.viewType,deadline:this.date})
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
            this.$router.push({name:"posts.repair"})
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