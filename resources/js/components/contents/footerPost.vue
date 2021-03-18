<template>
    <v-col cols="12" class="pt-2">
        <div class="d-flex align-center justify-end">
            <v-icon medium color="primary" class="mr-2">mdi-eye</v-icon>
                <p class="mb-0 mr-8">{{footerInfo.viewCnt}}人</p>
            <v-btn icon color="red accent-3" >
                <v-icon size="30" v-if="footerInfo.isLiked" @click="clickLike(false)">mdi-heart </v-icon>
                <v-icon size="30" v-else @click="clickLike(true)">mdi-heart-outline </v-icon>
                {{footerInfo.likeCnt > 0 ? footerInfo.likeCnt : ''}}
            </v-btn>
            <v-btn icon color="success" >
                <v-icon size="30" @click="addComment">mdi-message-outline</v-icon>
                {{footerInfo.commentCnt > 0 ? footerInfo.commentCnt : ''}}
            </v-btn>
        </div>
        <div class="divider"></div>
    </v-col>
</template>

<script>
import {likeAction} from '~/api/post'
export default {
    props:{
        footerInfo:{
            type:Object,
            required:true
        }
    },
    mounted(){
        console.log(this.footerInfo)
    },
    methods :{
        clickLike(flag){
            this.footerInfo.isLiked = flag
            this.footerInfo.likeCnt = flag ? this.footerInfo.likeCnt + 1 : this.footerInfo.likeCnt - 1;
            this.$emit('updateFooterInfo',this.footerInfo);
            likeAction(this.footerInfo).then(res=>{
                console.log('success',res)
            }).catch(err=>{
                console.log(err.response)
            })
        },
        addComment(){
            this.$store.dispatch('content/storePostDetail',this.footerInfo)
            this.$router.push({name:'posts.comment'});
        }
    }
}
</script>

<style>

</style>