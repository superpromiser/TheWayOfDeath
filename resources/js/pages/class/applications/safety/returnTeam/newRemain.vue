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
                
                <v-row class="ma-0  hover-cursor-point" v-ripple @click="navToAddMember">
                    <v-col cols="12" class="d-flex justify-space-between align-center">
                        <p class="mb-0 font-size-0-8"  >归程队成员</p>
                        <div class="d-flex align-center">
                            <p v-if="remainTeamData.member.length !== 0" class="mb-0 secondary-text">{{remainTeamData.member.length}} 个已选择</p>
                            <v-icon class="ml-2" color="#999999" size="25">
                                mdi-chevron-right
                            </v-icon>
                        </div>
                    </v-col>
                </v-row>
                
                <v-divider light class="thick-border"></v-divider>
                <v-row class="ma-0 ">
                    <v-col cols="12" v-if="remainTeamData.member.length == 0" class="d-flex align-center justify-start">
                        <v-chip class="ma-2" color="primary" outlined pill >
                            没有人选择
                            <v-icon right>
                            mdi-cancel 
                            </v-icon>
                        </v-chip>
                    </v-col>
                    <v-col class="pa-0 px-3 pt-1" v-else v-for="(user, i) in remainTeamData.member" :key="i" cols="12" sm="6" md="4" lg="3" xl="2" >
                        <div class="w-100 d-flex align-center">
                            <v-avatar color="#49d29e" size="60" class="rounded-lg"  >
                                <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                                <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                            </v-avatar>
                            <div class="ml-3">
                                <p >{{user.name}}</p>
                                <p class="mb-0">{{ pnEncrypt(user.phoneNumber) }}</p>
                            </div>
                        </div>
                        <div v-if="i < remainTeamData.member.length - 1" class=" cus-divider-light-gray-height"></div>
                    </v-col>
                </v-row>
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
            <v-row class="ma-0 py-2 hover-cursor-point" v-ripple @click="navToAddMember">
                <v-col cols="12" class="d-flex justify-space-between align-center pl-10 pr-8">
                    <p class="mb-0"  >归程队成员</p>
                    <div class="d-flex align-center">
                        <p v-if="remainTeamData.member.length !== 0" class="mb-0 secondary-text">{{remainTeamData.member.length}} 个已选择</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <v-divider light class="thick-border"></v-divider>
            <v-row class="ma-0 py-2 pl-8 pr-8">
                <v-col cols="12" v-if="remainTeamData.member.length == 0" class="d-flex align-center justify-start">
                    <v-chip class="ma-2" color="primary" outlined pill >
                        没有人选择
                        <v-icon right>
                        mdi-cancel 
                        </v-icon>
                    </v-chip>
                </v-col>
                <v-col v-else v-for="(user, i) in remainTeamData.member" :key="i" cols="12" sm="6" md="4" lg="3" xl="2" class="" >
                    <v-card class="text-center pt-4 position-relative">
                        <v-avatar color="#7879ff" size="60" class="rounded-circle mx-auto"  >
                            <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                            <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                        </v-avatar>
                        <v-card-title class="justify-center">{{user.name}}</v-card-title>
                        <v-card-subtitle>{{pnEncrypt(user.phoneNumber)}}</v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>

import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex'
import {createRemainTeam,} from '~/api/returnteam'

export default {

    data: ()=> ({
        lang,
        baseUrl:window.Laravel.base_url,
        isImageSelecting: false,
        selectedImageFile: null,
        selectLeaderDialog: false,
        remainTeamData: {
            member: [],
        },
        isCreating: false,
    }),

    computed:{
        ...mapGetters({
            user: 'auth/user',
            selectedGroup: 'member/selectedGroup',
            todayReturnTeamArr: 'returnteam/todayReturnTeamArr',
        }),
    },

    created(){
        if(this.selectedGroup !== null){
            this.remainTeamData.member = this.selectedGroup
        }
    },

    methods:{
        async submit(){
            if(this.remainTeamData.member.length == 0){
                return this.$snackbar.showMessage({content: "请选择归程团队成员", color: "error"})
            }
            let payload = Object.assign({}, this.remainTeamData);
            let idArr = [];
            payload.member.map( member => {
                idArr.push(member.id);
            })
            payload.member = idArr;
            this.isCreating = true;
            await createRemainTeam(payload)
            .then((res) => {
                if(res.data.msg == 1){
                    this.$store.dispatch('member/storeSelectedGroup', null);
                    this.$store.dispatch('returnteam/storeIsCreateNewRemain', false);
                    this.$store.dispatch('returnteam/storeTodayReturnTeamArr', null);
                    
                    if(this.$isMobile()){
                        this.$router.push({name: 'home'})
                    }
                    else{
                        this.$router.push({name: 'classSpace.application'});
                        
                    }
                }
                else if(res.data.msg == 'alreadyExist'){
                    this.$store.dispatch('member/storeSelectedGroup', null);
                    this.$store.dispatch('returnteam/storeIsCreateNewRemain', false);
                    this.$snackbar.showMessage({content: '今天的留堂成员已经存在', color: 'error'})
                    this.$router.go(-1);
                }
                else{
                    this.$router.go(-1);
                }
            }).catch((err) => {
                
            });
            this.isCreating = false;
        },

        navToAddMember(){
            this.$store.dispatch('returnteam/storeIsCreateNewRemain', true);
            this.$router.push({name: 'classSpace.addMemberName'})
        },

        navToBack(){
            this.$store.dispatch('member/storeSelectedGroup', null);
            this.$store.dispatch('returnteam/storeIsCreateNewRemain', false);
            this.$router.push({name: 'classSpace.applications.returnTeam'});
        }
    }
}
</script>

<style>

</style>