<template>
    <v-container class="pa-0">
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
                    <h2>新建归程队</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn dark color="#7879ff" @click="submit" :loading="isUpdating">
                        新建归程队
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-container v-if="isRemainTeam == false">
            <v-row class="ma-0 hover-cursor-point" v-ripple @click="clickUploadImageBtn">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0" >头像 </p>
                    <div class="d-flex align-center">
                        <v-avatar size="50" :color="teamData.name == '' && teamData.avatar == null ? '#999999': '#7879ff'">
                            <v-img v-if="teamData.avatar !== null" :src="`${baseUrl}${teamData.avatar}`"> </v-img>
                            <span v-else-if="teamData.name !== ''" class="white--text headline">{{teamData.name[0]}}</span>
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
            <v-row class="ma-0 py-3 hover-cursor-point" v-ripple @click="$refs.returnTeamName.focus()">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0 w-100"  >归程队名称 </p>
                    <v-text-field
                        class="pt-0 mt-0"
                        color="#7879ff"
                        single-line
                        v-model="teamData.name"
                        label="清输入归程队名称"
                        hide-details
                        ref="returnTeamName"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point" v-ripple @click="navToAddTeacher">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0"  >领队教师 </p>
                    <div class="d-flex align-center">
                        <p class="mb-0 secondary-text">{{teamData.teacher_id.name}}</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point" v-ripple @click="navToAddMember">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0"  >归程队成员</p>
                    <div class="d-flex align-center">
                        <p v-if="teamData.member.length !== 0" class="mb-0 secondary-text">{{teamData.member.length}} 个已选择</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point" v-ripple @click="openSelectLeaderDialog">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0"  >归程队组长 </p>
                    <div class="d-flex align-center">
                        <p class="mb-0 secondary-text">{{teamData.leader_id.name}}</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-dialog v-model="selectLeaderDialog" width="100%" max-width="500">
                <v-card>
                    <v-card-title class="title"> 归程队组长 </v-card-title>
                    <v-card-text v-if="teamData.member.length == 0">
                        请首先选择归程团队成员
                    </v-card-text>
                    <v-card-text v-else class="">
                        <v-select 
                            :items="teamData.member"
                            :menu-props="{ top: false, offsetY: true }"
                            item-text="name"
                            item-value="id"
                            v-model="teamData.leader"
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
        <v-container class="pa-0" v-if="isRemainTeam == true">
            <v-row class="ma-0 hover-cursor-point" v-ripple @click="navToAddMember">
                <v-col cols="12" class="d-flex justify-space-between align-center pl-10 pr-6">
                    <p class="mb-0 ml-4">留堂成员</p>
                    <div class="d-flex align-center">
                        <p class="mb-0"> something</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
        </v-container>
        <v-container >
            <v-row class="ma-0 py-3">
                <v-col cols="12" v-if="teamData.member.length == 0" class="d-flex align-center justify-start">
                    <v-chip class="ma-2" color="primary" outlined pill >
                        没有人选择
                        <v-icon right>
                        mdi-cancel 
                        </v-icon>
                    </v-chip>
                </v-col>
                <v-col v-else v-for="(user, i) in teamData.member" :key="i" cols="12" sm="6" md="4" lg="3" xl="2" >
                    <v-card class="text-center pt-4 position-relative">
                        <v-avatar color="#7879ff" size="60" class="rounded-circle mx-auto"  >
                            <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                            <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                        </v-avatar>
                        <v-card-title class="justify-center">{{user.name}}</v-card-title>
                        <v-card-subtitle>{{pnEncrypt(user.phoneNumber)}}</v-card-subtitle>
                        <v-chip v-if="teamData.leader_id !== null && user.id == teamData.leader_id.id" dark class="position-absolute" color="#999999" style="top: 0px; right:0px;">
                            组长  
                        </v-chip>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex'
import {uploadImage} from '~/api/upload'
import {updateReturnTeam} from '~/api/returnteam'

export default {
    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        teamData: {
            avatar: null,
            name: '',
            teacher: null,
            leader: null,
            member: [],
        },
        isRemainTeam: false,
        selectLeaderDialog: false,
        isImageSelecting: false,
        selectedImageFile: null,
        isUpdating:false,

    }),

    computed: {
        currentPath() {
            return this.$route;
        },
        ...mapGetters({
            user: 'auth/user',
        }),
    },
    created(){

        if(this.currentPath.params.teamData == null || this.currentPath.params.teamData == undefined){
            return this.$router.push({name: 'classSpace.returnTeam'});
        }

        if(this.currentPath.params.teamData.name == '留堂成员'){
            this.isRemainTeam = true;
        }
        
        this.teamData = this.currentPath.params.teamData;
        this.$set(this.teamData.teacher_id, 'checkbox', true)
        this.teamData.member.map(member=>{
            this.$set(member, 'checkbox', true);
        });
        this.$store.dispatch('member/storeSelectedTeacher', this.teamData.teacher_id);
        this.$store.dispatch('member/storeSelectedGroup',this.teamData.member);
        console.log("this.teamData",this.teamData);

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
                    this.teamData.avatar = `/uploads/image/${res.data}`;
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

        openSelectLeaderDialog(){
            this.selectLeaderDialog = true;

        },

        onSubmitSelectedLeader(){   
            this.selectLeaderDialog = false;
        },

        onSelectLeader(val){
            this.teamData.leader = val;
        },

        navToAddMember(){
            this.$store.dispatch('returnteam/storeReturnTeamName', this.teamData.name);
            this.$store.dispatch('returnteam/storeReturnTeamAvatar', this.teamData.avatar);
            this.$store.dispatch('returnteam/storeReturnTeamLeader', this.teamData.leader);
            this.$router.push({name: 'classSpace.addMemberName'})
        },

        navToAddTeacher(){
            this.$store.dispatch('returnteam/storeReturnTeamName', this.teamData.name);
            this.$store.dispatch('returnteam/storeReturnTeamAvatar', this.teamData.avatar);
            this.$store.dispatch('returnteam/storeReturnTeamLeader', this.teamData.leader);
            this.$router.push({name: 'classSpace.addTeacher'})
        },

        async submit(){
            console.log(this.teamData)
            this.isUpdating = true;
            await updateReturnTeam()
            .then((res) => {
                this.$store.dispatch('returnteam/storeReturnTeamName', '');
                this.$store.dispatch('returnteam/storeReturnTeamAvatar', null);
                this.$store.dispatch('returnteam/storeReturnTeamLeader', null);
                this.$store.dispatch('member/storeSelectedGroup', null);
                this.$store.dispatch('member/storeSelectedTeacher', null);


                this.$store.dispatch('member/storeSelectedGroup', []);
                this.$router.push({name: 'classSpace.returnTeam'});
            }).catch((err) => {
                
            });
            this.isUpdating = false;
        }
    }
}
</script>

<style>

</style>