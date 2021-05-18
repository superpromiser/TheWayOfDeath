<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()" >
        <v-container class="pt-0 px-0 h-100 bg-white pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >交接班管理</p>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0">
                <v-col class="d-flex align-center" cols="12">
                    <p class="text-wrap mb-0">
                    <strong>姓名:</strong>
                    {{contentData.shift_mng.prevName}}
                    </p>
                </v-col>
                <v-col class="d-flex align-center" cols="12">
                    <p class="text-wrap mb-0">
                    <strong>交接人姓名:</strong>
                    {{contentData.shift_mng.nextName}}
                    </p>
                </v-col>
                <v-col class="d-flex align-center" cols="12">
                    <p class="text-wrap mb-0">
                    <strong>归程队成员:</strong>
                    {{TimeViewSam(contentData.shift_mng.scheduleDate)}}
                    </p>
                </v-col>
                <v-col class="d-flex align-center" cols="12">
                    <p class="text-wrap mb-0">
                    <strong>交接物品:</strong>
                    {{contentData.shift_mng.itemList}}
                    </p>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
    <v-container v-else>
        <v-row class="justify-center align-center z-index-2 banner-custom ">
            <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
                mdi-chevron-left
            </v-icon>
            <h2 class="py-7">交接班管理</h2>
        </v-row>
        <v-row class="pl-10 mt-5 ma-0">
            <v-col class="d-flex align-center" cols="12">
                <p class="text-wrap mb-0">
                <strong>姓名:</strong>
                {{contentData.shift_mng.prevName}}
                </p>
            </v-col>
            <v-col class="d-flex align-center" cols="12">
                <p class="text-wrap mb-0">
                <strong>交接人姓名:</strong>
                {{contentData.shift_mng.nextName}}
                </p>
            </v-col>
            <v-col class="d-flex align-center" cols="12">
                <p class="text-wrap mb-0">
                <strong>归程队成员:</strong>
                {{TimeViewSam(contentData.shift_mng.scheduleDate)}}
                </p>
            </v-col>
            <v-col class="d-flex align-center" cols="12">
                <p class="text-wrap mb-0">
                <strong>交接物品:</strong>
                {{contentData.shift_mng.itemList}}
                </p>
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
        shiftMng: {},
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
    }
}
</script>

<style>

</style>