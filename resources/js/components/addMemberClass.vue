<template>
  <v-container>
    <v-row class="ma-0 ">
        <v-col cols="12" class="d-flex align-center justify-space-between">
            <a @click="$router.go(-1)">
                <v-icon size="70">
                    mdi-chevron-left
                </v-icon>
            </a>
            <span style="font-size:30px;line-height:2">{{title}}</span> 
            <v-btn
                tile
                dark
                color="#7879ff"
                :loading="isSubmit"
                @click="submit"
                :disabled="noUser"
            >
                {{ lang.submit }}
            </v-btn>
        </v-col>
    </v-row>
    <v-divider light></v-divider>
    <v-container >
      <v-row class="ma-0" >
        <v-col cols="12">
          <v-checkbox
            v-model="checkAll"
            label="全选"
            class="member-chk"
            style="height:20px !important"
            @click="selectAll"
            color="#7879ff"
            :disabled="noUser || isLoading"
          ></v-checkbox>
        </v-col>
      </v-row>
      <v-divider class="thick-border"></v-divider>
    </v-container>
    <v-container v-if="isLoading" class="d-flex justify-center align-center">
        <v-progress-circular
            indeterminate
            color="primary"
        ></v-progress-circular>
    </v-container>
    <v-container v-else-if="noUser" class="d-flex justify-center align-center">
        <v-chip class="ma-2" color="primary" outlined pill >
              没有数据
            <v-icon right>
            mdi-cancel 
            </v-icon>
        </v-chip>
    </v-container>
    <v-container v-else v-for="(user, index) in userList" :key="index" class="py-0">
        <v-row class="ma-0">
            <v-col cols="12" class="">
                <v-checkbox
                    class="mt-0 pt-0 ml-5"
                    v-model="user.checkbox"
                    @click="selectMem(user)"
                    hide-details
                    color="#7879ff"
                >
                    <template v-slot:label>
                        <div class="d-flex">
                            <v-avatar color="#7879ff" size="60" class="rounded-lg ml-3"  >
                                <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                                <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                            </v-avatar>
                            <div class="ml-3">
                                <p >{{user.name}}</p>
                                <p class="mb-0">{{ pnEncrypt(user.phoneNumber) }}</p>
                            </div>
                        </template>
                    </v-checkbox>
                </v-col>
            </v-row>
            <v-divider v-if="index < userList.length - 1" light class="thick-border"></v-divider>
        </v-container>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import { getSchoolMemberList} from "~/api/user";
import {addGroupMember} from '~/api/group';
import lang from "~/helper/lang.json";
export default {
    props:{
        title:{
            type: String,
            default: '成员选择',
            required: false
        },

    },
    data: () => ({
        baseUrl: window.Laravel.base_url,
        checkAll: false,
        userList: [],
        lang,
        isSubmit: false,
        selected: [],
        isLoading: false,
        noUser: false,
    }),
    computed: {
        currentPath() {
            return this.$route;
        },
        ...mapGetters({
            classGroupList: 'member/classGroupList'
        })
    },
    async created() {
        let lessonId = ''
        if(this.currentPath.query.otherLesson){
            lessonId = this.currentPath.query.otherLesson
        }else{
            lessonId = this.currentPath.params.lessonId
        }
        if(this.classGroupList == null){

            this.isLoading = true;
            await getSchoolMemberList({
                schoolId:this.currentPath.params.schoolId,
                lessonId: lessonId,
                roleId: 5
            })
            .then(res => {
                if(res.data.length == 0){
                    this.noUser = true;
                }
                else{
                    res.data.map(user => {
                    this.$set(user, "checkbox", false);
                    });
                    this.$store.dispatch('member/storeClassGroupList', res.data);
                    this.userList = this.classGroupList;
                }
            })
            .catch(err => {
                console.log(err.response);
            });
            this.isLoading = false;
        }
        else{
            this.userList = this.classGroupList;
        }
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
            
            console.log(this.selected);
            this.$emit('onSelectMember', this.selected);
        },
        navToBack(){
            this.userList.map(user => {
                user.checkbox = false;
            });
            this.$router.go(-1);
        }
    }
};
</script>

<style></style>
