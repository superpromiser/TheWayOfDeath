<template>
  <v-container v-if="$isMobile()" class="ma-0 pa-0 h-100">
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
        <p class="mb-0 font-size-0-95 font-weight-bold pa-3">
          {{ lang.regname }}
        </p>
        <v-btn
          @click="submit"
          :loading="isSubmit"
          text
          color="#7879ff"
          class="position-absolute put-align-center"
          style="right: 0px; top:50%"
        >
          {{ lang.submit }}
        </v-btn>
      </v-row>
      <div class="cus-divider-light-gray-height"></div>
      <v-row class="ma-0 mo-glow">
        <v-col cols="12" sm="6" md="4">
          <v-text-field
            class="mo-glow-v-text mt-0 pt-0"
            v-model="regNameData.title"
            label="标题"
            color="#7879ff"
            hide-details
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <v-datetime-picker
            label="开始时间"
            v-model="regNameData.startTime"
            :okText="lang.ok"
            :clearText="lang.cancel"
          >
          </v-datetime-picker>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <v-datetime-picker
            label="截止时间"
            v-model="regNameData.endTime"
            :okText="lang.ok"
            :clearText="lang.cancel"
          >
          </v-datetime-picker>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <v-select
            class="mo-glow-v-select mt-0 pt-0"
            color="#7879ff"
            multiple
            small-chips
            :menu-props="{ top: false, offsetY: true }"
            :items="inputTypeItem"
            item-text="label"
            item-value="value"
            @change="selectedInputType"
            label="报名信息可见"
            hide-details
          ></v-select>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <v-select
            class="mo-glow-v-select mt-0 pt-0"
            color="#7879ff"
            multiple
            small-chips
            :menu-props="{ top: false, offsetY: true }"
            :items="returnSchoolTree(currentPath.params.schoolId)"
            item-text="lessonName"
            item-value="lessonId"
            @change="selectedLesson"
            label="可见范围"
            hide-details
          ></v-select>
        </v-col>
        <v-col
          cols="12"
          sm="6"
          md="4"
          class="d-flex align-center justify-space-between"
        >
          <span class="mo-glow-inverse">是否需要审核</span>
          <v-switch
            v-model="regNameData.checkFlag"
            color="#7879ff"
            hide-details
            class="pt-0 mt-0"
          ></v-switch>
        </v-col>
      </v-row>
      <v-row class="ma-0 mo-glow mb-16">
        <v-col cols="12">
          <QuestionItem
            :Label="lang.contentPlaceFirst"
            :emoji="false"
            :contact="false"
            ref="child"
            @contentData="loadContentData"
          ></QuestionItem>
        </v-col>
      </v-row>
      <v-snackbar
        timeout="3000"
        v-model="requiredText"
        color="error"
        absolute
        top
      >
        {{ lang.requiredText }}
      </v-snackbar>
      <v-snackbar
        timeout="3000"
        v-model="isSuccessed"
        color="success"
        absolute
        top
      >
        {{ lang.successText }}
      </v-snackbar>
    </v-container>
  </v-container>
  <v-container class="pa-0" v-else>
    <div v-if="isPosting == true">
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
            <h2>{{ lang.regname }}</h2>
          </v-col>
          <v-col cols="12" md="4" class="d-flex align-center justify-end">
            <v-btn text color="#999999" @click="templateList">
              可用模板 {{ templateCnt }}， 草稿 {{ draftCnt }}
            </v-btn>
            <v-btn
              dark
              tile
              color="#F19861"
              :loading="isDraft"
              @click="saveDraft"
            >
              {{ lang.saveDraft }}
            </v-btn>
            <v-btn
              dark
              tile
              color="#7879ff"
              class="mx-2"
              :loading="isSubmit"
              @click="submit"
            >
              {{ lang.submit }}
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
      <v-container class="pa-10">
        <v-row class="align-start">
          <v-col cols="12" sm="6" md="4">
            <v-text-field
              solo
              v-model="regNameData.title"
              label="标题"
              hide-details
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-datetime-picker
              label="开始时间"
              v-model="regNameData.startTime"
              :okText="lang.ok"
              :clearText="lang.cancel"
            >
            </v-datetime-picker>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-datetime-picker
              label="截止时间"
              v-model="regNameData.endTime"
              :okText="lang.ok"
              :clearText="lang.cancel"
            >
            </v-datetime-picker>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-select
              solo
              multiple
              chips
              :menu-props="{ top: false, offsetY: true }"
              :items="inputTypeItem"
              item-text="label"
              item-value="value"
              @change="selectedInputType"
              label="报名信息可见"
              hide-details
            ></v-select>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-select
              solo
              multiple
              chips
              :menu-props="{ top: false, offsetY: true }"
              :items="returnSchoolTree(currentPath.params.schoolId)"
              item-text="lessonName"
              item-value="lessonId"
              @change="selectedLesson"
              label="可见范围"
              hide-details
            ></v-select>
          </v-col>
          <v-col
            cols="6"
            sm="6"
            md="4"
            class="d-flex align-center justify-space-around py-6"
          >
            <span>是否需要审核</span>
            <v-switch
              v-model="regNameData.checkFlag"
              color="#7879ff"
              hide-details
              inset
              class="pt-0 mt-0"
            ></v-switch>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12">
            <QuestionItem
              Label="报名内容"
              :emoji="false"
              :contact="false"
              ref="child"
              @contentData="loadContentData"
              :item="regNameData.content[0]"
            ></QuestionItem>
          </v-col>
        </v-row>
      </v-container>
    </div>
    <div v-else>
      <router-view></router-view>
    </div>
  </v-container>
