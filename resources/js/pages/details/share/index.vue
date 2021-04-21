<template>
    <v-container>
        <v-row class="justify-center align-center z-index-2 banner-custom position-relative">
            <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
                mdi-chevron-left
            </v-icon>
            <h2 class="py-7">{{lang.share}}</h2>
        </v-row>
        <v-row class="pl-10 pt-0">
            <v-col cols="12">
                <p class="text-wrap"><read-more more-str="全文" :text="shareData[0].text" link="#" less-str="收起" :max-chars="250"></read-more></p>
            </v-col>
            <v-col cols="12" v-if="checkIfAttachExist(shareData[0])">
                <AttachItemViewer :items="shareData[0]" />
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
        shareData: {},
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
        this.shareData = JSON.parse(this.contentData.shares.content);
        console.log(this.contentData)
    }
}
</script>

<style>

</style>