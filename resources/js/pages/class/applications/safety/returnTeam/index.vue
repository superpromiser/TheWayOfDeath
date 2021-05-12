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
                    <h2>归程队管理</h2>
                </v-col>
                <v-col v-if="user.roleId == 1 || user.roleId == 2 || user.roleId == 3 || user.roleId == 7" cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn dark color="#3989ff" link :to="{name: 'classSpace.remainReturnTeam'}">
                        历史留堂
                    </v-btn>
                    <v-btn dark class="mx-2" color="#feb31a" link :to="{name: 'classSpace.detailReturnTeam', params:{ teamData: remainTeam}}">
                        发布留堂信息
                    </v-btn>
                    <v-btn dark color="#7879ff" link :to="{name: 'classSpace.newReturnTeam'}">
                        新建归程队
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-container v-if="isLoading" class="d-flex align-center justify-center">
            <v-progress-circular
                indeterminate
                color="primary"
            ></v-progress-circular>
        </v-container>
        <v-container v-else-if="noData" class="d-flex justify-center align-center">
            <v-chip class="ma-2" color="primary" outlined pill >
                暂无
                <v-icon right>
                mdi-cancel 
                </v-icon>
            </v-chip>
        </v-container>
        <v-container v-else class="pa-0">
            <v-row  v-if="returnTeam.name !==  '留堂成员'" class="ma-0 hover-cursor-point" v-ripple v-for="(returnTeam, i) in todayReturnTeamArr" :key="i" @click="navToDetail(returnTeam)">
                <v-col cols="12" class="d-flex justify-space-between align-center pl-10 pr-6">
                    <div class="d-flex align-center">
                        <v-avatar size="50" :color="returnTeam.name == '' && returnTeam.avatar == null ? '#999999': '#7879ff'">
                            <v-img v-if="returnTeam.avatar !== null" :src="`${baseUrl}${returnTeam.avatar}`"> </v-img>
                            <span v-else-if="returnTeam.name !== ''" class="white--text headline">{{returnTeam.name[0]}}</span>
                            <v-icon v-else dark >
                                mdi-account
                            </v-icon>
                        </v-avatar>
                        <p class="mb-0 ml-4"  >{{returnTeam.name}} </p>
                    </div>
                    <div class="d-flex align-center">
                        <p class="mb-0"> {{returnTeam.leader_id.name}} 和另外 {{returnTeam.member.length - 1}}个人</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
                <div v-if="i<todayReturnTeamArr.length-1" class="cus-divider-light-gray-height"></div>
            </v-row>
            <v-divider v-if="remainTeam !== null" light class="thick-border"></v-divider>
            <v-row  v-if="remainTeam !== null" class="ma-0 hover-cursor-point" v-ripple @click="navToDetail(remainTeam)">
                <v-col cols="12" class="d-flex justify-space-between align-center pl-10 pr-6">
                    <div class="d-flex align-center">
                        <v-avatar size="50" :color="remainTeam.name == '' && remainTeam.avatar == null ? '#999999': '#7879ff'">
                            <span  class="white--text headline">留</span>
                        </v-avatar>
                        <p class="mb-0 ml-4"  >{{remainTeam.name}} </p>
                    </div>
                    <v-icon class="ml-4" color="#999999" size="40">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import { getReturnTeam } from '~/api/returnteam';

export default {
    components:{
        
    },

    computed:{
        ...mapGetters({
            todayReturnTeamArr: 'returnteam/todayReturnTeamArr',
            user: 'auth/user'
        })
    },

    data: ()=> ({
        baseUrl: window.Laravel.base_url,
        remainTeam: null,
        isLoading: false,
        noData: false,
        remainTeamArr: [],
    }),

    async created(){
        console.log("this.todayReturnTeamArr", this.todayReturnTeamArr);
        if(this.todayReturnTeamArr == null){
            let todayTeamArr = [];
            let remainTeamArr = [];
            this.isLoading = true;
            await getReturnTeam()
            .then((res) => {
                console.log(res)
                res.data.returnTeamArr.map(returnTeam=>{
                    if(returnTeam.name !== '留堂成员'){
                        todayTeamArr.push(returnTeam);
                    }
                    console.log("!!!!!!!!!",this.isToday(returnTeam.updated_at))
                    if( returnTeam.name == '留堂成员' && (this.isToday(returnTeam.updated_at) == true)){
                        console.log(this.isToday(returnTeam.updated_at))
                        todayTeamArr.push(returnTeam);
                        this.$set(returnTeam, "checkbox", false);
                        this.$set(returnTeam, "isDelete", false);
                        this.remainTeam = returnTeam;
                    }
                    if(returnTeam.name == '留堂成员'){
                        this.$set(returnTeam, "checkbox", false);
                        this.$set(returnTeam, "isDelete", false);
                        remainTeamArr.push(returnTeam);
                    }
                });
    
                if(todayTeamArr.length == 0){
                    this.noData = true;
                }
                this.$store.dispatch('returnteam/storeRemainTeamArr', remainTeamArr);
                this.$store.dispatch('returnteam/storeTodayReturnTeamArr', todayTeamArr);
            }).catch((err) => {
                
            }); 
            this.isLoading = false;
        }
        else{
            if(this.todayReturnTeamArr.length == 0){
                this.noData = true;
            }
            else{
                this.todayReturnTeamArr.map(x=>{
                    if(x.name == '留堂成员'){
                        this.remainTeam = x;
                    }
                });
            }
        }
    },

    methods:{
        navToDetail(returnTeam){
            this.$store.dispatch('returnteam/storeIsDetail', true);
            this.$store.dispatch('returnteam/storeDetailData', returnTeam);
            this.$router.push({name: 'classSpace.detailReturnTeam'});
        },
    }
}
</script>

<style>

</style>