<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white mb-16 pb-10-px">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{title}}</p>
                <v-btn  @click="submit" :loading="isSubmit" :disabled="noUser" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{ lang.submit }}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-container class="px-0">
                <v-row class="ma-0 " >
                    <v-col cols="12">
                    <v-checkbox
                        v-model="checkAll"
                        label="全选"
                        class="member-chk"
                        style="height:20px !important"
                        @click="selectAll"
                        color="#49d29e"
                        :disabled="noUser || isLoading"
                    ></v-checkbox>
                    </v-col>
                </v-row>
                <v-divider class="thick-border"></v-divider>
            </v-container>
            <v-container v-if="isLoading" class="pa-5 d-flex justify-center align-center">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-container>
            <v-container v-else-if="noUser" class="pa-5 d-flex justify-center align-center">
                <v-chip class="ma-2" color="primary" outlined pill >
                    没有数据
                    <v-icon right>
                    mdi-cancel 
                    </v-icon>
                </v-chip>
            </v-container>
            <v-container v-else v-for="(user, index) in userList" :key="index" class="pa-0">
                <v-row class="ma-0 ">
                    <v-col cols="12" class="">
                        <v-checkbox
                            class="mt-0 pt-0"
                            v-model="user.checkbox"
                            @click="selectMem(user)"
                            hide-details
                            color="#49d29e"
                        >
                            <template v-slot:label>
                                <div class="d-flex">
                                    <v-avatar color="#49d29e" size="60" class="rounded-lg ml-3"  >
                                        <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                                        <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                                    </v-avatar>
                                    <div class="ml-3">
                                        <p >{{user.name}}</p>
                                        <p class="mb-0">{{ pnEncrypt(user.phoneNumber) }}</p>
                                    </div>
                                </div>
                            </template>
                        </v-checkbox>
                    </v-col>
                </v-row>
                <v-divider v-if="index < userList.length - 1" light class="thick-border"></v-divider>
            </v-container>
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
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{title}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn dark color="#7879ff" :loading="isSubmit" @click="submit" :disabled="noUser">
                        {{ lang.submit }}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-divider light></v-divider>
        <v-container class="px-0">
            <v-row class="ma-0 px-5" >
                <v-col cols="12">
                <v-checkbox
                    v-model="checkAll"
                    label="全选"
                    class="member-chk"
                    style="height:20px !important"
                    @click="selectAll"
                    color="#49d29e"
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
        <v-container v-else v-for="(user, index) in userList" :key="index" class="pa-0">
            <v-row class="ma-0 ">
                <v-col cols="12" class="">
                    <v-checkbox
                        class="mt-0 pt-0 ml-5"
                        v-model="user.checkbox"
                        @click="selectMem(user)"
                        hide-details
                        color="#49d29e"
                    >
                        <template v-slot:label>
                            <div class="d-flex">
                                <v-avatar color="#49d29e" size="60" class="rounded-lg ml-3"  >
                                    <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                                    <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                                </v-avatar>
                                <div class="ml-3">
                                    <p >{{user.name}}</p>
                                    <p class="mb-0">{{ pnEncrypt(user.phoneNumber) }}</p>
                                </div>
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
            if (this.checkAll == false) {
                this.userList.map(user => {
                user.checkbox = false;
                });
            } else {
                this.userList.map(user => {
                    user.checkbox = true;
                });
            }
        },
        selectMem(user) {
            this.checkAll = true;
            this.userList.map(user => {
                if (user.checkbox == false) {
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
            
            if(this.selected.length == 0){
                return this.$snackbar.showMessage({content: "必须至少选择一个", color: "error"})
            }
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