</template>

<script>
import lang from "~/helper/lang.json";
import QuestionItem from "~/components/questionItem";
import { createRegname, getTemplateCnt, createTemplate } from "~/api/regname";
import quickMenu from "~/components/quickMenu";

export default {
  middleware: ["auth", "post"],
  components: {
    QuestionItem,
    quickMenu
  },

  data: () => ({
    lang,
    baseUrl: window.Laravel.base_url,
    isSubmit: false,
    isDraft: false,
    requiredText: false,
    regNameData: {
      title: "",
      schoolId: null,
      lessonId: null,
      content: [],
      viewList: [],
      inputTypeList: [],
      startTime: null,
      endTime: null,
      checkFlag: false
    },
    isSuccessed: false,
    inputTypeItem: [
      {
        label: "姓名",
        value: "name"
      },
      {
        label: "头像",
        value: "avatar"
      },
      {
        label: "性别",
        value: "gender"
      },
      {
        label: "手机号码",
        value: "phoneNumber"
      },
      {
        label: "出生日期",
        value: "birthday"
      },
      {
        label: "家庭地址",
        value: "familyAddress"
      },
      {
        label: "身份证号",
        value: "cardNum"
      },
      {
        label: "父亲姓名",
        value: "fatherName"
      },
      {
        label: "父亲联系方式",
        value: "fatherPhone"
      },
      {
        label: "父亲工作单位",
        value: "fatherJob"
      }
    ],
    templateCnt: 0,
    draftCnt: 0,
    isPosting: false
  }),
  computed: {
    currentPath() {
      return this.$route;
    }
  },
  watch: {
    currentPath: {
      handler(val) {
        if (val.name == "posts.CregName") {
          this.isPosting = true;
        }
        if (val.query.tempData) {
          console.log(
            "JSON.parse(val.query.tempData)",
            JSON.parse(val.query.tempData)
          );
          this.regNameData.content = JSON.parse(val.query.tempData);
        }
      },
      deeper: true
    }
  },
  created() {
    if (this.currentPath.name == "posts.CregName") {
      this.isPosting = true;
    }
    this.regNameData.schoolId = this.currentPath.params.schoolId;
    this.regNameData.lessonId = this.currentPath.params.lessonId;
    getTemplateCnt({
      schoolId: this.currentPath.params.schoolId,
      lessonId: this.currentPath.params.lessonId
    }).then(res => {
      this.draftCnt = res.data.draftCnt;
      this.templateCnt = res.data.templateCnt;
    });
  },
  methods: {
    async saveDraft() {
      this.$refs.child.emitData();
      let draftData = {};
      draftData.tempType = 2;
      draftData.content = this.regNameData.content;
      draftData.schoolId = this.currentPath.params.schoolId;
      if (this.currentPath.params.lessonId) {
        draftData.lessonId = this.currentPath.params.lessonId;
      }
      let currentTime = this.TimeView(new Date());
      draftData.title = "title-" + currentTime;
      draftData.description = "description-" + currentTime;
      console.log(draftData);
      console.log(
        "this.regNameData.content.length",
        this.regNameData.content.length
      );
      if (this.regNameData.content.length == 0) {
        return this.$snackbar.showMessage({
          content: this.lang.requireName,
          color: "error"
        });
      }
      this.isDraft = true;
      await createTemplate(draftData)
        .then(res => {
          console.log(res.data);
          this.isDraft = false;
          this.draftCnt++;
        })
        .catch(err => {
          console.log(err.response);
          this.isDraft = false;
        });
    },

    async submit() {
      this.$refs.child.emitData();
      if (this.regNameData.title.trim() == "") {
        return this.$snackbar.showMessage({
          content: this.lang.requireTitle,
          color: "error"
        });
      }
      if (this.regNameData.startTime == null) {
        return this.$snackbar.showMessage({
          content: this.lang.requireStartTime,
          color: "error"
        });
      }
      if (this.regNameData.endTime == null) {
        return this.$snackbar.showMessage({
          content: this.lang.requireDeadline,
          color: "error"
        });
      }
      if (this.regNameData.inputTypeList.length == 0) {
        return this.$snackbar.showMessage({
          content: "报名信息可见不能为空",
          color: "error"
        });
      }
      if (this.regNameData.content.length == 0) {
        return this.$snackbar.showMessage({
          content: this.lang.requiredText,
          color: "error"
        });
      }
      if (this.regNameData.startTime > this.regNameData.endTime) {
        return this.$snackbar.showMessage({
          content: this.lang.startTimeAndEndTime,
          color: "error"
        });
      }
      this.isSubmit = true;
      await createRegname(this.regNameData)
        .then(res => {
          console.log(res);
          this.isSubmit = false;

          if (this.$isMobile()) {
            this.$router.push({ name: "home" });
          } else {
            this.$router.push({ name: "classSpace.news" });
          }
        })
        .catch(err => {
          //console.log(err.response)
          this.isSubmit = false;
        });
    },

    loadContentData(data) {
      if (data.text === "") {
        this.regNameData.content = [];
        return;
      }
      this.regNameData.content.push(data);
    },

    selectedLesson(val) {
      this.regNameData.viewList = val;
    },

    selectedInputType(val) {
      this.regNameData.inputTypeList = val;
    },

    something() {},
    templateList() {
      this.isPosting = false;
      this.$router.push({ name: "CregName.templateList" });
    }
  }
};
</script>

<style></style>
