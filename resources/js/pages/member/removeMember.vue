<template>
  <v-container class="pa-0">
    <v-container class="px-10 z-index-2 banner-custom">
        <v-row>
            <v-col cols="6" md="4" class="d-flex align-center position-relative">
                <a @click="$router.go(-1)">
                    <v-icon size="70" class=" left-24p">
                        mdi-chevron-left
                    </v-icon>
                </a>
            </v-col>
            <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                <h2>移除成员</h2>
            </v-col>
            <v-col cols="12" md="4" class="d-flex align-center justify-end">
              <v-text-field
                solo
                label="搜索"
                prepend-inner-icon="mdi-magnify"
                v-model="search"
                hide-details
                dense
                class="mx-2"
              ></v-text-field>
              <v-btn
                tile
                dark
                color="#7879ff"
                :loading="isSubmit"
                @click="submit"
              >
                {{ lang.submit }}
              </v-btn>
            </v-col>
        </v-row>
    </v-container>
    <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
        <v-progress-circular
            indeterminate
            color="primary"
        ></v-progress-circular>
    </div>
    <div v-else class="px-10">
      <v-row class="py-5">
        <v-col>
          <v-checkbox
            v-model="checkAll"
            label="全选"
            class="member-chk"
            style="height:20px !important"
            @click="selectAll"
          ></v-checkbox>
        </v-col>
      </v-row>
      <v-divider light class="thick-border"></v-divider>
      <div v-for="(user, index) in filteredList" :key="index">
        <v-row class="py-5 justify-space-between">
          <v-col cols="12" md="4">
            <v-checkbox
              v-model="user.checkbox"
              :label="user.name"
              class="member-chk"
              @click="selectMem(user)"
            ></v-checkbox>
          </v-col>
          <v-col cols="12" md="4"> 性别：{{ transGender(user.gender) }} </v-col>
          <v-col cols="12" md="4"> 手机号码：{{ pnEncrypt(user.phoneNumber) }} </v-col>
        </v-row>
        <v-divider light class="thick-border"></v-divider>
      </div>
    </div>
  </v-container>
</template>

<script>
import {getGroupMember,deleteGroupMember} from '~/api/group';
import lang from "~/helper/lang.json";
export default {
  data: () => ({
    checkAll: false,
    userList: [],
    lang,
    isSubmit: false,
    selected: [],
    search:'',
    isLoading:false,
  }),
  computed: {
    currentPath() {
      return this.$route;
    },
    filteredList(){
        return this.userList.filter(user=>{
          return user.name.toLowerCase().includes(this.search.toLowerCase())
        })
    }
  },
  async created() {
    let lessonId = ''
    this.isLoading = true
    // if(this.currentPath.query.otherLesson){
    //     lessonId = this.currentPath.query.otherLesson
    // }else{
    //     lessonId = this.currentPath.params.lessonId
    // }
    await getGroupMember({
      schoolId:this.currentPath.params.schoolId,
      lessonId: this.currentPath.params.lessonId,
    })
      .then(res => {
        console.log(res.data)
        res.data.map(user => {
          this.$set(user, "checkbox", false);
        });
        this.userList = res.data;
        this.isLoading = false
      })
      .catch(err => {
        console.log(err.response);
        this.isLoading = false
      });
  },
  methods: {
    selectAll() {
      console.log(this.checkAll);
      if (this.checkAll == false) {
        this.userList.map(user => {
          user.checkbox = false;
        });
      } else {
        this.userList.map(user => {
          user.checkbox = true;
          console.log(user.checkbox);
        });
      }
    },
    selectMem(user) {
      console.log(user.checkbox);
      this.checkAll = true;
      this.userList.map(user => {
        if (user.checkbox == false) {
          console.log(user.checkbox);
          this.checkAll = false;
        }
      });
    },
    submit() {
        this.userList.map(user => {
            if (user.checkbox == true) {
            this.selected.push(user.id);
            }
        });
        this.isSubmit = true
        console.log(this.selected);
        deleteGroupMember({
            schoolId: this.currentPath.params.schoolId,
            lessonId: this.currentPath.params.lessonId,
            userList: this.selected
        })
        .then(res => {
            this.isSubmit = false
            console.log(res.data);
            this.selected = []
            this.$router.push({name:'classSpace.member',params:{schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}})
        })
        .catch(err => {
            this.isSubmit = false   
            this.selected = []
            console.log(err.response);
        });
    }
  }
};
</script>

<style></style>
