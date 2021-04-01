<template>
  <v-container>
    <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
      
      <div class="d-flex align-center justify-space-between">
        <a @click="$router.go(-1)">
          <v-icon size="70">
              mdi-chevron-left
          </v-icon>
        </a>
        <p class="mb-0">移除成员</p>
        <v-btn
          tile
          dark
          color="green lighten-1"
          :loading="isSubmit"
          @click="submit"
        >
          {{ lang.submit }}
        </v-btn>
      </div>
    </v-banner>
    <v-banner>
      <v-row>
        <v-col>
          <v-text-field
            solo
            label="Prepend inner"
            prepend-inner-icon="mdi-magnify"
            v-model="search"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-banner>
    <v-banner>
      <v-row justify-space-between>
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
    </v-banner>
    <v-banner v-for="(user, index) in filteredList" :key="index">
      <v-row>
        <v-col>
          <v-checkbox
            v-model="user.checkbox"
            :label="user.name"
            class="member-chk"
            @click="selectMem(user)"
          ></v-checkbox>
        </v-col>
        <v-col> 性别：{{ transGender(user.gender) }} </v-col>
        <v-col> 手机号码：{{ pnEncrypt(user.phoneNumber) }} </v-col>
      </v-row>
    </v-banner>
  </v-container>
</template>

<script>
import { getSchoolMemberList} from "~/api/user";
import {addGroupMember} from '~/api/group';
import lang from "~/helper/lang.json";
export default {
  data: () => ({
    checkAll: false,
    userList: [],
    lang,
    isSubmit: false,
    selected: [],
    search:''
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
  created() {
    let lessonId = ''
    if(this.currentPath.query.otherLesson){
        lessonId = this.currentPath.query.otherLesson
    }else{
        lessonId = this.currentPath.params.lessonId
    }
    getSchoolMemberList({
      schoolId:this.currentPath.params.schoolId,
      lessonId: lessonId,
      roleId: this.currentPath.query.roleId
    })
      .then(res => {
        res.data.map(user => {
          this.$set(user, "checkbox", false);
        });
        this.userList = res.data;
      })
      .catch(err => {
        console.log(err.response);
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
            this.selected.push(user);
            }
        });
        this.isSubmit = true
        console.log(this.selected);
        addGroupMember({
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
