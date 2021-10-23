<template>
  <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
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
        <p class="mb-0 font-size-0-95 font-weight-bold pa-3">历史留堂信息</p>
        <v-btn
          text
          color="#7879ff"
          class="position-absolute put-align-center"
          style="right: 0px; top:50%"
        >
          全部删除
        </v-btn>
      </v-row>
      <div class="cus-divider-light-gray-height"></div>
      <v-row class="ma-0">
        <v-col cols="12" class="d-flex justify-space-between align-center">
          <v-checkbox
            v-model="checkAll"
            label="全选"
            @click="selectAll"
            color="#7879ff"
            :disabled="noData || isLoading"
            class="mt-0 pt-0"
            hide-details
          ></v-checkbox>
          <v-spacer> </v-spacer>
          <v-btn
            text
            :disabled="!selectedAnyTeam"
            @click="openRemoveReturnTeamGroupDia"
          >
            删除所选项目
          </v-btn>
        </v-col>
      </v-row>
      <!-- <v-row class="ma-0">
                <v-col cols="12">
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="date"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="date"
                            label="请选择日期"
                            prepend-icon="mdi-calendar"
                            readonly
                            hide-details
                            class="mt-0 pt-0"
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="date"
                        no-title
                        scrollable
                        locale="zh-cn"
                        >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="#7879ff"
                            @click="menu = false"
                        >
                            {{lang.cancel}}
                        </v-btn>
                        <v-btn
                            text
                            color="#7879ff"
                            @click="$refs.menu.save(date)"
                        >
                            {{lang.ok}}
                        </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>
            </v-row> -->
      <v-row class="ma-0">
        <v-col cols="12" class="pa-0">
          <v-container
            class="pa-0"
            v-for="(remainTeam, i) in remainTeamArr"
            :key="i"
          >
            <v-row
              class="ma-0 justify-space-between align-center bg-secondary py-1 px-3"
            >
              <v-checkbox
                v-model="remainTeam.checkbox"
                @click="selectTeam"
                color="#7879ff"
                hide-details
                class="pt-0 mt-0"
              >
                <template v-slot:label>
                  <p class="mb-0">{{ TimeViewYMD(remainTeam.updated_at) }}</p>
                </template>
              </v-checkbox>
              <v-icon
                color="#616161"
                size="25"
                class="hover-cursor-point"
                @click="openRemoveReturnTeamOneDialag(remainTeam, i)"
              >
                mdi-trash-can-outline
              </v-icon>
            </v-row>
            <v-row
              class="ma-0 justify-space-between align-center hover-cursor-point py-1 px-3"
              v-ripple
              @click="navToDetail(remainTeam)"
            >
              <div class="d-flex align-center ">
                <v-avatar color="#7879ff" size="60" class="mr-3 ">
                  <span
                    v-if="remainTeam.avatar == '/'"
                    class="white--text headline"
                    >{{ remainTeam.name[0] }}</span
                  >
                  <v-img v-else :src="`${baseUrl}${remainTeam.avatar}`"></v-img>
                </v-avatar>
                <p class="mb-0">{{ remainTeam.name }}</p>
              </div>
              <v-icon color="#999999" size="25" class="">
                mdi-chevron-right
              </v-icon>
            </v-row>
          </v-container>
        </v-col>
      </v-row>
      <v-dialog
        :overlay-opacity="$isMobile() ? '0' : '0.4'"
        persistent
        v-model="dialogDelete"
        max-width="500px"
      >
        <v-card>
          <v-card-title class="headline">{{
            lang.confirmSentence
          }}</v-card-title>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeDelete">{{
              lang.cancel
            }}</v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="deleteTeamGroupConfirm"
              :loading="isDeleteTeam"
              >{{ lang.ok }}</v-btn
            >
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog
        :overlay-opacity="$isMobile() ? '0' : '0.4'"
        persistent
        v-model="removeReturnTeamOneDialog"
        max-width="500px"
      >
        <v-card>
          <v-card-title class="headline">{{
            lang.confirmSentence
          }}</v-card-title>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeDeleteOne">{{
              lang.cancel
            }}</v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="removeOneReturnTeam"
              :loading="isDeleteTeam"
              >{{ lang.ok }}</v-btn
            >
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-dialog>
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
          <h2>历史留堂信息</h2>
        </v-col>
        <v-col cols="12" md="4" class="d-flex align-center justify-end">
          <v-btn dark color="#7879ff">
            全部删除
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
    <v-row class="ma-0">
      <v-col
        cols="12"
        class="d-flex justify-space-between align-center pl-10 pr-10"
      >
        <v-checkbox
          v-model="checkAll"
          label="全选"
          @click="selectAll"
          color="#7879ff"
          :disabled="noData || isLoading"
        ></v-checkbox>
        <v-spacer> </v-spacer>
        <!-- <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    :return-value.sync="date"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="date"
                        label="请选择日期"
                        prepend-icon="mdi-calendar"
                        readonly
                        hide-details
                        solo
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
                    </template>
                    <v-date-picker
                    v-model="date"
                    no-title
                    scrollable
                    locale="zh-cn"
                    >
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="#7879ff"
                        @click="menu = false"
                    >
                        {{lang.cancel}}
                    </v-btn>
                    <v-btn
                        text
                        color="#7879ff"
                        @click="$refs.menu.save(date)"
                    >
                        {{lang.ok}}
                    </v-btn>
                    </v-date-picker>
                </v-menu> -->
      </v-col>
    </v-row>
    <v-row class="ma-0">
      <v-col cols="12" class="pa-0">
        <v-container class="pa-0">
          <v-row class="ma-0 align-center py-2">
            <v-btn
              text
              :disabled="!selectedAnyTeam"
              class="ml-7"
              @click="openRemoveReturnTeamGroupDia"
            >
              删除所选项目
            </v-btn>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
    <v-row class="ma-0">
      <v-col cols="12" class="pa-0">
        <v-container
          class="pa-0"
          v-for="(remainTeam, i) in remainTeamArr"
          :key="i"
        >
          <v-row
            class="ma-0 justify-space-between align-center bg-secondary px-10 py-2"
          >
            <v-checkbox
              v-model="remainTeam.checkbox"
              @click="selectTeam"
              color="#7879ff"
              hide-details
              class="pt-0 mt-0"
            >
              <template v-slot:label>
                <p class="mb-0">{{ TimeViewYMD(remainTeam.updated_at) }}</p>
              </template>
            </v-checkbox>
            <v-icon
              color="#333333"
              size="30"
              class="hover-cursor-point"
              @click="openRemoveReturnTeamOneDialag(remainTeam, i)"
            >
              mdi-trash-can-outline
            </v-icon>
          </v-row>
          <v-row
            class="ma-0 justify-space-between align-center pl-10 pr-8 hover-cursor-point py-2"
            v-ripple
            @click="navToDetail(remainTeam)"
          >
            <div class="d-flex align-center ">
              <v-avatar color="#7879ff" size="60" class="mr-3 ">
                <span
                  v-if="remainTeam.avatar == '/'"
                  class="white--text headline"
                  >{{ remainTeam.name[0] }}</span
                >
                <v-img v-else :src="`${baseUrl}${remainTeam.avatar}`"></v-img>
              </v-avatar>
              <p class="mb-0">{{ remainTeam.name }}</p>
            </div>
            <v-icon color="#999999" size="40" class="">
              mdi-chevron-right
            </v-icon>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
    <v-dialog
      :overlay-opacity="$isMobile() ? '0' : '0.4'"
      persistent
      v-model="dialogDelete"
      max-width="500px"
    >
      <v-card>
        <v-card-title class="headline">{{ lang.confirmSentence }}</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDelete">{{
            lang.cancel
          }}</v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="deleteTeamGroupConfirm"
            :loading="isDeleteTeam"
            >{{ lang.ok }}</v-btn
          >
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      :overlay-opacity="$isMobile() ? '0' : '0.4'"
      persistent
      v-model="removeReturnTeamOneDialog"
      max-width="500px"
    >
      <v-card>
        <v-card-title class="headline">{{ lang.confirmSentence }}</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDeleteOne">{{
            lang.cancel
          }}</v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="removeOneReturnTeam"
            :loading="isDeleteTeam"
            >{{ lang.ok }}</v-btn
          >
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";
import lang from "~/helper/lang.json";
import { getReturnTeam, deleteReturnTeam } from "~/api/returnteam";

