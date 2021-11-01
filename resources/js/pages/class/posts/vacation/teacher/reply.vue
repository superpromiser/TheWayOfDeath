<template>
  <v-container class="pa-0" v-if="$isMobile()">
    <v-container class="pt-0 px-0 h-100 bg-white mb-16 pb-10-px pt-12">
      <v-row class="ma-0 bg-white justify-center position-sticky-top-0">
        <v-icon
          @click="$router.go(-1)"
          size="35"
          class="position-absolute put-align-center"
          style="left: 0px; top:50%"
        >
          mdi-chevron-left
        </v-icon>
        <p class="mb-0 font-size-0-95 font-weight-bold pa-3">请假单审批</p>
        <div
          class="d-flex align-center position-absolute put-align-center"
          style="right: 0px; top:50%"
        >
          <v-btn
            @click="allowVacation"
            :loading="isAllow"
            small
            text
            color="#49d29e"
          >
            通过
          </v-btn>
          <v-btn @click="reasonFlag = !reasonFlag" small text color="#eb5846">
            驳回
          </v-btn>
        </div>
      </v-row>
      <div class="cus-divider-light-gray-height"></div>
      <v-row class="ma-0">
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <p class="mb-0 font-size-0-8">请假人</p>
          <p class="mb-0 font-size-0-8">{{ newVacationData.studentName }}</p>

          <!-- <v-text-field
                        class="mt-0 pt-0 mo-glow-v-text"
                        v-model=""
                        label="请假人"
                        hide-details
                        readonly
                    ></v-text-field> -->
        </v-col>
        <div class=" cus-divider-light-gray-height"></div>
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <p class="mb-0 font-size-0-8">审批人</p>
          <p class="mb-0 font-size-0-8">{{ newVacationData.teacherName }}</p>
          <!-- <v-text-field
                        class="mt-0 pt-0 mo-glow-v-text"
                        v-model="newVacationData.teacherName"
                        label="审批人"
                        hide-details
                        readonly
                    ></v-text-field> -->
        </v-col>
        <div class=" cus-divider-light-gray-height"></div>
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <p class="mb-0 font-size-0-8">开始时间</p>
          <p class="mb-0 font-size-0-8">{{ newVacationData.startTime }}</p>
          <!-- <v-datetime-picker 
                        label="开始时间" 
                        v-model="newVacationData.startTime"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                        :disabled="true"
                        class="mt-0 pt-0"
                    > </v-datetime-picker> -->
        </v-col>
        <div class=" cus-divider-light-gray-height"></div>
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <p class="mb-0 font-size-0-8">结束时间</p>
          <p class="mb-0 font-size-0-8">{{ newVacationData.endTime }}</p>
          <!-- <v-datetime-picker 
                        label="结束时间" 
                        v-model="newVacationData.endTime"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                        :disabled="true"
                        class="mt-0 pt-0"
                    > </v-datetime-picker> -->
        </v-col>
        <div class=" cus-divider-light-gray-height"></div>
        <v-col cols="12" class="d-flex justify-space-between align-start">
          <p class="mb-0 font-size-0-8 ">请假原因</p>
          <p
            class="mb-0 font-size-0-8 width-100-without-68-px text-wrap text-right"
          >
            {{ newVacationData.reason }}
          </p>
          <!-- <v-textarea
                        class="mt-0 pt-0"
                        solo
                        v-model="newVacationData.reason"
                        label="请假原因"
                        hide-details
                        readonly
                    ></v-textarea> -->
        </v-col>
        <div class=" cus-divider-light-gray-height"></div>
        <v-col
          cols="12"
          sm="6"
          class="d-flex justify-space-between align-center"
        >
          <p class="mb-0 font-size-0-8">病假</p>
          <v-switch
            v-model="newVacationData.reasonFlag"
            color="error"
            readonly
            hide-details
            class="pt-0 mt-0"
          ></v-switch>
          <p class="mb-0 font-size-0-8">事假</p>
        </v-col>
        <div class=" cus-divider-light-gray-height"></div>
        <v-col cols="12" sm="6" class="d-flex justify-space-around">
          <p class="mr-10 mb-0 font-size-0-8">假期类型</p>
          <p
            class="mr-auto  mb-0 font-size-0-8"
            v-if="newVacationData.reasonFlag == false"
          >
            病假
          </p>
          <p class="mr-auto  mb-0 font-size-0-8" v-else>事假</p>
          <v-checkbox
            v-model="newVacationData.isHeat"
            label="是否发热"
            color="error"
            hide-details
            readonly
            class="mt-0 pt-0"
          ></v-checkbox>
        </v-col>
        <div class=" cus-divider-light-gray-height"></div>
        <v-col
          v-if="newVacationData.reasonFlag == false"
          cols="12"
          class="d-flex justify-space-between align-start"
        >
          <p class="mb-0 font-size-0-8">症状</p>
          <v-textarea
            solo
            v-model="newVacationData.painDesc"
            label="症状"
            hide-details
            readonly
            class="mo-glow-v-text"
          ></v-textarea>
        </v-col>
        <v-row justify="center">
          <v-dialog
            :overlay-opacity="$isMobile() ? '0' : '0.4'"
            v-model="reasonFlag"
            persistent
            max-width="600px"
          >
            <v-card>
              <v-card-title>
                <!-- <span class="headline">添加围栏</span> -->
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12">
                      <v-textarea
                        label="请写下拒绝原因"
                        required
                        v-model="reason"
                      ></v-textarea>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeReasonFlagDia">
                  关闭
                </v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  :loading="isSaving"
                  @click="denyVacation"
                >
                  保存
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>
      </v-row>
    </v-container>
  </v-container>
  <v-container class="pa-0" v-else>
    <v-container class="px-10 z-index-2 banner-custom">
      <v-row>
        <v-col cols="6" md="4" class="d-flex align-center position-relative">
          <a @click="$router.go(-1)">
            <v-icon size="70" class="left-24p">
              mdi-chevron-left
            </v-icon>
          </a>
        </v-col>
        <v-col
          cols="6"
          md="4"
          class="d-flex align-center justify-start justify-md-center"
        >
          <h2>请假单审批</h2>
        </v-col>
        <v-col cols="12" md="4" class="d-flex align-center justify-end">
          <v-btn
            dark
            color="#f19861"
            class="mx-2"
            tile
            @click="reasonFlag = !reasonFlag"
          >
            <v-icon left>
              mdi-hand-left
            </v-icon>
            驳回
          </v-btn>
          <v-btn
            dark
            color="#7879ff"
            class=""
            tile
            @click="allowVacation"
            :loading="isAllow"
          >
            <v-icon left>
              mdi-check-decagram-outline
            </v-icon>
            通过
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
            :disabled="true"
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
            :disabled="true"
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
            readonly
          ></v-textarea>
        </v-col>
      </v-row>
      <v-row class="d-flex justify-center">
        <v-col cols="12" sm="6" class="d-flex justify-space-around">
          <span class="hover-cursor-point">病假</span>
          <v-switch
            v-model="newVacationData.reasonFlag"
            color="#7879ff"
            readonly
            hide-details
            inset
            class="pt-0 mt-0"
          ></v-switch>
          <span class="hover-cursor-point">事假</span>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" sm="6" class="d-flex justify-space-around">
          <span class="mr-10">假期类型</span>
          <span class="mr-auto " v-if="newVacationData.reasonFlag == false"
            >病假</span
          >
          <span class="mr-auto " v-else>事假</span>
          <v-checkbox
            v-model="newVacationData.isHeat"
            label="是否发热"
            color="error"
            hide-details
            readonly
            class="mt-0 pt-0"
          ></v-checkbox>
        </v-col>
      </v-row>
      <v-row v-if="newVacationData.reasonFlag == false">
        <v-col cols="12" class="d-flex justify-space-between align-start">
          <span class="mr-16 mt-3">症状</span>
          <v-textarea
            solo
            v-model="newVacationData.painDesc"
            label="症状"
            hide-details
            readonly
            class="ml-2"
          ></v-textarea>
        </v-col>
      </v-row>
      <v-row justify="center">
        <v-dialog
          :overlay-opacity="$isMobile() ? '0' : '0.4'"
          v-model="reasonFlag"
          persistent
          max-width="600px"
        >
          <v-card>
            <v-card-title>
              <!-- <span class="headline">添加围栏</span> -->
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-textarea
                      label="请写下拒绝原因"
                      required
                      v-model="reason"
                    ></v-textarea>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="reasonFlag = false">
                关闭
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                :loading="isSaving"
                @click="denyVacation"
              >
                保存
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    </v-container>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";
import { getCurrentData, updateVacationData } from "~/api/vacation";
import lang from "~/helper/lang.json";
import Name from "../../../../profile/name.vue";

