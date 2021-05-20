<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white mb-16 pb-10-px pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >访客管理</p>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0">
                <v-col cols="12" v-if="loading" class="d-flex align-center justify-center pa-5" >
                    <v-progress-circular
                        indeterminate
                        color="#7879ff"
                    ></v-progress-circular>
                </v-col>
                <v-col cols="12" v-else-if="noData" class="d-flex align-center justify-center pa-5">
                    <v-chip class="ma-2" color="#7879ff" outlined pill >
                        没有客人 <v-icon right> mdi-cancel  </v-icon>
                    </v-chip>
                </v-col>
                <v-col cols="12" sm="12" md="6" v-else v-for="(guest, i) in guestRequestData" :key="i">
                    <v-card>
                        <v-img height="250" :src="`${baseUrl}${guest.avatar}`" ></v-img>
                        <v-card-text>
                            <v-row class="ma-0 d-flex align-center justify-space-between mb-3">
                                <h3 class="">姓名: {{guest.name}}</h3>
                                <v-chip v-if="guest.status == 'allow'" color="#7879ff" outlined>致谢</v-chip>
                                <v-chip v-if="guest.status == 'deny'" color="#F19861" outlined>拒绝</v-chip>
                            </v-row>
                            <v-divider light></v-divider>
                            <v-row class="ma-0 mt-3">
                                <p>电话: {{guest.phoneNumber}}</p>
                            </v-row>
                            <v-row class="ma-0">
                                <p>身份证件: {{guest.cardNum}}</p>
                            </v-row>
                            <v-row class="ma-0">
                                <p>到访时间: {{TimeView(guest.meetingDate)}}</p>
                            </v-row>
                            <v-row class="ma-0">
                                <p>被访人姓名: {{guest.memberName}}</p>
                            </v-row>
                            <v-row class="ma-0">
                                <p>状态: {{convertStatus(guest.status)}}</p>
                            </v-row>
                            <v-row class="ma-0">
                                <p class="">访问事件: {{guest.meetingReason}}</p>
                            </v-row>
                        </v-card-text>
                         <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="#7879ff" @click="allowGuest(guest)" :disabled="guest.status == 'allow'" :loading="guest.isAllow">
                                同意
                            </v-btn>
                            <v-btn text color="#F19861" @click="denyGuest(guest)" :disabled="guest.status == 'deny'" :loading="guest.isDeny">
                                拒绝
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
        <RouterBack title='访客管理'></RouterBack>
        <v-row class="ma-0">
            <v-col cols="12" class="text-center" v-if="loading">
                <v-progress-circular
                    indeterminate
                    color="#7879ff"
                ></v-progress-circular>
            </v-col>
            <v-col cols="12" class="text-center" v-else-if="noData">
                <v-chip class="ma-2" color="#7879ff" outlined pill >
                    没有客人 <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-col>
            <v-col cols="12" sm="12" md="6" v-else v-for="(guest, i) in guestRequestData" :key="i">
                <v-hover v-slot="{ hover }">
                    <v-card class="position-relative">
                        <div class="d-flex ">
                            <img :src="`${baseUrl}${guest.avatar}`" style="width:45%;"/>
                            <v-container>
                                <v-row class="ma-0 d-flex align-center justify-space-between">
                                    <h3 class="mb-5">姓名: {{guest.name}}</h3>
                                    <v-chip v-if="guest.status == 'allow'" color="#7879ff" outlined>致谢</v-chip>
                                    <v-chip v-if="guest.status == 'deny'" color="#F19861" outlined>拒绝</v-chip>
                                </v-row>
                                <v-divider light></v-divider>
                                <v-row class="ma-0 mt-3">
                                    <p>电话: {{guest.phoneNumber}}</p>
                                </v-row>
                                <v-row class="ma-0">
                                    <p>身份证件: {{guest.cardNum}}</p>
                                </v-row>
                                <v-row class="ma-0">
                                    <p>到访时间: {{TimeView(guest.meetingDate)}}</p>
                                </v-row>
                                <v-row class="ma-0">
                                    <p>被访人姓名: {{guest.memberName}}</p>
                                </v-row>
                                <v-row class="ma-0">
                                    <p>状态: {{convertStatus(guest.status)}}</p>
                                </v-row>
                                <v-row class="ma-0">
                                    <p class="">访问事件: {{guest.meetingReason}}</p>
                                </v-row>
                            </v-container>
                        </div>
                        <v-expand-transition>
                            <div v-if="hover" class="transition-fast-in-fast-out position-absolute d-flex align-center justify-center guest-control-hover">
                                <div class="pa-2 px-10">
                                    <div>
                                        <v-btn fab x-large color="#7879ff" dark @click="allowGuest(guest)" :disabled="guest.status == 'allow'" :loading="isUpdatingGuestAllow">
                                            同意
                                        </v-btn>
                                    </div>
                                    <div class="mt-7">
                                        <v-btn fab x-large color="#F19861" dark @click="denyGuest(guest)" :disabled="guest.status == 'deny'" :loading="isUpdatingGuestDeny">
                                            拒绝
                                        </v-btn>
                                    </div>
                                </div>
                            </div>
                        </v-expand-transition>
                    </v-card>
                </v-hover>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import { getGuestRequest, updateGuestRequest } from '~/api/guestMng'
import RouterBack from '~/components/routerBack'
export default {
    components:{
        RouterBack,
    },

    data: ()=> ({
        baseUrl: window.Laravel.base_url,
        guestRequestData: [],
        isUpdatingGuestAllow: false,
        isUpdatingGuestDeny: false,
        loading: false,
        noData: false,
    }),

    computed:{
        ...mapGetters({
            user: 'auth/user'
        })
    },

    async created(){
        this.listen();
        this.loading = true;
        await getGuestRequest()
        .then((res) => {
            this.guestRequestData = res.data;
            if(this.guestRequestData.length == 0){
                this.noData = true;
            }
            console.log("this.getGuestRequest", this.guestRequestData);
            this.guestRequestData.map(v=>{
                this.$set(v, 'isAllow', false)
                this.$set(v, 'isDeny', false)
            })
        }).catch((err) => {
            console.log(err);
        });
        this.loading = false;
    },
    
    methods: {
        convertStatus(status){
            switch (status) {
                case 'pending':
                    return "等待"
                case 'allow':
                    return "致谢"
                case 'deny':
                    return "已拒绝"

            }
        },
        
        async allowGuest(guest){
            
            // this.isUpdatingGuestAllow = true;
            guest.isAllow = true;
            let payload = {
                id: guest.id,
                status: 'allow'
            }
            await updateGuestRequest(payload)
            .then((res) => {
                guest.status = 'allow';
            }).catch((err) => {
                
            });
            guest.isAllow = false;
            // this.isUpdatingGuestAllow = false;
        },

        async denyGuest(guest){
            
            // this.isUpdatingGuestDeny = true;
            guest.isDeny = true;
            let payload = {
                id: guest.id,
                status: 'deny',
            }
            await updateGuestRequest(payload)
            .then((res) => {
                guest.status = 'deny';
            }).catch((err) => {
                
            });
            // this.isUpdatingGuestDeny = false;\
            guest.isDeny = false;
        },

        listen(){
            Echo.private('newguest.'+ this.user.id)
                .listen('NewGuest', (alarm) => {
                    this.guestRequestData.push(alarm.guest.content);
                });
            },
    }
}
</script>

<style>

</style>