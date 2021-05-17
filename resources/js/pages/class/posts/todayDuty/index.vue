<template>
    <v-container class="pa-0">
        <div v-if="isPosting == true">
            
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
                        <h2>今日值日</h2>
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
            <v-container class="px-10">
                <v-row class="ma-0  hover-cursor-pointd-flex justify-space-between align-center">
                    <v-col cols="6" class="d-flex align-center px-0">
                        <p class="mb-0"  >发布时间</p>
                    </v-col>
                    <v-col cols="6" class=" px-0">
                        <v-text-field
                            solo
                            v-model="dutyDate"
                            value="shiftData.prevName"
                            readonly
                            dense
                            hide-details
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="py-5 px-10">
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
                <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
                    <v-progress-circular
                        indeterminate
                        color="primary"
                    ></v-progress-circular>
                </div>
                <div v-for="(user, index) in filteredList" :key="index" v-else>
                    <v-row class="py-5 px-10 justify-space-between">
                        <v-col cols="12" md="4">
                            <v-checkbox
                            v-model="user.checkbox"
                            :label="user.name"
                            class="member-chk"
                            @click="selectMem(user)"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4"> 性别：{{ transGender(user.gender) }} </v-col>
                        <v-col cols="12" md="4" class="text-right"> 手机号码：{{ pnEncrypt(user.phoneNumber) }} </v-col>
                    </v-row>
                    <v-divider light class="thick-border"></v-divider>
                </div>
            </v-container>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
    </v-container>
</template>

<script>

import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex'
import {getLessonUsers} from '~/api/user';
import quickMenu from '~/components/quickMenu'
import {createTodayDutyData} from '~/api/todayDuty'
export default {

    components:{
        quickMenu,
    },

    data: ()=> ({
        lang,
        baseUrl:window.Laravel.base_url,
        isSubmit:false,
        isDraft:false,
        templateCnt:0,
        draftCnt:0,
        isPosting:false,
        dutyDate:'',
        checkAll: false,
        userList: [],
        selected: [],
        search:'',
        isLoading:false,
    }),

    computed:{
        ...mapGetters({
            user:'auth/user',
            dutyUsers:'member/dutyUsers'
        }),
        currentPath(){
            return this.$route
        },
        filteredList(){
            return this.userList.filter(user=>{
                return user.name.toLowerCase().includes(this.search.toLowerCase())
            })
        },
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name == 'posts.CtodayDuty'){
                    this.isPosting = true
                }
            },
            deep:true
        },
        
    },

    async created(){
        if(this.currentPath.name == 'posts.CtodayDuty'){
            this.isPosting = true
        }
        this.dutyDate = this.TimeViewSTD(Date.now())
        await getLessonUsers({
            schoolId:this.currentPath.params.schoolId,
            lessonId:this.currentPath.params.lessonId
        })
        .then(res => {
            res.data.map(user => {
                this.$set(user, "checkbox", false);
                this.dutyUsers.map(selUser=>{
                    if(user.id == selUser.id){
                        user.checkbox = true
                    }
                })
            });
            this.userList = res.data;
            this.isLoading = false
        })
        .catch(err => {
            console.log(err.response);
            this.isLoading = false
        });
    },

    methods:{
        selStudent(){
            this.isPosting = false
            this.$router.push({name:'todayDuty.contacts'})
        },
        async submit(){
            console.log(this.specUsers)
            let selUsers = []
            this.userList.map(user=>{
                if(user.checkbox == true){
                    selUsers.push(user)
                }
            })
            this.isSubmit = true
            await createTodayDutyData({
                schoolId:this.currentPath.params.schoolId,
                lessonId:this.currentPath.params.lessonId,
                userList:selUsers,
                dutyDate:this.dutyDate
            }).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                this.$router.push({name:"classSpace.news"})
            }).catch(err=>{
                console.log(err.response)
                this.isSubmit = false
            })
        },
        selectAll() {
            console.log(this.checkAll);
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
            console.log(this.userList);
            this.checkAll = true;
            this.userList.map(user => {
                if (user.checkbox == false) {
                    this.checkAll = false;
                }
            });
        },
    }
}
</script>

<style>

</style>