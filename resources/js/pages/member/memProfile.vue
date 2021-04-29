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
                    <h2>会员资料</h2>
                </v-col>
            </v-row>
        </v-container>
        <v-banner>
            <v-row justify-space-between>
                <v-col cols="6" class="d-flex align-center">
                    <span>头像</span>
                </v-col>
                <v-col cols="6">
                    <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="primary" size="40" class="float-right">
                        <span class="white--text headline">{{user.name[0]}}</span>
                    </v-avatar>
                    <v-avatar v-else
                        size="40"
                        class="float-right"
                    >
                        <v-img :src="user.avatar"></v-img>
                    </v-avatar>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row justify-space-between>
                <v-col cols="6">
                    <span>昵称</span>
                </v-col>
                <v-col cols="6" class="text-right">
                    <span>{{user.name}}</span>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row justify-space-between>
                <v-col>
                    <span>二维码</span>
                </v-col>
                <v-col  class="float-right">
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                    <v-icon class="float-right">
                        mdi-qrcode-scan
                    </v-icon>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row>
                <v-col cols="6">
                    手机号
                </v-col>
                <v-col cols="6" class="text-right">
                    {{user.phoneNumber}}
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row>
                <v-col>
                    人员状态
                </v-col>
                <v-col class="text-right">
                    在办公室
                </v-col>
            </v-row>
        </v-banner>
        <div class="divider"></div>
        <v-banner>
            <v-row>
                <v-col cols="6">
                    教师发展档案
                </v-col>
                <v-col cols="6" class="text-right">
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row>
                <v-col cols="6">
                    个人分享
                </v-col>
                <v-col cols="6" class="text-right">
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
        </v-banner>
    </v-container>
</template>

<script>
import {getSelUser} from '~/api/user'
export default {
    data:()=>({
        user:null
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        await getSelUser({userId:this.currentPath.params.userId}).then(res=>{
            console.log(res.data)
            this.user = res.data
        }).catch(err=>{
            console.log(err.response)
        })
    }
}
</script>

<style>

</style>