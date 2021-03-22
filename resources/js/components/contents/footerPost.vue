<template>
    <v-col cols="12" class="pt-2">
        <div class="d-flex align-center justify-end mb-5">
            <v-icon medium color="primary" class="mr-2">mdi-eye</v-icon>
                <p class="mb-0 mr-8" v-if="footerInfo.views.length > 0">{{footerInfo.views.length}}人</p>
                <p class="mb-0 mr-8" v-else>0人</p>
            <v-btn icon color="red accent-3" :loading="isLiking">
                <v-icon size="25" v-if="footerInfo.isLiked" @click="removeLike">mdi-heart </v-icon>
                <v-icon size="25" v-else @click="addLike">mdi-heart-outline </v-icon>
            </v-btn>
            <span class="mr-8">{{footerInfo.likes.length > 0 ? footerInfo.likes.length : 0}}</span>
            <v-btn icon color="success" >
                <v-icon size="25" @click="addComment">mdi-comment-outline</v-icon>
            </v-btn>
            <span>{{footerInfo.comments.length > 0 ? footerInfo.comments.length : 0}}</span>
        </div>
        <v-divider></v-divider>
    </v-col>
</template>

<script>
import {addLike,removeLike} from '~/api/post'
import {mapGetters} from 'vuex';
export default {
    props:{
        footerInfo:{
            type:Object,
            required:true
        }
    },
    computed:{
        ...mapGetters({
            user:'auth/user'
        })
    },
    data: ()=> ({
        isLiking : false,
        isDisLiking : false,
    }),
    mounted(){
        console.log('+++++',this.footerInfo.likes)
        let index = this.footerInfo.likes.map(x=>{
            return x.userId
        }).indexOf(this.user.id)
        if(index > -1){
            this.$set(this.footerInfo,'isLiked',true)
        }
    },
    methods :{
        async addLike(){
            this.isLiking = true;
            await addLike({postId:this.footerInfo.id}).then(res=>{
                this.footerInfo.likes.push(res)
                this.$set(this.footerInfo,'isLiked',true)
                console.log(this.footerInfo.likes)
            }).catch(err=>{
                console.log(err.response)
            })
            this.isLiking = false;
        },
        async removeLike(){
            this.isLiking = true;
            await removeLike({postId:this.footerInfo.id}).then(res=>{
                let index = this.footerInfo.likes.map(x=>{
                    return x.userId
                }).indexOf(this.user.id)
                this.footerInfo.likes.splice(index,1)
                delete this.footerInfo['isLiked'];
                console.log(this.footerInfo.likes)
            }).catch(err=>{
                console.log(err.response)
            })
            this.isLiking = false;
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