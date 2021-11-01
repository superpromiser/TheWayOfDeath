<template>
  <v-container class="pa-0" v-if="$isMobile()">
    <v-container class="pa-0 h-100 bg-white mb-16 pb-3 pt-12">
      <v-row class="ma-0 bg-white justify-center position-sticky-top-0">
        <v-icon
          @click="$router.go(-1)"
          size="35"
          class="position-absolute put-align-center"
          style="left: 0px; top:50%"
        >
          mdi-chevron-left
        </v-icon>
        <p class="mb-0 font-size-0-95 font-weight-bold pa-3">请假</p>
        <v-btn
          @click="postVacationData"
          :loading="isLoading"
          text
          color="#7879ff"
          class="position-absolute put-align-center"
          style="right: 0px; top:50%"
        >
          {{ lang.submit }}
        </v-btn>
      </v-row>
      <div class="cus-divider-light-gray-height"></div>
      <v-row class="ma-0">
        <v-col cols="12" sm="6">
          <v-text-field
            color="#7879ff"
            v-model="newVacationData.studentName"
            label="请假人"
            hide-details
            class="mt-0 pt-0"
            readonly
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="6">
          <v-text-field
            color="#7879ff"
            v-model="newVacationData.teacherName"
            label="审批人"
            hide-details
            class="mt-0 pt-0"
            readonly
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="6">
          <v-datetime-picker
            label="开始时间"
            v-model="newVacationData.startTime"
            :okText="lang.ok"
            :clearText="lang.cancel"
          >
          </v-datetime-picker>
        </v-col>
        <v-col cols="12" sm="6">
          <v-datetime-picker
            label="结束时间"
            v-model="newVacationData.endTime"
            :okText="lang.ok"
            :clearText="lang.cancel"
          >
          </v-datetime-picker>
        </v-col>
        <v-col cols="12" sm="6">
          <v-textarea
            color="#7879ff"
            v-model="newVacationData.reason"
            label="请假原因"
            hide-details
            class="mt-0 pt-0"
          ></v-textarea>
        </v-col>
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <p
            @click="newVacationData.reasonFlag = false"
            class="mb-0 font-size-0-8  pa-3 mo-glow"
          >
            病假
          </p>
          <v-switch
            v-model="newVacationData.reasonFlag"
            color="error"
            hide-details
            class="pt-0 mt-0"
          ></v-switch>
          <p
            @click="newVacationData.reasonFlag = true"
            class="mb-0 font-size-0-8 pa-3 mo-glow"
          >
            事假
          </p>
        </v-col>

        <transition name="page" mode="out-in">
          <v-col cols="12" v-if="newVacationData.reasonFlag == false">
            <v-checkbox
              v-model="newVacationData.isHeat"
              label="是否发热"
              color="error"
              hide-details
            ></v-checkbox>
          </v-col>
        </transition>
        <transition name="page" mode="out-in">
          <v-col cols="12" v-if="newVacationData.reasonFlag == false">
            <v-textarea
              color="#7879ff"
              v-model="newVacationData.painDesc"
              label="症状"
              hide-details
              class="mt-0 pt-0"
            ></v-textarea>
          </v-col>
        </transition>
      </v-row>
    </v-container>
  </v-container>
  <v-container class="pa-0" v-else>
    <v-container class="banner-custom mb-10 z-index-2">
      <v-row>
        <v-col cols="6" md="4" class="d-flex align-center position-relative">
          <a @click="$router.go(-1)">
            <v-icon size="70">
              mdi-chevron-left
            </v-icon>
          </a>
        </v-col>
        <v-col
          cols="6"
          md="4"
          class="d-flex align-center justify-start justify-md-center"
        >
          <h2>请假</h2>
        </v-col>
        <v-col cols="12" md="4" class="d-flex align-center justify-end">
          <v-btn
            tile
            color="#7879ff"
            dark
            class="mr-5"
            :loading="isLoading"
            @click="postVacationData"
          >
            <v-icon left>
              mdi-book-plus
            </v-icon>
            提交
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
    <v-container class="pa-10">
      <v-row>
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <span class="mr-14">请假人</span>
          <v-text-field
            solo
            v-model="newVacationData.studentName"
            label="请假人"
            hide-details
            readonly
          ></v-text-field>
        </v-col>
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <span class="mr-14">审批人</span>
          <v-text-field
            solo
            v-model="newVacationData.teacherName"
            label="审批人"
            hide-details
            readonly
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <span class="mr-10">开始时间</span>
          <v-datetime-picker
            label="开始时间"
            v-model="newVacationData.startTime"
            :okText="lang.ok"
            :clearText="lang.cancel"
          >
          </v-datetime-picker>
        </v-col>
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <span class="mr-10">结束时间</span>
          <v-datetime-picker
            label="结束时间"
            v-model="newVacationData.endTime"
            :okText="lang.ok"
            :clearText="lang.cancel"
          >
          </v-datetime-picker>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" class="d-flex justify-space-between align-start">
          <span class="mr-10 mt-3">请假原因</span>
          <v-textarea
            solo
            v-model="newVacationData.reason"
            label="请假原因"
            hide-details
          ></v-textarea>
        </v-col>
      </v-row>
      <v-row class="d-flex justify-center">
        <v-col cols="12" sm="6" class="d-flex justify-space-around">
          <span
            @click="newVacationData.reasonFlag = false"
            class="hover-cursor-point"
            >病假</span
          >
          <v-switch
            v-model="newVacationData.reasonFlag"
            color="#7879ff"
            hide-details
            inset
            class="pt-0 mt-0"
          ></v-switch>
          <span
            @click="newVacationData.reasonFlag = true"
            class="hover-cursor-point"
            >事假</span
          >
        </v-col>
      </v-row>
      <transition
        v-if="newVacationData.reasonFlag == false"
        name="page"
        mode="out-in"
      >
        <v-row>
          <v-col cols="12">
            <v-checkbox
              v-model="newVacationData.isHeat"
              label="是否发热"
              color="error"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12" class="d-flex justify-space-between align-start">
            <span class="mr-10 mt-3">症状</span>
            <v-textarea
              solo
              v-model="newVacationData.painDesc"
              label="症状"
              hide-details
            ></v-textarea>
          </v-col>
        </v-row>
      </transition>
    </v-container>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";