export default {
  computed: {
    ...mapGetters({
      remainTeamArr: "returnteam/remainTeamArr"
    })
  },

  data: () => ({
    lang,
    baseUrl: window.Laravel.base_url,
    isLoading: false,
    checkAll: false,
    noData: false,
    date: null,
    menu: false,
    selectedAnyTeam: false,
    dialogDelete: false,
    isDeleteTeam: false,
    removeReturnTeamOneDialog: false,
    deleteItem: null,
    deleteIndex: -1
  }),

  async created() {
    if (this.remainTeamArr == null) {
      let remainTeamArr = [];
      this.isLoading = true;
      await getReturnTeam()
        .then(res => {
          console.log(res);
          res.data.returnTeamArr.map(returnTeam => {
            if (returnTeam.name == "留堂成员") {
              this.$set(returnTeam, "checkbox", false);
              this.$set(returnTeam, "isDelete", false);
              remainTeamArr.push(returnTeam);
            }
          });
          if (remainTeamArr.length == 0) {
            this.noData = true;
          }
          console.log("remainTeamArr", remainTeamArr);
          console.log("this.remainTeamArr", this.remainTeamArr);
          this.$store.dispatch("returnteam/storeRemainTeamArr", remainTeamArr);
        })
        .catch(err => {});
      this.isLoading = false;
    } else {
      if (this.remainTeamArr.length == 0) {
        this.noData = true;
      }
    }
    console.log(this.remainTeamArr);
  },

  methods: {
    selectAll() {
      console.log(this.checkAll);
      if (this.checkAll == false) {
        this.remainTeamArr.map(remainTeam => {
          remainTeam.checkbox = false;
        });
        this.selectedAnyTeam = false;
      } else {
        this.remainTeamArr.map(remainTeam => {
          remainTeam.checkbox = true;
        });
        this.selectedAnyTeam = true;
      }
    },

    selectTeam(team) {
      console.log(team.checkbox);
      this.selectedAnyTeam = false;
      this.checkAll = true;
      this.remainTeamArr.map(team => {
        if (team.checkbox == false) {
          console.log(team.checkbox);
          this.checkAll = false;
        } else {
          this.selectedAnyTeam = true;
        }
      });
    },

    navToDetail(returnTeam) {
      this.remainTeamArr.map(team => {
        team.checkbox = false;
      });
      this.checkAll = false;
      this.$store.dispatch("returnteam/storeIsDetailView", true);
      this.$store.dispatch("returnteam/storeDetailData", returnTeam);
      this.$router.push({
        name: "classSpace.detailReturnTeam",
        params: { teamData: returnTeam }
      });
    },

    async removeOneReturnTeam() {
      this.deleteItem.isDelete = true;
      this.isDeleteTeam = true;
      let payload = {
        id: this.deleteItem.id
      };
      await deleteReturnTeam(payload)
        .then(res => {
          this.remainTeamArr.splice(this.deleteIndex, 1);
        })
        .catch(err => {});
      this.isDeleteTeam = false;
      this.deleteItem.isDelete = false;
      this.removeReturnTeamOneDialog = false;
      this.deleteIndex = -1;
      this.deleteItem = null;
    },

    closeDelete() {
      this.dialogDelete = false;
    },

    async deleteTeamGroupConfirm() {
      let selectedRemainTeamIdArr = [];
      this.remainTeamArr.map((remainTeam, i) => {
        if (remainTeam.checkbox == true) {
          selectedRemainTeamIdArr.push(remainTeam.id);
          this.remainTeamArr.splice(i, 1);
        }
      });

      // for(let i = 0; i < this.remainTeamArr.length; i++){
      //     console.log(i, this.remainTeamArr[i].checkbox)
      //     if(this.remainTeamArr[i].checkbox == true){
      //         console.log("i", i);
      //         this.remainTeamArr.splice(i, 1);
      //     }
      // }
      // this.isDeleteTeam = true;
      // let payload = {
      //     idArr: selectedRemainTeamIdArr
      // }

      // await deleteReturnTeam(payload)
      // .then((res) => {

      // }).catch((err) => {

      // });
      // this.isDeleteTeam = false;
      this.dialogDelete = false;
      if (this.remainTeamArr.length == 0) {
        this.noData = true;
      }
    },

    openRemoveReturnTeamOneDialag(returnTeam, index) {
      this.deleteItem = returnTeam;
      this.deleteIndex = index;
      this.removeReturnTeamOneDialog = true;
    },

    closeDeleteOne() {
      this.removeReturnTeamOneDialog = false;
      this.deleteItem = null;
      this.deleteIndex = -1;
    },

    openRemoveReturnTeamGroupDia() {
      this.dialogDelete = true;
    }
  }
};
</script>

<style></style>
