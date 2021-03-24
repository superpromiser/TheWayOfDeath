<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/请假.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>请假单审批</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                dark
                color="green lighten-1"
                class="mr-md-8"
                tile
                @click="allowVacation"
            >
                <v-icon left>
                    mdi-check-decagram-outline 
                </v-icon>
                通过
            </v-btn>
            <v-btn
                dark
                color="error"
                class="mr-8"
                tile
                @click="denyVacation"
            >
                <v-icon left>
                    mdi-hand-left
                </v-icon>
                驳回
            </v-btn>
            </template>
        </v-banner>
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
            <v-row v-if="newVacationData.reasonFlag == true">
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
        </v-container>
    </v-container>
</template>

<script>

import { mapGetters } from 'vuex'
import lang from '~/helper/lang.json'

export default {
    data: () => ({
        lang,
        baseUrl: window.Laravel.base_url,
        newVacationData : {
            studentName:'something',
            teacherName:'something',
            reasonFlag: false,
            startTime: '2021-03-08 09:25',
            endTime: '2021-03-08 10:25',
            reason: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            painDesc: 'asdf',
            isHeat: true
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

    created(){
        //you need to get teacher's name from server or vuex...
        // this.newVacationData.teacherName = this.....

        this.newVacationData.studentName = this.user.name;
    },

    mounted(){
        
    },

    methods:{
        postVacationData(){
            //console.log(this.newVacationData);
        },

        allowVacation(){

        },

        denyVacation(){

        },
        
    }
}
</script>

<style>

</style>