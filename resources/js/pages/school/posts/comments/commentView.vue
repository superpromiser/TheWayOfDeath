<template>
  <v-container v-if="$isMobile()">
    <div>
      <div v-for="(comment,index) in contentData.comments" :key="index">
        <v-row class="ma-0">
          <v-col cols="12" class="d-flex align-center justify-space-between py-1">
              <p class="mb-0 font-size-0-75">{{comment.users.name}}</p>
              <p class="mb-0 font-size-0-75">{{TimeView(comment.created_at)}}</p>
          </v-col>
          <v-col cols="12" lg="9" md="8" sm="6" class="text-wrap font-size-0-75 py-1">{{comment.comments}}</v-col>
        </v-row>
        <v-divider v-if="index < contentData.comments.length -1"></v-divider>
      </div>
    </div>
    
    <!-- <v-row class="ma-0 mb-4">
      <v-col cols="12" class="d-flex align-center position-relative">
        <v-icon class="ml-14" @click="emoStatus = !emoStatus">
          mdi-emoticon-excited-outline
        </v-icon>
        <Picker 
          v-click-outside="outSidePicker" 
          v-if="emoStatus" 
          :data="emojiIndex"
          title="选择你的表情符号..." 
          set="twitter"
          @select="onInput"
          class="position-absolute"
          style="bottom: 45px; z-index:100"
          :showPreview="false"
          :showSearch="false"
          :i18n="emojiI18n"
        />
        <v-spacer></v-spacer>
        <v-btn color="#f89651" dark @click="cancelComment" >
            取消
        </v-btn>
        <v-btn color="#7879ff" class="ml-2" dark :loading="isPosting" @click="postComment" >
            提交评论
        </v-btn>
      </v-col>
    </v-row> -->

    <div id="push-popup-bottom-nav" class="push-popup-bottom-nav">
      <v-row class="bg-secondary ma-0 pa-0 w-100" style="position:absolute; top: -62px; ">
          <v-col cols="12" class="d-flex align-center position-relative" style="border-bottom: 1px solid lightgray;">
              <div class="ch-icon-area d-flex align-center position-relative">
                  <v-icon @click="toggleSheet()" size="30" class="hover-cursor-point mr-4">
                      mdi-emoticon-happy-outline
                  </v-icon>
              </div>
              <v-text-field
                  solo
                  class="mo-select-white-bg"
                  v-model="commentText"
                  :append-outer-icon="'mdi-send'"
                  label="输入内容"
                  dense
                  type="text"
                  hide-details
                  color="#7879ff"
                  ref="textField"
                  :loading="isPosting"
                  @click:append-outer="postComment"
                  @click:clear="cancelComment"
                  @focus="closeWithFocus()"
                  
                  @keydown.enter.exact.prevent 
                  @keyup.enter.exact="newline" 
                  @keydown.enter.shift.exact="postComment" 
                  @keydown.enter.shift.exact.prevent
              ></v-text-field>
          </v-col>
      </v-row>
      <v-sheet class="" color="#F2F2F2">
          <transition name="page" mode="out-in">
              <v-container key="2" class="pa-0" :style="{ transitionDelay: delay }">
                  <Picker 
                      class="w-100 h-350-px" 
                      title="选择你的表情符号..." 
                      set="twitter" 
                      color="#7879ff"
                      :data="emojiIndex" 
                      :showPreview="false"
                      :showSearch="false"
                      :i18n="emojiI18n"
                      @select="onInput" 
                      />
              </v-container>
          </transition>
      </v-sheet>
    </div>
  </v-container>


  <v-container class="px-10" v-else>
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
        <v-divider v-if="index < contentData.comments.length -1"></v-divider>
      </div>
    </div>
    <v-row class="mt-3">
      <v-col cols="12" class="d-flex">        
        <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="#7879ff" size="48">
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
    <Picker 
      v-click-outside="outSidePicker" 
      v-if="emoStatus" 
      :data="emojiIndex" 
      title="选择你的表情符号..." 
      set="twitter" @select="onInput" 
      class="position-absolute" 
      style="bottom: 80px; z-index:100"
      :showPreview="false"
      :showSearch="false"
      :i18n="emojiI18n"
      />
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
    isPosting:false,
    
    emojiI18n: { 
      search: 'Recherche', 
      categories: { 
        search: '//Search Results',
        recent: '最近常用',
        smileys: '黄脸',
        people: '人和手势',
        nature: '动物和植物',
        foods: '食物',
        activity: '活动',
        places: '交通 ',
        objects: '物品',
        symbols: '标志',
        flags: '国旗',
        custom: '其他',
      } 
    },

    delay: "0.25s",
    isOpenSheet : false,

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
      if(this.commentText == ''){
        return this.$snackbar.showMessage({content: this.lang.requireComment, color: "error"})
      }
      this.isPosting = true
      await addComment({text:this.commentText,postId:this.contentData.id}).then(res=>{
        console.log(res)
        this.isPosting = false
        this.contentData.comments.unshift(res.data)
      }).catch(err=>{
        this.isPosting = false
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

    },

    focusTextFields(){
      this.$refs.textField.focus();
    }
    ,
    blurTextFields(){
      this.$refs.textField.blur();
    },

    closeSheet() {
      document.getElementById("push-popup-bottom-nav").style.height = "0";
      this.$store.dispatch('mo/onIsOpenEmojiComment', false);
    },

    showSheet(){
      document.getElementById("push-popup-bottom-nav").style.height = "350px";
      this.$store.dispatch('mo/onIsOpenEmojiComment', true);
    },

    toggleSheet(){
      this.isOpenSheet = !this.isOpenSheet;
      if(this.isOpenSheet == true){
        this.showSheet();
      }
      else{
        this.closeSheet();
        this.focusTextFields();
      }
    },

    closeWithFocus(){
      this.focusTextFields();
      this.closeSheet();
    },

    closeWithBlur(){
      this.blurTextFields();
      this.closeSheet();
    }
  }
};
</script>

<style></style>