export default {
  data: () => ({
    lang,
    baseUrl: window.Laravel.base_url,
    isAllow: false,
    isDeny: false,
    isSaving: false,
    reasonFlag: false,
    reason: "",
    newVacationData: {
      // studentName:'something',
      // teacherName:'something',
      // reasonFlag: true,
      // startTime: '2021-03-08 09:25',
      // endTime: '2021-03-08 10:25',
      // reason: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
      // painDesc: 'asdf',
      // isHeat: true
    }
  }),

  components: {
    Name
  },

  computed: {
    ...mapGetters({
      user: "auth/user"
    }),
    currentPath() {
      return this.$route;
    }
  },

  async created() {
    //you need to get teacher's name from server or vuex...
    // this.newVacationData.teacherName = this.....
    // this.isLoading = true
    await getCurrentData({ vId: this.currentPath.params.vId })
      .then(res => {
        console.log(res.data);
        this.newVacationData = res.data;
        this.newVacationData.startTime = this.TimeView(
          this.newVacationData.startTime
        );
        this.newVacationData.endTime = this.TimeView(
          this.newVacationData.endTime
        );
        this.isLoading = false;
      })
      .catch(err => {
        console.log(err.response);
      });
    this.isLoading = false;
    // this.newVacationData.studentName = this.user.name;
  },

  mounted() {},

  methods: {
    postVacationData() {
      //console.log(this.newVacationData);
    },

    async allowVacation() {
      this.isAllow = true;
      await updateVacationData({
        status: "allow",
        vId: this.currentPath.params.vId
      })
        .then(res => {
          console.log(res.data);
          this.isAllow = false;
          this.$router.push({ name: "posts.attendance.vacation" });
        })
        .catch(err => {
          this.isAllow = false;
          console.log(err.response);
        });
    },

    async denyVacation() {
      // if(this.reason == ''){
      //     return this.$snackbar.showMessage({content: "必须至少选择一个", color: "error"})
      // }
      this.isSaving = true;
      await updateVacationData({
        status: "deny",
        vId: this.currentPath.params.vId,
        denyReason: this.reason
      })
        .then(res => {
          console.log(res.data);
          this.isSaving = false;
          this.reason = "";
          this.$router.push({ name: "posts.attendance.vacation" });
        })
        .catch(err => {
          console.log(err.response);
          this.isSaving = false;
        });
    },

    closeReasonFlagDia() {
      this.reasonFlag = false;
      this.reason = "";
    }
  }
};
</script>

<style></style>
