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
                        <v-icon size="20" @click="showComment">mdi-comment-outline</v-icon>
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
            <!-- <v-menu
                top
                :close-on-click="true"
                >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        @click="showReadUsers"
                        dark
                        v-bind="attrs"
                        v-on="on"
                        icon color="blue accent-3" 
                        :loading="isReadCnt"
                    >
                        <v-icon medium color="primary" class="mr-2">mdi-eye</v-icon>
                        <p class="mb-0 mr-8">{{footerInfo.readList ? footerInfo.readList.length : 0}}人</p>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item
                    v-for="user in readUsers" :key="user.id"
                    >
                        <v-list-item-title>
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
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu> -->
            <v-btn @click="showReadUsers" icon color="blue accent-3" :loading="isReadCnt" >
                <v-icon medium color="primary" class="mr-2">mdi-eye</v-icon>
                <p class="mb-0 mr-8">{{footerInfo.readList ? footerInfo.readList.length : 0}}人</p>
            </v-btn>
            <v-btn icon color="red accent-3" :loading="isLiking">
                <v-icon size="25" v-if="footerInfo.isLiked" @click="removeLike">mdi-heart </v-icon>
                <v-icon size="25" v-else @click="addLike">mdi-heart-outline </v-icon>
            </v-btn>
            <span class="mr-8">{{footerInfo.likes.length > 0 ? footerInfo.likes.length : 0}}</span>
            <v-btn icon color="success" >
                <v-icon size="25" @click="showComment">mdi-comment-outline</v-icon>
            </v-btn>
            <span>{{footerInfo.comments.length > 0 ? footerInfo.comments.length : 0}}</span>
        </div>
        <div v-if="isComment == true" class="position-relative">
            <v-row>
                <v-col cols="12" class="d-flex">
                    <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="primary" size="48">
                        <span class="white--text headline">{{user.name[0]}}</span>
                        </v-avatar>
                        <v-avatar v-else
                    size="48"
                    >
                        <v-img :src="user.avatar"></v-img>
                    </v-avatar>
                    <v-textarea
                        solo
                        name="input-7-4"
                        label=""
                        class="ml-2"
                        v-model="commentText"
                        hide-details
                    ></v-textarea>
                </v-col>
            </v-row>
            <Picker v-click-outside="outSidePicker" v-if="emoStatus" :data="emojiIndex" title="选择你的表情符号..." set="twitter" @select="onInput" class="position-absolute" style="bottom: 71px" />
            <v-row class="d-flex justify-space-between my-5">
                <v-col cols="6">
                    <v-icon @click="emoStatus = !emoStatus">
                        mdi-emoticon-excited-outline
                    </v-icon>
                </v-col>
                <v-col cols="6" class="text-right">
                    <v-btn
                        color="#f89651"
                        dark
                        @click="cancelComment"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="#7879ff"
                        class="ml-2"
                        dark
                        :loading="isPosting"
                        @click="postComment"
                    >
                        提交评论
                    </v-btn>
                </v-col>
            </v-row>
        </div>
        <v-divider class="thick-border" light></v-divider>
        <v-row justify="center">
            <v-dialog
                v-model="dialog"
                max-width="500"
                height="150"
            >
                <v-card>
                    <v-card-title class="headline grey lighten-2">
                    已读
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="6" v-for="user in readUsers" :key="user.id" style="width:50px">
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
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-row>
    </v-col>
</template>

<script>
import {addLike,removeLike} from '~/api/post'
import {mapGetters} from 'vuex';
import {getReadCnt} from '~/api/alarm'
import {addComment,deleteComment} from '~/api/post'

import { Picker, EmojiIndex } from "emoji-mart-vue-fast";
import "emoji-mart-vue-fast/css/emoji-mart.css";
import emojiData from "emoji-mart-vue-fast/data/all.json";
let emojiIndex = new EmojiIndex(emojiData);
export default {
    props:{
        footerInfo:{
            type:Object,
            required:true
        }
    },
    components:{
        Picker
    },
    computed:{
        ...mapGetters({
            user:'auth/user',
            selectedSchoolItem: 'mo/selectedSchoolItem'
        })
    },
    data: ()=> ({
        fab: false,
        isReadCnt:false,
        isLiking : false,
        isDisLiking : false,
        dialog:false,
        readUsers:[],
        commentText:'',
        isComment:false,
        emoStatus:false,
        emojiIndex: emojiIndex,
        isPosting:false
    }),
    created(){
        console.log("this.footerInfo",this.footerInfo)
        console.log("!!!!!!!!!!!", this.selectedSchoolItem);
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
        
        showComment(){
            console.log('add comment---------------')
            this.isComment = ! this.isComment
        },
        onInput(e){
            if(!e){
                return false;
            }
            if(!this.commentText){
                this.commentText = e.native
            }else{
                this.commentText = this.commentText + e.native
            }
        },
        outSidePicker(){
            this.emoStatus = false;
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
        },
        postComment(){
            this.isPosting = true
            addComment({text:this.commentText,postId:this.footerInfo.id}).then(res=>{
                console.log(res)
                this.isPosting = false
                this.footerInfo.comments.unshift(res.data)
            }).catch(err=>{
                this.isPosting = false
                //console.log(err.response)
            })
            this.commentText = ''
        },
        cancelComment(){
            this.commentText = ''
            this.emoStatus = false
            this.isComment = false
        }
    }
}
</script>

<style>

</style>