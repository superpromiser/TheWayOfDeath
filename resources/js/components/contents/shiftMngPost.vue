<template>
  <v-container v-if="$isMobile()">
    <v-row>
      <v-col cols="12" class="d-flex" @click="showDetail">
        <v-avatar
          v-if="content.users.name !== '' && content.users.avatar == '/'"
          color="#7879ff"
          size="48"
        >
          <span class="white--text headline">{{ content.users.name[0] }}</span>
        </v-avatar>
        <v-avatar v-else size="48">
          <v-img :src="content.users.avatar"></v-img>
        </v-avatar>
        <div class="ml-2 d-flex flex-column">
          <p
            class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"
          >
            交接班管理
          </p>
          <p class="mb-0 font-size-0-8">
            <span class="font-color-gray"
              >{{ TimeViewMD(content.created_at) }}
            </span>
            {{ content.users.name }}
          </p>
        </div>
      </v-col>
      <v-col cols="12" class="py-0 font-size-0-8">
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>姓名:</strong>
            {{ content.shift_mng.prevName }}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>交接人姓名:</strong>
            {{ content.shift_mng.nextName }}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>归程队成员:</strong>
            {{ TimeViewSam(content.shift_mng.scheduleDate) }}
          </p>
        </div>
        <div class="d-flex align-center">
          <p class="text-wrap mb-0">
            <strong>交接物品:</strong>
            {{ content.shift_mng.itemList }}
          </p>
        </div>
      </v-col>
    </v-row>
  </v-container>
  <v-container v-else>
    <v-col
      cols="12"
      class="d-flex align-center hover-cursor-point"
      @click="showDetail(content)"
    >
      <v-avatar
        v-if="content.users.name !== '' && content.users.avatar == '/'"
        color="#7879ff"
        size="60"
        class="ma-5"
      >
        <span class="white--text headline">{{ content.users.name[0] }}</span>
      </v-avatar>
      <v-avatar v-else class="ma-5" size="60">
        <v-img :src="content.users.avatar"></v-img>
      </v-avatar>
      <div>
        <p class="font-weight-black fs-15 mb-3">交接班管理</p>
        <div class="d-flex align-center">
          <v-icon medium color="#7879ff" class="mr-2"
            >mdi-clock-outline
          </v-icon>
          <p class="mb-0 mr-8">{{ TimeView(content.created_at) }}</p>
          <v-icon medium color="#7879ff" class="mr-2">mdi-account </v-icon>
          <p class="mb-0">{{ content.users.name }}</p>
        </div>
      </div>
      <div
        class="ml-auto"
        v-if="user.roleId < 3 || content.users.id == user.id"
      >
        <v-menu offset-y>
          <template v-slot:activator="{ attrs, on }">
            <v-btn icon color="#7879ff" v-bind="attrs" v-on="on">
              <v-icon size="30">mdi-chevron-down </v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item link v-if="user.roleId < 3">
              <v-list-item-title
                class="px-2"
                @click="fixTop(content)"
                v-if="content.fixTop == null"
                >{{ lang.toTop }}</v-list-item-title
              >
              <v-list-item-title
                class="px-2"
                @click="relaseTop(content.id)"
                v-else
                >{{ lang.toRelase }}</v-list-item-title
              >
            </v-list-item>
            <v-list-item link>
              <v-list-item-title class="px-2" @click="postRemove(content)">{{
                lang.remove
              }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-col>
    <v-col cols="12" class="pl-10 pt-0">
      <div class="d-flex align-center">
        <p class="text-wrap mb-0">
          <strong>交班人:</strong>
          {{ content.shift_mng.prevName }}
        </p>
      </div>
      <div class="d-flex align-center">
        <p class="text-wrap mb-0">
          <strong>接班人:</strong>
          {{ content.shift_mng.nextName }}
        </p>
      </div>
      <div class="d-flex align-center">
        <p class="text-wrap mb-0">
          <strong>交班时间:</strong>
          {{ TimeViewSam(content.shift_mng.scheduleDate) }}
        </p>
      </div>
      <div class="d-flex align-center">
        <p class="text-wrap mb-0">
          <strong>交接物品:</strong>
          {{ content.shift_mng.itemList }}
        </p>
      </div>
      <div class="d-flex align-center" v-if="content.shift_mng.confirmDate">
        <p class="text-wrap mb-0"></p>
        <strong>接班时间</strong>
        {{ content.shift_mng.confirmDate }}
      </div>
    </v-col>
  </v-container>
</template>

<script>
import lang from "~/helper/lang.json";
import { createReadCnt } from "~/api/alarm";
import AttachItemViewer from "~/components/attachItemViewer";
import { mapGetters } from "vuex";
export default {
  components: {
    AttachItemViewer
  },

  props: {
    content: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    lang,
    baseUrl: window.Laravel.base_url,
    smsData: {}
  }),

  created() {},
  computed: {
    currentPath() {
      return this.$route;
    },
    ...mapGetters({
      user: "auth/user",
      selectedSchoolItem: "mo/selectedSchoolItem"
    })
  },
  methods: {
    showDetail(content) {
      createReadCnt({ postId: content.id })
        .then(res => {})
        .catch(err => {
          console.log(err.response);
        });
      this.$store.dispatch("content/storePostDetail", this.content);
      if (this.$isMobile()) {
        if (this.selectedSchoolItem.type == "school") {
          this.$router.push({
            name: "details.schoolDefault",
            params: { schoolId: this.selectedSchoolItem.schoolId }
          });
        } else {
          this.$router.push({
            name: "details.classDefault",
            params: {
              schoolId: this.selectedSchoolItem.schoolId,
              gradeId: this.selectedSchoolItem.gradeId,
              lessonId: this.selectedSchoolItem.lessonId
            }
          });
        }
      } else {
        if (this.currentPath.params.lessonId) {
          this.$router.push({ name: "details.classDefault" });
        } else {
          this.$router.push({ name: "details.schoolDefault" });
        }
      }
    }
  }
};
</script>

<style></style>
