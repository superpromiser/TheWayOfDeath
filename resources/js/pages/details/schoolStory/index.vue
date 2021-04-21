<template>
    <v-container>
        <v-row class="justify-center align-center z-index-2 banner-custom ">
            <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
                mdi-chevron-left
            </v-icon>
            <h2 class="py-7">{{lang.schoolStory}}</h2>
        </v-row>
        <v-row class="pl-10 mt-5 ma-0">
            <v-col cols="12">
                <p class="text-wrap"><read-more more-str="全文" :text="schoolStory.text" link="#" less-str="收起" :max-chars="250"></read-more></p>
            </v-col>
            <v-col cols="12" v-if="checkIfAttachExist(schoolStory)">
                <AttachItemViewer :items="schoolStory" />
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
        this.schoolStory = JSON.parse(this.contentData.schoolstory.content);
        console.log(this.contentData)
    }
}
</script>

<style>

</style>