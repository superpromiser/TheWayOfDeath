<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/icon/请假.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">请假单审批</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow mt-5">
            <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                <span class="mr-14 pa-3 mo-glow-inverse">请假人</span>
                <v-text-field
                    class="mo-glow-v-text"
                    solo
                    v-model="newVacationData.studentName"
                    label="请假人"
                    hide-details
                    readonly
                ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                <span class="mr-14 pa-3 mo-glow-inverse">审批人</span>
                <v-text-field
                    class="mo-glow-v-text"
                    solo
                    v-model="newVacationData.teacherName"
                    label="审批人"
                    hide-details
                    readonly
                ></v-text-field>
            </v-col>
        
            <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                <span class="mr-10 pa-3 mo-glow-inverse">开始时间</span>
                <v-datetime-picker 
                    label="开始时间" 
                    v-model="newVacationData.startTime"
                    :okText='lang.ok'
                    :clearText='lang.cancel'
                    :disabled="true"
                > </v-datetime-picker>
            </v-col>
            <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                <span class="mr-10 pa-3 mo-glow-inverse">结束时间</span>
                <v-datetime-picker 
                    label="结束时间" 
                    v-model="newVacationData.endTime"
                    :okText='lang.ok'
                    :clearText='lang.cancel'
                    :disabled="true"
                > </v-datetime-picker>
            </v-col>
        
            <v-col cols="12" class="d-flex justify-space-between align-start">
                <span class="mr-10 pa-3 mo-glow-inverse ">请假原因</span>
                <v-textarea
                    class="mo-glow-v-text"
                    solo
                    v-model="newVacationData.reason"
                    label="请假原因"
                    hide-details
                    readonly
                ></v-textarea>
            </v-col>
        
            <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                <span class="pa-3 mo-glow">病假</span>
                <v-switch
                    v-model="newVacationData.reasonFlag"
                    color="error"
                    readonly
                    hide-details
                    class="pt-0 mt-0"
                ></v-switch>
                <span class="pa-3 mo-glow">事假</span>
            </v-col>
        
            <v-col cols="12" sm="6" class="d-flex justify-space-around">
                <span class="mr-10">假期类型</span>
                <span class="mr-auto " v-if="newVacationData.reasonFlag == false">病假</span>
                <span class="mr-auto " v-else >事假</span>
                <v-checkbox
                    v-model="newVacationData.isHeat"
                    label="是否发热"
                    color="error"
                    hide-details
                    readonly
                    class="mt-0 pt-0"
                ></v-checkbox>
            </v-col>
        
            <v-col v-if="newVacationData.reasonFlag == false" cols="12" class="d-flex justify-space-between align-start">
                <span class="mr-16 pa-3 mo-glow-inverse">症状</span>
                <v-textarea
                    solo
                    v-model="newVacationData.painDesc"
                    label="症状"
                    hide-details
                    readonly
                    class="mo-glow-v-text"
                ></v-textarea>
            </v-col>
            <v-col cols="12" class="d-flex align-center mb-10">
                <v-btn small fab class="mo-glow mr-auto" style="color:#eb6846" @click="$router.go(-1)"><v-icon>mdi-undo-variant</v-icon></v-btn>
                <v-btn
                    dark
                    color="#7879ff"
                    rounded
                    @click="allowVacation"
                    :loading="isAllow"
                    class="mr-3 ml-auto"
                >
                    <v-icon left>
                        mdi-check-decagram-outline 
                    </v-icon>
                    通过
                </v-btn>
                <v-btn
                    dark
                    color="error"
                    rounded
                    @click="denyVacation"
                    :loading="isDeny"
                    
                >
                    <v-icon left>
                        mdi-hand-left
                    </v-icon>
                    驳回
                </v-btn>
                
            </v-col>
        </v-row>
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
                    <h2>请假单审批</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        dark
                        color="#f19861"
                        class="mx-2"
                        tile
                        @click="reasonFlag = !reasonFlag"
                    >
                        <v-icon left>
                            mdi-hand-left
                        </v-icon>
                        驳回
                    </v-btn>
                    <v-btn
                        dark
                        color="#7879ff"
                        class=""
                        tile
                        @click="allowVacation"
                        :loading="isAllow"
                    >
                        <v-icon left>
                            mdi-check-decagram-outline 
                        </v-icon>
                        通过
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                    <span class="mr-14">请假人</span>
                    <v-text-field
                        solo
                        v-model="newVacationData.studentName"
                        label="请假人"
                        hide-details
                        readonly
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                    <span class="mr-14">审批人</span>
                    <v-text-field
                        solo
                        v-model="newVacationData.teacherName"
                        label="审批人"
                        hide-details
                        readonly
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                    <span class="mr-10">开始时间</span>
                    <v-datetime-picker 
                        label="开始时间" 
                        v-model="newVacationData.startTime"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                        :disabled="true"
                    > </v-datetime-picker>
                </v-col>
                <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                    <span class="mr-10">结束时间</span>
                    <v-datetime-picker 
                        label="结束时间" 
                        v-model="newVacationData.endTime"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                        :disabled="true"
                    > </v-datetime-picker>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" class="d-flex justify-space-between align-start">
                    <span class="mr-10 mt-3">请假原因</span>
                    <v-textarea
                        solo
                        v-model="newVacationData.reason"
                        label="请假原因"
                        hide-details
                        readonly
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="12" sm="6" class="d-flex justify-space-around">
                    <span class="hover-cursor-point">病假</span>
                    <v-switch
                        v-model="newVacationData.reasonFlag"
                        color="primary"
                        readonly
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                    <span class="hover-cursor-point">事假</span>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="6" class="d-flex justify-space-around">
                    <span class="mr-10">假期类型</span>
                    <span class="mr-auto " v-if="newVacationData.reasonFlag == false">病假</span>
                    <span class="mr-auto " v-else >事假</span>
                    <v-checkbox
                        v-model="newVacationData.isHeat"
                        label="是否发热"
                        color="error"
                        hide-details
                        readonly
                        class="mt-0 pt-0"
                    ></v-checkbox>
                </v-col>
            </v-row>
            <v-row v-if="newVacationData.reasonFlag == false">
                <v-col cols="12" class="d-flex justify-space-between align-start">
                    <span class="mr-16 mt-3">症状</span>
                    <v-textarea
                        solo
                        v-model="newVacationData.painDesc"
                        label="症状"
                        hide-details
                        readonly
                        class="ml-2"
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-dialog
                    v-model="reasonFlag"
                    persistent
                    max-width="600px"
                >
                    <v-card>
                        <v-card-title>
                            <!-- <span class="headline">添加围栏</span> -->
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                    <v-textarea
                                        label=""
                                        required
                                        v-model="reason"
                                    ></v-textarea>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="reasonFlag = false"
                            >
                                关闭
                            </v-btn>
                            <v-btn
                                color="blue darken-1"
                                text
                                :loading="isSaving"
                                @click="denyVacation"
                            >
                                保存
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>

