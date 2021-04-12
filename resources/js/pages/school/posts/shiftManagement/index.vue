<template>
    <v-container class="pa-0">
        <v-banner>
            <v-row class="ma-0">
                <v-col>
                    <div class="text-center d-flex justify-space-between align-center">
                        <a @click="$router.go(-1)" class="float-left">
                            <v-icon size="70">
                                mdi-chevron-left
                            </v-icon>
                        </a>
                        <span style="font-size:30px;line-height:2">接班管理</span> 
                        <div class="float-right">
                            <v-btn class="mr-3" @click="draft">
                                取消
                            </v-btn>
                            <v-btn dark color="#7879ff" @click="submit" :loading="isSubmit">
                                确定
                            </v-btn>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-banner>
        <v-container>
            <v-row class="ma-0 hover-cursor-point">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0" >姓名 </p>
                    <p class="mb-0" >{{shiftData.prevName}} </p>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0 w-100"  >交接人姓名 </p>
                    <v-select
                        :items="employeeList"
                        v-model="employeeObj"
                        item-text="name"
                        return-object
                    ></v-select>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <v-row>
                        <v-col cols="6">
                            <p class="mb-0"  >交接时间</p>
                        </v-col>
                        <v-col cols="6">
                            <v-datetime-picker 
                                label="交接时间" 
                                v-model="shiftData.scheduleDate"
                                :okText='lang.ok'
                                :clearText='lang.cancel'
                            ></v-datetime-picker>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point" @click="$refs.shiftItemList.focus()">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0"  >交接物品 </p>
                    <v-textarea
                        solo
                        v-model="shiftData.itemList"
                        class="pl-5"
                        ref="shiftItemList"
                    ></v-textarea>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>

import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex'
import {getEmployeeList} from '~/api/user'
import {createShiftMng} from '~/api/shiftMng'
export default {

    data: ()=> ({
        lang,
        baseUrl:window.Laravel.base_url,
        shiftData:{
            prevName:'',
            prevNameId:'',
            nextName:'',
            nextNameId:'',
            scheduleDate:'',
            itemList:'',
            schoolId:''
        },
        employeeList:[],
        employeeObj:null,
        isSubmit:false,
    }),

    computed:{
        ...mapGetters({
            user:'auth/user'
        }),
        currentPath(){
            return this.$route
        }
    },

    async created(){
        this.shiftData.prevName = this.user.name;
        this.shiftData.prevNameId = this.user.id;
        this.shiftData.schoolId = this.currentPath.params.schoolId
        await getEmployeeList().then(res=>{
            console.log("res.data",res.data)
            this.employeeList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
    },

    methods:{
        

        async submit(){
            this.shiftData.nextName = this.employeeObj.name
            this.shiftData.nextNameId = this.employeeObj.id
            if(this.shiftData.nextName == ''){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            if(this.shiftData.scheduleDate == ''){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            if(this.shiftData.itemList == ''){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            this.isSubmit = true
            createShiftMng(this.shiftData).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                this.isSubmit = false
                console.log(err.response)
            })
        },

        draft(){

        },

    }
}
</script>

<style>

</style>