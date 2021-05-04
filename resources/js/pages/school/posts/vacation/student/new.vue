<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/newIcon/请假单.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">请假</h2>
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
                <span class="mr-11 pa-3 mo-glow-inverse">开始时间</span>
                <v-datetime-picker 
                    label="开始时间" 
                    v-model="newVacationData.startTime"
                    :okText='lang.ok'
                    :clearText='lang.cancel'
                > </v-datetime-picker>
            </v-col>
            <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                <span class="mr-11 pa-3 mo-glow-inverse">结束时间</span>
                <v-datetime-picker 
                    label="结束时间" 
                    v-model="newVacationData.endTime"
                    :okText='lang.ok'
                    :clearText='lang.cancel'
                > </v-datetime-picker>
            </v-col>
        
            <v-col cols="12" class="d-flex justify-space-between align-start">
                <span class="mr-11  pa-3 mo-glow-inverse">请假原因</span>
                <v-textarea
                    class="mo-glow-v-text"
                    solo
                    v-model="newVacationData.reason"
                    label="请假原因"
                    hide-details
                ></v-textarea>
            </v-col>
        
            <v-col cols="12" sm="6" class="d-flex justify-space-between align-center">
                <span @click="newVacationData.reasonFlag = false" class="  pa-3 mo-glow">病假</span>
                <v-switch
                    v-model="newVacationData.reasonFlag"
                    color="error"
                    hide-details
                    class="pt-0 mt-0"
                ></v-switch>
                <span @click="newVacationData.reasonFlag = true" class=" pa-3 mo-glow">事假</span>
            </v-col>
       
            <transition  name="page" mode="out-in">
                <v-col cols="12" v-if="newVacationData.reasonFlag == false">
                    <v-checkbox
                        v-model="newVacationData.isHeat"
                        label="是否发热"
                        color="error"
                        hide-details
                    ></v-checkbox>
                </v-col>
            </transition>
            <transition  name="page" mode="out-in">
                <v-col v-if="newVacationData.reasonFlag == false" cols="12" class="d-flex justify-space-between align-start">
                    <span class="mr-10 mt-3 pa-3 mo-glow-inverse">症状</span>
                    <v-textarea
                        class="mo-glow-v-text"
                        solo
                        v-model="newVacationData.painDesc"
                        label="症状"
                        hide-details
                    ></v-textarea>
                </v-col>
            </transition>

            <v-col cols="12" sm="6" class="d-flex justify-end align-center">
                <v-btn small fab class="mo-glow ml-auto mr-3" style="color:#eb6846" @click="$router.go(-1)"><v-icon>mdi-undo-variant</v-icon></v-btn>
                <v-btn
                    dark
                    color="#7879ff"
                    rounded
                    :loading="isLoading"
                    @click="postVacationData"
                >
                    提交
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
    <v-container class="pa-0" v-else>
        <v-container class="banner-custom mb-10 z-index-2">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>请假</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        tile
                        color="#7879ff"
                        class="mr-5"
                        :loading="isLoading"
                        @click="postVacationData"
                        >
                        <v-icon left>
                            mdi-book-plus 
                        </v-icon>
                        提交
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
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                console.log(err.response)
            })
        }
        
    }
}
</script>

<style>

</style>