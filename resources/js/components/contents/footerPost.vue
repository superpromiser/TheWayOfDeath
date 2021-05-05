<template>
    <v-col cols="12" class="py-2 pt-0" v-if="$isMobile()">
        <div class="d-flex align-center justify-space-between">
            <p class="mb-0 font-size-0-8" v-if="footerInfo.views.length > 0">浏览{{footerInfo.views.length}}次</p>
            <p class="mb-0 font-size-0-8" v-else>浏览0次</p>
            <v-speed-dial
                v-model="fab"
                direction="left"
                transition="slide-x-reverse-transition"
                class="mo-news-item-fab"
            >
                <template v-slot:activator>
                    <v-btn icon>
                        <v-icon>mdi-dots-horizontal </v-icon>
                    </v-btn>
                </template>
                <div class="d-flex align-center ">
                    <v-btn icon color="red accent-3" :loading="isLiking">
                        <v-icon size="20" v-if="footerInfo.isLiked" @click="removeLike">mdi-heart </v-icon>
                        <v-icon size="20" v-else @click="addLike">mdi-heart-outline </v-icon>
                    </v-btn>
                    <span>{{footerInfo.likes.length > 0 ? footerInfo.likes.length : 0}}</span>
                </div>
                <div class="d-flex align-center">
                    <v-btn icon color="success" >
                        <v-icon size="20" @click="addComment">mdi-comment-outline</v-icon>
                    </v-btn>
                    <!-- <span class="font-size-0-8 font-color-white">评论</span> -->
                    <span>{{footerInfo.comments.length > 0 ? footerInfo.comments.length : 0}}</span>
                </div>
            </v-speed-dial>
        </div>
        <v-divider></v-divider>
    </v-col>
    <v-col cols="12" class="pt-2 px-10" v-else>
        <div class="d-flex align-center justify-end mb-5">
            <v-btn @click="showReadUsers" icon color="blue accent-3" :loading="isReadCnt" >
                <v-icon medium color="primary" class="mr-2">mdi-eye</v-icon>
                <p class="mb-0 mr-8" v-if="footerInfo.readList!==null&&footerInfo.readList.length > 0">{{footerInfo.readList.length}}人</p>
                <p class="mb-0 mr-8" v-else>0人</p>
            </v-btn>
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
        <v-divider class="thick-border" light></v-divider>
        <v-row justify="center">
            <v-dialog
                v-model="dialog"
                max-width="290"
            >
                <v-row>
                    <v-col v-for="user in readUsers" :key="user.id" style="width:50px">
                        <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="primary" size="50" class="ma-5">
                            <span class="white--text headline">{{user.name[0]}}</span>
                        </v-avatar>
                        <v-avatar v-else
                        class="ma-5"
                        size="50"
                        >
                            <v-img :src="user.avatar"></v-img>
                        </v-avatar>
                        <span>{{user.name}}</span>
                    </v-col>
                </v-row>
            </v-dialog>
        </v-row>
    </v-col>
</template>

<script>
import {addLike,removeLike} from '~/api/post'
import {mapGetters} from 'vuex';
import {getReadCnt} from '~/api/alarm'
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
        fab: false,
        isReadCnt:false,
        isLiking : false,
        isDisLiking : false,
        dialog:false,
        readUsers:[],
    }),
    created(){
        console.log("this.footerInfo",this.footerInfo)
    },
    mounted(){
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
            this.fab = true;
            await addLike({postId:this.footerInfo.id}).then(res=>{
                this.footerInfo.likes.push(res)
                this.$set(this.footerInfo,'isLiked',true)
            }).catch(err=>{
                //console.log(err.response)
            })
            this.isLiking = false;
            this.fab = false;
        },
        async removeLike(){
            this.isLiking = true;
            this.fab = true;
            await removeLike({postId:this.footerInfo.id}).then(res=>{
                let index = this.footerInfo.likes.map(x=>{
                    return x.userId
                }).indexOf(this.user.id)
                this.footerInfo.likes.splice(index,1)
                delete this.footerInfo['isLiked'];
            }).catch(err=>{
                //console.log(err.response)
            })
            this.isLiking = false;
            this.fab = false;
        },
        
        addComment(){
            this.$store.dispatch('content/storePostDetail',this.footerInfo)
            this.$router.push({name:'posts.comment'});
        },

        async showReadUsers(){
            this.isReadCnt = true
            console.log(this.footerInfo.readList)
            await getReadCnt({userList:this.footerInfo.readList}).then(res=>{
                this.isReadCnt = false
                this.dialog = true
                console.log(res.data)
                this.readUsers = res.data
            }).catch(err=>{
                this.isReadCnt = false
                console.log(err.response)
            })

        }
    }
}
</script>

<style>

</style>