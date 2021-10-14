<template>
  <v-container v-if="$isMobile()">
    <v-row>
      <v-col cols="12" class="d-flex" @click="showDetail(content)">
        <v-avatar>
          <v-img
            :src="`${baseUrl}/asset/img/icon/通知 拷贝.png`"
            alt="postItem"
          ></v-img>
        </v-avatar>
        <div class="ml-2 d-flex flex-column">
          <p
            class="mb-0 font-size-0-95 font-weight-bold mb-auto primary-font-color"
          >
            {{ lang.notification }}
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
        <p class="text-wrap mb-0">
          <strong>标题:</strong>
          {{ content.notifications.title }}
        </p>
        <p class="text-wrap mb-0">
          <strong>公告标题:</strong>
          {{ content.notifications.signName }}
        </p>
      </v-col>
    </v-row>
  </v-container>
  <v-container v-else>
    <v-col
      cols="12"
      class="d-flex align-cente hover-cursor-point"
      @click="showDetail(content)"
    >
      <v-avatar class="ma-3 school-card-avatar" tile>
        <v-img
          :src="`${baseUrl}/asset/img/icon/通知 拷贝.png`"
          alt="postItem"
        ></v-img>
      </v-avatar>
      <div>
        <p class="font-weight-black fs-15 mb-3">{{ lang.notification }}</p>
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
      <p class="text-wrap mb-0">
        <strong>标题:</strong>
        {{ content.notifications.title }}
      </p>
      <p class="text-wrap mb-0">
        <strong>公告标题:</strong>
        {{ content.notifications.signName }}
      </p>
      <!-- <p class="text-wrap mb-0">
            <strong>公告标题:</strong>
            {{content.notifications.signName}}
          </p>
          <v-col cols="12" v-if="checkIfAttachExist(attachItem)">
            <AttachItemViewer :items="attachItem" />
          </v-col> -->
    </v-col>
  </v-container>
</template>

<script>
import lang from "~/helper/lang.json";
import AttachItemViewer from "~/components/attachItemViewer";
import { createReadCnt } from "~/api/alarm";
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
    attachItem: null
  }),

  created() {
    this.attachItem = JSON.parse(this.content.notifications.description);
  },
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
      this.$store.dispatch("content/storePostDetail", content);
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
