<template>
  <v-container class="px-10">
    <div>
      <div v-for="(comment,index) in content.comments" :key="index">
        <v-row class="py-2">
          <v-col cols="12" lg="1" md="2" sm="2">
              {{comment.users.name}}
          </v-col>
          <v-col cols="12" lg="9" md="8" sm="6" class="text-wrap">{{comment.comments}}</v-col>
          <v-col cols="12" lg="2" md="2" sm="4">
            {{TimeView(comment.created_at)}}
            <v-icon color="#FF5722" @click="remove(comment)" :loading="comment.isDeleting">mdi-trash-can-outline</v-icon>
          </v-col>
        </v-row>
        <v-divider></v-divider>
      </div>
    </div>
    <v-row>
      <v-col class="d-flex">
        <!-- <v-btn
            fab
            small
            class="ma-2"
            @click="toggleEmo"
        >
            <v-icon>mdi-emoticon-excited-outline</v-icon>
        </v-btn> -->
        <Picker 
          v-if="emoStatus" 
          set="emojione" 
          @select="onInput" 
          title="选择你的表情符号..." />
        <v-textarea solo name="input-7-4"
            prepend-inner-icon="mdi-emoticon-excited-outline"
            @click:prepend-inner="toggleEmo"
            :append-icon-cb="toggleEmo" 
            :label="'换行 发送 / shift+'"
            @keydown.enter.exact.prevent 
            @keyup.enter.exact="submit" 
            @keydown.enter.shift.exact="newline" 
            v-model="commentText"
            hide-details
        ></v-textarea>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import { Picker } from 'emoji-mart-vue'
import {addComment,deleteComment} from '~/api/post'
import {mapGetters} from 'vuex'
export default {
  components:{
    Picker,
  },

  computed:{
    ...mapGetters({
      content:'content/postDetail'
    })
  },
  created(){
    this.content.comments.map(comment=>{
      this.$set(comment,'isDeleting',false)
    })
  },
  mounted(){
    console.log(this.content)
  },
  data:() => ({
    lang,
    emoStatus:false,
    commentText:'',
    isDeleting:false,
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
    newline(){
        this.commentText = `${this.commentText}\n`
    },
    submit(){
      if(this.commentText == ''){
        return;
      }
      addComment({text:this.commentText,postId:this.content.id}).then(res=>{
        console.log(res)
        this.content.comments.unshift(res.data)
      }).catch(err=>{
        //console.log(err.response)
      })
      this.commentText = ''
    },
    async remove(comment){
      console.log(comment)
      comment.isDeleting = true
      await deleteComment({id:comment.id}).then(res=>{
        let index = this.content.comments.indexOf(comment)
        if(index > -1){
          this.content.comments.splice(index,1)
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
