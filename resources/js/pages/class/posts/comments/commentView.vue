<template>
  <v-container class="">
    <v-row v-for="(comment, index) in content.comments" :key="index">
      <v-col>
        {{ comment.comments }}
        {{ TimeView(comment.created_at) }}
      </v-col>
    </v-row>
    <v-row style="position: sticky;bottom: 0;">
      <v-col>
        <v-btn fab small class="ma-2" @click="toggleEmo">
          <v-icon>mdi-emoticon-excited-outline</v-icon>
        </v-btn>
        <Picker
          v-if="emoStatus"
          set="emojione"
          @select="onInput"
          title="选择你的表情符号..."
          :showPreview="false"
          :showSearch="false"
          :i18n="emojiI18n"
        />
        <div>
          换行 发送 / shift+
        </div>
      </v-col>
      <v-col>
        <v-textarea
          solo
          name="input-7-4"
          :label="lang.contentPlace"
          @keydown.enter.exact.prevent
          @keyup.enter.exact="submit"
          @keydown.enter.shift.exact="newline"
          v-model="commentText"
        ></v-textarea>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import lang from "~/helper/lang.json";
//emoji
import emojiData from "emoji-mart-vue-fast/data/all.json";
import "emoji-mart-vue-fast/css/emoji-mart.css";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast";
let emojiIndex = new EmojiIndex(emojiData);

import { addComment } from "~/api/post";
import { mapGetters } from "vuex";
export default {
  components: {
    Picker
  },

  computed: {
    ...mapGetters({
      content: "content/postDetail"
    })
  },
  mounted() {
    //console.log(this.content)
  },
  data: () => ({
    lang,
    emoStatus: false,
    commentText: "",
    emojiIndex: emojiIndex,
    emojisOutput: "",
    emojiI18n: {
      search: "Recherche",
      categories: {
        search: "//Search Results",
        recent: "最近常用",
        smileys: "黄脸",
        people: "人和手势",
        nature: "动物和植物",
        foods: "食物",
        activity: "活动",
        places: "交通 ",
        objects: "物品",
        symbols: "标志",
        flags: "国旗",
        custom: "其他"
      }
    }
  }),
  methods: {
    toggleEmo() {
      this.emoStatus = !this.emoStatus;
    },
    onInput(e) {
      if (!e) {
        return false;
      }
      if (!this.commentText) {
        this.commentText = e.native;
      } else {
        this.commentText = this.commentText + e.native;
      }
    },
    newline() {
      this.commentText = `${this.commentText}\n`;
    },
    submit() {
      if (this.commentText == "") {
        return;
      }
      addComment({ text: this.commentText, postId: this.content.id })
        .then(res => {
          //console.log(res)
          this.content.comments.unshift(res.data);
        })
        .catch(err => {
          //console.log(err.response)
        });
      this.commentText = "";
    }
  }
};
</script>

<style></style>
