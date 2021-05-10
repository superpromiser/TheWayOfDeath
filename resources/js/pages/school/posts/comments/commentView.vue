<template>
  <v-container class="px-10">
    <div>
      <div v-for="(comment,index) in contentData.comments" :key="index">
        <v-row class="py-2">
          <v-col cols="12" lg="1" md="2" sm="2">
              {{comment.users.name}}
          </v-col>
          <v-col cols="12" lg="9" md="8" sm="6" class="text-wrap">{{comment.comments}}</v-col>
          <v-col cols="12" lg="2" md="2" sm="4" class="text-right">
            {{TimeView(comment.created_at)}}
            <!-- <v-icon color="#FF5722" @click="remove(comment)" :loading="comment.isDeleting">mdi-trash-can-outline</v-icon> -->
          </v-col>
        </v-row>
        <v-divider></v-divider>
      </div>
    </div>
    <v-row class="mt-3">
      <v-col cols="12" class="d-flex">        
        <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="primary" size="48">
          <span class="white--text headline">{{user.name[0]}}</span>
        </v-avatar>
        <v-avatar v-else
          size="48"
        >
          <v-img :src="user.avatar"></v-img>
        </v-avatar>
        <v-textarea solo name="input-7-4"
            :append-icon-cb="toggleEmo" 
            :label="''"
            v-model="commentText"
            hide-details
            class="ml-2"
        ></v-textarea>
        
      </v-col>
    </v-row>
    <Picker v-click-outside="outSidePicker" v-if="emoStatus" :data="emojiIndex" title="选择你的表情符号..." set="twitter" @select="onInput" class="position-absolute" style="bottom: 80px; z-index:100" />
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
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import { Picker, EmojiIndex } from "emoji-mart-vue-fast";
import "emoji-mart-vue-fast/css/emoji-mart.css";
import emojiData from "emoji-mart-vue-fast/data/all.json";
let emojiIndex = new EmojiIndex(emojiData);

import {addComment,deleteComment} from '~/api/post'
import {mapGetters} from 'vuex'
export default {
  components:{
    Picker,
  },

  computed:{
    ...mapGetters({
      contentData:'content/postDetail',
      user:'auth/user'
    })
  },
  created(){
    this.contentData.comments.map(comment=>{
      this.$set(comment,'isDeleting',false)
    })
  },
  mounted(){
    console.log('-------------------',this.contentData)
  },
  data:() => ({
    lang,
    emoStatus:false,
    commentText:'',
    isDeleting:false,
    emojiIndex: emojiIndex,
    isPosting:false
  }),
  methods:{
    toggleEmo(){
      this.emoStatus = ! this.emoStatus
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
    newline(){
        this.commentText = `${this.commentText}\n`
    },
    async postComment(){
      this.isPosting = true
      if(this.commentText == ''){
        return;
      }
      await addComment({text:this.commentText,postId:this.contentData.id}).then(res=>{
        console.log(res)
        this.isPosting = false
        this.contentData.comments.unshift(res.data)
      }).catch(err=>{
        this.isPosting = false
        //console.log(err.response)
      })
      this.commentText = ''
    },
    cancelComment(){
      this.commentText = ''
    },
    async remove(comment){
      console.log(comment)
      comment.isDeleting = true
      await deleteComment({id:comment.id}).then(res=>{
        let index = this.contentData.comments.indexOf(comment)
        if(index > -1){
          this.contentData.comments.splice(index,1)
        }
        comment.isDeleting = false
        console.log(res.data)
      }).catch(err=>{
        console.log(err.response)
        comment.isDeleting = false
      })

    }
  }
};
</script>

<style></style>
