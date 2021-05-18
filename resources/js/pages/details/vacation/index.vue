<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()" >
        <v-container class="pt-0 px-0 h-100 bg-white pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.share}}</p>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0">
                <v-col cols="12">
                    <p class="text-wrap"><read-more more-str="全文" :text="shareData[0].text" link="#" less-str="收起" :max-chars="250"></read-more></p>
                </v-col>
                <v-col cols="12" v-if="checkIfAttachExist(shareData[0])">
                    <AttachItemViewer :items="shareData[0]" />
                </v-col>
            </v-row>
        </v-container>
    </v-container>
    <v-container v-else>
        <v-row class="justify-center align-center z-index-2 banner-custom">
            <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
                mdi-chevron-left
            </v-icon>
            <h2 class="py-7">{{lang.vacation}}</h2>
        </v-row>
        <v-row class="mt-5">
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
                    <strong>结束时间:</strong>
                    {{vacationData.reason}}
                    </p>
                </div>
                <div class="d-flex align-center">
                    <p class="text-wrap mb-0">
                    <strong>结束时间:</strong>
                    {{vacationData.teacherName}}
                    </p>
                </div>
                <div class="d-flex align-center">
                    <p class="text-wrap mb-0">
                    <strong>结束时间:</strong>
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
        </v-row>
    </v-container>
    
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
import AttachItemViewer from '~/components/attachItemViewer';
import VacationPost from '~/components/contents/vacationPost'
import FooterPost from '~/components/contents/footerPost'
export default {
    components:{
        AttachItemViewer,
        VacationPost,
        FooterPost,
    },

    data:()=>({
        // contentData:null
        lang,
        baseUrl:window.Laravel.base_url,
        vacationData: {},
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
        console.log("=======================",this.contentData)
        this.vacationData = this.contentData.vacations
        // this.shareData = JSON.parse(this.contentData.shares.content);
        // console.log(this.contentData)
    }
}
</script>

<style>

</style>