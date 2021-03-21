<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.questionnaire}}</h2>
            </div>
            <template v-slot:actions>
                <v-btn
                    dark
                    color="green lighten-1"
                    class="mr-8"
                    tile
                    @click="saveDraft"
                >
                    已答
                    <v-icon right>
                        mdi-chevron-right
                    </v-icon>
                </v-btn>
            </template>
        </v-banner>
        <!----title---->
        <v-row>
            <v-col cols="12" class="d-flex justify-center align-center">
                <h2>{{contentData.questionnaires.title}}</h2>
            </v-col>
            <v-col cols="12" class="px-5 px-md-10">
                <p>{{contentData.questionnaires.desc}}</p>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        baseUrl:window.Laravel.base_url,
        lang,

    }),

    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail'
        })
    },

    mounted(){
        console.log("this.currentpath",this.currentpath)
        console.log("this.contentData",this.contentData)
        this.contentData.questionnaires.content = JSON.parse(this.contentData.questionnaires.content);
    }
}
</script>

<style>

</style>