<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/请假.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>请假</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                dark
                color="green lighten-1"
                class="mr-md-8"
                tile
                :loading="isLoading"
                @click="postVacationData"
            >
                提交
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
                    > </v-datetime-picker>
                </v-col>
                <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                    <span class="mr-10">结束时间</span>
                    <v-datetime-picker 
                        label="结束时间" 
                        v-model="newVacationData.endTime"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
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
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-center">
                <v-col cols="12" sm="6" class="d-flex justify-space-around">
                    <span @click="newVacationData.reasonFlag = false" class="hover-cursor-point">病假</span>
                    <v-switch
                        v-model="newVacationData.reasonFlag"
                        color="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                    <span @click="newVacationData.reasonFlag = true" class="hover-cursor-point">事假</span>
                </v-col>
            </v-row>
            <transition v-if="newVacationData.reasonFlag == false" name="page" mode="out-in">
                <v-row >
                    <v-col cols="12">
                        <v-checkbox
                            v-model="newVacationData.isHeat"
                            label="是否发热"
                            color="error"
                            hide-details
                        ></v-checkbox>
                    </v-col>
                    <v-col cols="12" class="d-flex justify-space-between align-start">
                        <span class="mr-10 mt-3">症状</span>
                        <v-textarea
                            solo
                            v-model="newVacationData.painDesc"
                            label="症状"
                            hide-details
                        ></v-textarea>
                    </v-col>
                </v-row>
            </transition>
        </v-container>
    </v-container>
</template>

<script>

import { mapGetters } from 'vuex'
import lang from '~/helper/lang.json'
import {getBanziName,createVacationData} from '~/api/vacation'
export default {
    data: () => ({
        lang,
        baseUrl: window.Laravel.base_url,
        newVacationData : {
            studentName:'',
            teacherName:'',
            reasonFlag: true,
            startTime: '',
            endTime: '',
            reason: '',
            painDesc: '',
            isHeat: false,
            teacherId:null,
            schoolId:null,
        },
        isLoading:false,
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
        getBanziName().then(res=>{
            console.log(res.data)
            this.newVacationData.teacherName = res.data.name
            this.newVacationData.teacherId = res.data.id
        }).catch(err=>{
            console.log(err.response)
        })
        this.newVacationData.studentName = this.user.name;
        this.newVacationData.schoolId = this.currentPath.params.schoolId;
    },

    mounted(){
        
    },

    methods:{
        async postVacationData(){
            console.log(this.newVacationData);
            this.isLoading = true
            await createVacationData(this.newVacationData).then(res=>{
                console.log(res.data)
                this.isLoading = false
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                console.log(err.response)
            })
        }
        
    }
}
</script>

<style>

</style>