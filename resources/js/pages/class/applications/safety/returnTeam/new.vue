<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white mb-16 pb-10-px">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="navToBack" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >新建归程队</p>
                <v-btn  @click="submit" :loading="isCreating" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    新建归程队
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-container class="pa-0">
                <v-row class="ma-0 hover-cursor-point" v-ripple @click="clickUploadImageBtn">
                    <v-col cols="12" class="d-flex justify-space-between align-center ">
                        <p class="mb-0 font-size-0-8" >头像 </p>
                        <div class="d-flex align-center">
                            <v-avatar size="50" :color="returnTeamData.name == '' && returnTeamData.avatar == null ? '#999999': '#7879ff'">
                                <v-img v-if="returnTeamData.avatar !== null" :src="`${baseUrl}${returnTeamData.avatar}`"> </v-img>
                                <span v-else-if="returnTeamData.name !== ''" class="white--text headline">{{returnTeamData.name[0]}}</span>
                                <v-icon v-else dark >
                                    mdi-account
                                </v-icon>
                            </v-avatar>
                            <v-icon class="ml-2" color="#999999" size="25">
                                    mdi-chevron-right
                            </v-icon>
                        </div>
                    </v-col>
                </v-row>
                <input
                    ref="imageUploader"
                    class="d-none"
                    type="file"
                    accept="image/*"
                    @change="onImageFileChanged"
                >
                <v-divider light></v-divider>
                <v-row class="ma-0  hover-cursor-point" v-ripple @click="$refs.returnTeamName.focus()">
                    <v-col cols="12" class="d-flex justify-space-between align-center ">
                        <p class="mb-0 w-50 font-size-0-8"  >归程队名称 </p>
                        <v-text-field
                            class="pt-0 mt-0"
                            color="#7879ff"
                            single-line
                            v-model="returnTeamData.name"
                            label="清输入归程队名称"
                            hide-details
                            ref="returnTeamName"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-divider light></v-divider>
                <v-row class="ma-0  hover-cursor-point" v-ripple @click="navToAddTeacher">
                    <v-col cols="12" class="d-flex justify-space-between align-center ">
                        <p class="mb-0 font-size-0-8"  >领队教师 </p>
                        <div class="d-flex align-center">
                            <p v-if="returnTeamData.teacher !== null" class="mb-0 secondary-text">{{returnTeamData.teacher.name}}</p>
                            <v-icon class="ml-2" color="#999999" size="25">
                                mdi-chevron-right
                            </v-icon>
                        </div>
                    </v-col>
                </v-row>
                <v-divider light></v-divider>
                <v-row class="ma-0  hover-cursor-point" v-ripple @click="navToAddMember">
                    <v-col cols="12" class="d-flex justify-space-between align-center">
                        <p class="mb-0 font-size-0-8"  >归程队成员</p>
                        <div class="d-flex align-center">
                            <p v-if="returnTeamData.member.length !== 0" class="mb-0 secondary-text">{{returnTeamData.member.length}} 个已选择</p>
                            <v-icon class="ml-2" color="#999999" size="25">
                                mdi-chevron-right
                            </v-icon>
                        </div>
                    </v-col>
                </v-row>
                <v-divider light></v-divider>
                <v-row class="ma-0  hover-cursor-point" v-ripple @click="openSelectLeaderDialog">
                    <v-col cols="12" class="d-flex justify-space-between align-center">
                        <p class="mb-0 font-size-0-8"  >归程队组长 </p>
                        <div class="d-flex align-center">
                            <p v-if="returnTeamData.leader !== null" class="mb-0 secondary-text">{{returnTeamData.leader.name}}</p>
                            <v-icon class="ml-2" color="#999999" size="25">
                                mdi-chevron-right
                            </v-icon>
                        </div>
                    </v-col>
                </v-row>
                <v-divider light class="thick-border"></v-divider>
                <v-row class="ma-0 ">
                    <v-col cols="12" v-if="returnTeamData.member.length == 0" class="d-flex align-center justify-start">
                        <v-chip class="ma-2" color="primary" outlined pill >
                            没有人选择
                            <v-icon right>
                            mdi-cancel 
                            </v-icon>
                        </v-chip>
                    </v-col>
                    <v-col class="pa-0 px-3 pt-1" v-else v-for="(user, i) in returnTeamData.member" :key="i" cols="12" sm="6" md="4" lg="3" xl="2" >
                        <div class="w-100 d-flex align-center">
                            <v-avatar color="#49d29e" size="60" class="rounded-lg"  >
                                <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                                <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                            </v-avatar>
                            <div class="ml-3">
                                <p >{{user.name}}</p>
                                <p class="mb-0">{{ pnEncrypt(user.phoneNumber) }}</p>
                            </div>
                            <v-spacer></v-spacer>
                            <v-chip v-if="returnTeamData.leader !== null && user.id == returnTeamData.leader.id" dark color="#7879ff" >
                                组长  
                            </v-chip>
                        </div>
                        <div v-if="i < returnTeamData.member.length - 1" class=" cus-divider-light-gray-height"></div>
                    </v-col>
                </v-row>
                <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'"    persistent v-model="selectLeaderDialog" width="100%" max-width="500">
                    <v-card>
                        <v-card-title class="title"> 归程队组长 </v-card-title>
                        <v-card-text v-if="returnTeamData.member.length == 0">
                            请首先选择归程团队成员
                        </v-card-text>
                        <v-card-text v-else class="">
                            <v-select 
                                :items="returnTeamData.member"
                                :menu-props="{ top: false, offsetY: true }"
                                item-text="name"
                                item-value="id"
                                v-model="returnTeamData.leader"
                                hide-details
                                return-object
                                @change="onSelectLeader"
                                color="#7879ff"
                            >
                            </v-select>
                        </v-card-text>
                        
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="#7879ff"
                                @click="onSubmitSelectedLeader"
                            >
                                {{lang.ok}}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-container>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="navToBack">
                        <v-icon size="70" class="left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>新建归程队</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn dark color="#7879ff" @click="submit" :loading="isCreating">
                        新建归程队
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-container class="pa-0">
            <v-row class="ma-0 hover-cursor-point" v-ripple @click="clickUploadImageBtn">
                <v-col cols="12" class="d-flex justify-space-between align-center pl-10 pr-8">
                    <p class="mb-0" >头像 </p>
                    <div class="d-flex align-center">
                        <v-avatar size="50" :color="returnTeamData.name == '' && returnTeamData.avatar == null ? '#999999': '#7879ff'">
                            <v-img v-if="returnTeamData.avatar !== null" :src="`${baseUrl}${returnTeamData.avatar}`"> </v-img>
                            <span v-else-if="returnTeamData.name !== ''" class="white--text headline">{{returnTeamData.name[0]}}</span>
                            <v-icon v-else dark >
                                mdi-account
                            </v-icon>
                        </v-avatar>
                        <v-icon class="ml-4" color="#999999" size="40">
                                mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <input
                ref="imageUploader"
                class="d-none"
                type="file"
                accept="image/*"
                @change="onImageFileChanged"
            >
            <v-divider light></v-divider>
            <v-row class="ma-0 py-2 hover-cursor-point" v-ripple @click="$refs.returnTeamName.focus()">
                <v-col cols="12" class="d-flex justify-space-between align-center pl-10 pr-12">
                    <p class="mb-0 w-100"  >归程队名称 </p>
                    <v-text-field
                        class="pt-0 mt-0"
                        color="#7879ff"
                        single-line
                        v-model="returnTeamData.name"
                        label="清输入归程队名称"
                        hide-details
                        ref="returnTeamName"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-2 hover-cursor-point" v-ripple @click="navToAddTeacher">
                <v-col cols="12" class="d-flex justify-space-between align-center pl-10 pr-8">
                    <p class="mb-0"  >领队教师 </p>
                    <div class="d-flex align-center">
                        <p v-if="returnTeamData.teacher !== null" class="mb-0 secondary-text">{{returnTeamData.teacher.name}}</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-2 hover-cursor-point" v-ripple @click="navToAddMember">
                <v-col cols="12" class="d-flex justify-space-between align-center pl-10 pr-8">
                    <p class="mb-0"  >归程队成员</p>
                    <div class="d-flex align-center">
                        <p v-if="returnTeamData.member.length !== 0" class="mb-0 secondary-text">{{returnTeamData.member.length}} 个已选择</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-2 hover-cursor-point" v-ripple @click="openSelectLeaderDialog">
                <v-col cols="12" class="d-flex justify-space-between align-center pl-10 pr-8">
                    <p class="mb-0"  >归程队组长 </p>
                    <div class="d-flex align-center">
                        <p v-if="returnTeamData.leader !== null" class="mb-0 secondary-text">{{returnTeamData.leader.name}}</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <!-- <v-divider light></v-divider>
            <v-row class="ma-0 " >
                <v-expansion-panels>
                    <v-expansion-panel  class="box-shadow-none">
                        <v-expansion-panel-header v-ripple disable-icon-rotate>
                            归程队组长
                            <template v-slot:actions>
                                <p v-if="returnTeamData.leader !== null" class="mb-0 secondary-text">ssss</p>
                                <v-icon class="ml-4" color="#999999" size="40">
                                    mdi-chevron-right
                                </v-icon>
                            </template>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-row> -->
            <v-divider light class="thick-border"></v-divider>
            <v-row class="ma-0 py-2 pl-8 pr-8">
                <v-col cols="12" v-if="returnTeamData.member.length == 0" class="d-flex align-center justify-start">
                    <v-chip class="ma-2" color="primary" outlined pill >
                        没有人选择
                        <v-icon right>
                        mdi-cancel 
                        </v-icon>
                    </v-chip>
                </v-col>
                <v-col v-else v-for="(user, i) in returnTeamData.member" :key="i" cols="12" sm="6" md="4" lg="3" xl="2" class="" >
                    <v-card class="text-center pt-4 position-relative">
                        <v-avatar color="#7879ff" size="60" class="rounded-circle mx-auto"  >
                            <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                            <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                        </v-avatar>
                        <v-card-title class="justify-center">{{user.name}}</v-card-title>
                        <v-card-subtitle>{{pnEncrypt(user.phoneNumber)}}</v-card-subtitle>
                        <v-chip v-if="returnTeamData.leader !== null && user.id == returnTeamData.leader.id" dark class="position-absolute" color="#999999" style="top: 0px; right:0px;">
                            组长  
                        </v-chip>
                    </v-card>
                </v-col>
            </v-row>
            <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'"  persistent v-model="selectLeaderDialog" width="100%" max-width="500">
                <v-card>
                    <v-card-title class="title"> 归程队组长 </v-card-title>
                    <v-card-text v-if="returnTeamData.member.length == 0">
                        请首先选择归程团队成员
                    </v-card-text>
                    <v-card-text v-else class="">
                        <v-select 
                            :items="returnTeamData.member"
                            :menu-props="{ top: false, offsetY: true }"
                            item-text="name"
                            item-value="id"
                            v-model="returnTeamData.leader"
                            hide-details
                            return-object
                            @change="onSelectLeader"
                            color="#7879ff"
                        >
                        </v-select>
                    </v-card-text>
                    
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="#7879ff"
                            @click="onSubmitSelectedLeader"
                        >
                            {{lang.ok}}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </v-container>