import { mapGetters } from 'vuex'
import {getCurrentData,updateVacationData} from '~/api/vacation'
import lang from '~/helper/lang.json'

export default {
    data: () => ({
        lang,
        baseUrl: window.Laravel.base_url,
        isAllow:false,
        isDeny:false,
        isSaving:false,
        reasonFlag:false,
        reason:"",
        newVacationData : {
            // studentName:'something',
            // teacherName:'something',
            // reasonFlag: true,
            // startTime: '2021-03-08 09:25',
            // endTime: '2021-03-08 10:25',
            // reason: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            // painDesc: 'asdf',
            // isHeat: true
        },
    }),

    components: {
        
    },

    computed: {
        ...mapGetters({
            user : 'auth/user'
        }),
        currentPath(){
            return this.$route
        }
    },

    async created(){
        //you need to get teacher's name from server or vuex...
        // this.newVacationData.teacherName = this.....
        // this.isLoading = true
        await getCurrentData({vId:this.currentPath.params.vId}).then(res=>{
            console.log(res.data)
            this.newVacationData = res.data
            this.newVacationData.startTime = this.TimeView(this.newVacationData.startTime)
            this.newVacationData.endTime = this.TimeView(this.newVacationData.endTime)
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
        })
        this.isLoading = false
        // this.newVacationData.studentName = this.user.name;
    },

    mounted(){
        
    },

    methods:{
        postVacationData(){
            //console.log(this.newVacationData);
        },

        async allowVacation(){
            this.isAllow = true
            await updateVacationData({status:'allow',vId:this.currentPath.params.vId}).then(res=>{
                console.log(res.data)
                this.isAllow = false
                this.$router.push({name:'posts.attendance.vacation'})
            }).catch(err=>{
                this.isAllow = false
                console.log(err.response)
            })
        },

        async denyVacation(){
            if(this.reason == ''){
                return this.$snackbar.showMessage({content: "必须至少选择一个", color: "error"})
            }
            this.isSaving = true
            await updateVacationData({status:'deny',vId:this.currentPath.params.vId,denyReason:this.reason}).then(res=>{
                console.log(res.data)
                this.isSaving = false
                this.reason = ''
                this.$router.push({name:'posts.attendance.vacation'})
            }).catch(err=>{
                console.log(err.response)
                this.isSaving = false
            })
        },
        
    }
}
</script>

<style>

</style>