import lang from "~/helper/lang.json";
import { getBanziName, createVacationData } from "~/api/vacation";
export default {
  data: () => ({
    lang,
    baseUrl: window.Laravel.base_url,
    newVacationData: {
      studentName: "",
      teacherName: "",
      reasonFlag: true,
      startTime: new Date(),
      endTime: "",
      reason: "",
      painDesc: "",
      isHeat: false,
      teacherId: null,
      schoolId: null,
      lessonId: null
    },
    isLoading: false
  }),

  components: {},

  computed: {
    ...mapGetters({
      user: "auth/user"
    }),
    currentPath() {
      return this.$route;
    }
  },

  created() {
    //you need to get teacher's name from server or vuex...
    // this.newVacationData.teacherName = this.....
    getBanziName()
      .then(res => {
        console.log(res.data);
        this.newVacationData.teacherName = res.data.name;
        this.newVacationData.teacherId = res.data.id;
      })
      .catch(err => {
        console.log(err.response);
      });
    this.newVacationData.studentName = this.user.name;
    this.newVacationData.schoolId = this.currentPath.params.schoolId;
    this.newVacationData.lessonId = this.currentPath.params.lessonId;
  },

  mounted() {},

  methods: {
    async postVacationData() {
      console.log(this.newVacationData);
      if (this.newVacationData.startTime == "") {
        return this.$snackbar.showMessage({
          content: this.lang.requireStartTime,
          color: "error"
        });
      }
      if (this.newVacationData.endTime == "") {
        return this.$snackbar.showMessage({
          content: this.lang.requireDeadline,
          color: "error"
        });
      }
      if (
        this.newVacationData.isHeat == true &&
        this.newVacationData.painDesc == ""
      ) {
        return this.$snackbar.showMessage({
          content: this.lang.requirePainDesc,
          color: "error"
        });
      }
      if (this.newVacationData.endTime < this.newVacationData.startTime) {
        return this.$snackbar.showMessage({
          content: this.lang.startTimeAndEndTime,
          color: "error"
        });
      }
      if (this.newVacationData.reason.trim() == "") {
        return this.$snackbar.showMessage({
          content: this.lang.vacationReason,
          color: "error"
        });
      }
      this.isLoading = true;
      await createVacationData(this.newVacationData)
        .then(res => {
          console.log(res.data);
          this.isLoading = false;
          if (this.$isMobile()) {
            this.$router.push({ name: "home" });
          } else {
            this.$router.push({ name: "classSpace.news" });
          }
        })
        .catch(err => {
          this.isLoading = false;
          console.log(err.response);
        });
    }
  }
};
</script>

<style></style>