</template>

<script>

import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex'
import {uploadImage} from '~/api/upload'
import {createReturnTeam,} from '~/api/returnteam'

export default {

    data: ()=> ({
        lang,
        baseUrl:window.Laravel.base_url,
        isImageSelecting: false,
        selectedImageFile: null,
        selectLeaderDialog: false,
        returnTeamData: {
            avatar: null,
            name: '',
            teacher: null,
            leader: null,
            member: [],
        },
        isCreating: false,
    }),

    computed:{
        ...mapGetters({
            user: 'auth/user',
            selectedGroup: 'member/selectedGroup',
            selectedTeacherData: 'member/selectedTeacher',
            returnTeamName: 'returnteam/name',
            returnTeamAvatar: 'returnteam/avatar',
            returnTeamLeader: 'returnteam/leader',
            todayReturnTeamArr: 'returnteam/todayReturnTeamArr'
        }),
    },

    created(){
        this.returnTeamData.name = this.returnTeamName;
        this.returnTeamData.avatar = this.returnTeamAvatar;
        this.returnTeamData.leader = this.returnTeamLeader;
        this.returnTeamData.teacher = this.selectedTeacherData;

        if(this.selectedGroup !== null){
            if(this.selectedGroup.length == 0){
                this.returnTeamData.leader = null;
            }
            this.returnTeamData.member = this.selectedGroup
        }
    },

    methods:{
        clickUploadImageBtn() {
            this.isImageSelecting = true
            window.addEventListener('focus', () => {
                this.isImageSelecting = false
            }, { once: true })
            this.$refs.imageUploader.click()
        },

        async onImageFileChanged(e) {
            this.selectedImageFile = e.target.files[0];
            if(this.selectedImageFile !== undefined && this.selectedImageFile !== null) {
                this.isImageSelecting = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedImageFile);
                await uploadImage(fileData)
                .then((res) => {
                    this.returnTeamData.avatar = `/uploads/image/${res.data}`;
                    this.isImageSelecting = false
                    this.selectedImageFile = null
                }).catch((err) => {
                    //console.log(err);
                    this.isImageSelecting = false
                }); 
            }

            //reset image file input
            this.$refs.imageUploader.value = ''
        },

        async submit(){
            if(this.returnTeamData.avatar == null){
                return this.$snackbar.showMessage({content: "头像是空的", color: "error"})
            }
            if(this.returnTeamData.name.trim() == ''){
                return this.$snackbar.showMessage({content: "归程队名称为空", color: "error"})
            }
            if(this.returnTeamData.name.trim() == '留堂成员'){
                return this.$snackbar.showMessage({content: "请将该名称设置为其他名称", color: "error"})
            }
            if(this.returnTeamData.teacher == null){
                return this.$snackbar.showMessage({content: "选择负责返回团队的老师", color: "error"})
            }
            if(this.returnTeamData.member.length == 0){
                return this.$snackbar.showMessage({content: "请选择归程团队成员", color: "error"})
            }
            if(this.returnTeamData.leader == null){
                return this.$snackbar.showMessage({content: "请选择归程队组长", color: "error"})
            }
            console.log(this.returnTeamData)
            let payload = Object.assign({}, this.returnTeamData);
            payload.leader = payload.leader.id;
            payload.teacher = payload.teacher.id;
            let idArr = [];
            payload.member.map( member => {
                idArr.push(member.id);
            })
            payload.member = idArr;
            console.log(payload);
            this.isCreating = true;
            await createReturnTeam(payload)
            .then((res) => {
                this.$store.dispatch('returnteam/storeReturnTeamName', '');
                this.$store.dispatch('returnteam/storeReturnTeamAvatar', null);
                this.$store.dispatch('returnteam/storeReturnTeamLeader', null);
                this.$store.dispatch('member/storeSelectedGroup', null);
                this.$store.dispatch('member/storeSelectedTeacher', null);

                //make modified return team data to useful...
                this.$set(this.returnTeamData, "leader_id", this.returnTeamData.leader);
                this.$set(this.returnTeamData, "teacher_id", this.returnTeamData.teacher);
                
                if(this.todayReturnTeamArr.length == 0){
                    let arr = [];
                    arr.push(this.returnTeamData);
                    let remainTeam = {
                        avatar: "/",
                        checkbox: false,
                        id: res.data.remainTeamId,
                        isDelete: false,
                        leaderId: null,
                        leader_id: null,
                        lessonId: this.user.lessonId,
                        member: [],
                        name: "留堂成员",
                        postId: null,
                        schoolId: this.user.schoolId,
                        teacherId: null,
                        teacher_id: null,
                        userId: this.user.id
                    }
                    arr.push(remainTeam);
                    this.$store.dispatch('returnteam/storeTodayReturnTeamArr', arr)
                }
                else{ 
                    this.todayReturnTeamArr.unshift(this.returnTeamData);
                    this.$store.dispatch('returnteam/storeTodayReturnTeamArr', this.todayReturnTeamArr)
                }
                this.$store.dispatch('member/storeSelectedGroup', null);
                this.$router.push({name: 'classSpace.applications.returnTeam'});

            }).catch((err) => {
                
            });
            this.isCreating = false;
        },

        navToAddMember(){
            this.$store.dispatch('returnteam/storeReturnTeamName', this.returnTeamData.name);
            this.$store.dispatch('returnteam/storeReturnTeamAvatar', this.returnTeamData.avatar);
            this.$store.dispatch('returnteam/storeReturnTeamLeader', this.returnTeamData.leader);
            this.$router.push({name: 'classSpace.addMemberName'})
        },

        navToAddTeacher(){
            this.$store.dispatch('returnteam/storeReturnTeamName', this.returnTeamData.name);
            this.$store.dispatch('returnteam/storeReturnTeamAvatar', this.returnTeamData.avatar);
            this.$store.dispatch('returnteam/storeReturnTeamLeader', this.returnTeamData.leader);
            this.$router.push({name: 'classSpace.addTeacher'})
        },

        openSelectLeaderDialog(){
            this.selectLeaderDialog = true;

        },

        onSubmitSelectedLeader(){   
            this.selectLeaderDialog = false;
        },

        onSelectLeader(val){
            this.returnTeamData.leader = val;
        },

        navToBack(){
            this.$store.dispatch('returnteam/storeReturnTeamName', '');
            this.$store.dispatch('returnteam/storeReturnTeamAvatar', null);
            this.$store.dispatch('returnteam/storeReturnTeamLeader', null);
            this.$store.dispatch('member/storeSelectedGroup', null);
            this.$store.dispatch('member/storeSelectedTeacher', null);
            this.$router.push({name: 'classSpace.applications.returnTeam'});
        }
    }
}
</script>

<style>

</style>