<template>
    <v-container>
        <v-row class="align-center">
            <v-col cols="12" md="6">
                <v-row class="ma-0 align-center justify-center justify-md-start">
                    <v-avatar class="ma-3 school-card-avatar" tile >
                        <v-img :src="`${baseUrl}/asset/img/icon/公告 拷贝.png`" alt="postItem" ></v-img>
                    </v-avatar>
                    <p class="font-weight-black fs-15 mb-3"> {{lang.regname}}  </p>
                </v-row>
            </v-col>
            <v-col cols="12" md="6">
                <v-row class="ma-0 align-center justify-center justify-md-end" >
                    <v-icon medium color="#7879ff" class="mr-2">mdi-clock-outline </v-icon>
                    <p class="mb-0 mr-8" v-if="contentData !== null">{{TimeView(contentData.created_at)}}</p>
                    <v-icon medium color="#7879ff" class="mr-2">mdi-account </v-icon>
                    <p class="mb-0">{{contentData.users.name}}</p>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
export default {

    data: ()=> ({
        lang,
        regNameData: null,
        baseUrl:window.Laravel.base_url,
    }),

    computed:{
        ...mapGetters({
            contentData: 'content/postDetail'
        })
    },

    created(){
        if(this.contentData == null){
            this.$router.push({name: 'schoolSpace.news'});
        }
        else{
            this.regNameData = this.contentData.regnames;
            this.regNameData.content = JSON.parse(this.regNameData.content)
        }
    }
}
</script>

<style>

</style>