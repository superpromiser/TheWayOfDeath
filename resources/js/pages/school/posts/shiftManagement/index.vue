<template>
    <v-container v-if="$isMobile()" class="ma-0 pa-0 h-100">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.shiftMng}}</p>
                <v-btn @click="submit" :loading="isSubmit" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0 hover-cursor-point">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <v-text-field
                        color="#7879ff"
                        v-model="shiftData.prevName"
                        readonly
                        label="姓名"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="ma-0  hover-cursor-point">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <v-select
                        label="交接人姓名"
                        :items="employeeList"
                        v-model="employeeObj"
                        :menu-props="{ top: false, offsetY: true }"
                        item-text="name"
                        color="#7879ff"
                        return-object
                        class="mt-0 pt-0"
                        hide-details
                    ></v-select>
                </v-col>
            </v-row>
            <v-row class="ma-0  hover-cursor-point">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <v-datetime-picker 
                        label="交接时间" 
                        v-model="shiftData.scheduleDate"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                    ></v-datetime-picker>
                </v-col>
            </v-row>
            <v-row class="ma-0  hover-cursor-point" @click="$refs.shiftItemList.focus()">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <v-textarea
                        label="交接物品"
                        v-model="shiftData.itemList"
                        class="mt-0 pt-0"
                        ref="shiftItemList"
                        rows="1"
                        auto-grow
                        clearable
                    ></v-textarea>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
        <div v-if="isPosting == true">
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
                        <h2>{{lang.shiftMng}}</h2>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex align-center justify-end">
                        <v-btn
                            text
                            color="#999999"
                            @click="tempList"
                        >
                            可用模板 {{templateCnt}}， 草稿 {{draftCnt}}
                        </v-btn>
                    
                        <v-btn
                            tile
                            dark
                            color="#F19861"
                            class="mx-2"
                            :loading="isDraft"
                            @click="saveDraft"
                        >
                            {{lang.saveDraft}}
                        </v-btn>
                        <v-btn
                            dark
                            tile
                            color="#7879ff"
                            @click="submit"
                            :loading="isSubmit"
                        >
                            提交
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
            <v-container class="px-10">
                <v-row class="hover-cursor-point d-flex py-3">
                    <v-col cols="6" class="d-flex align-center">
                        姓名
                    </v-col>
                    <v-col cols="6" class="text-right">
                        <v-text-field
                            solo
                            v-model="shiftData.prevName"
                            value="shiftData.prevName"
                            readonly
                            dense
                            hide-details
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-divider light></v-divider>
                <!-- <div class="cus-divider"></div> -->
                <v-row class="hover-cursor-point py-3">
                    <v-col cols="6" class="d-flex align-center">
                        交接人姓名
                    </v-col>
                    <v-col cols="6" class="">
                        <v-select
                            :items="employeeList"
                            v-model="employeeObj"
                            solo
                            dense
                            item-text="name"
                            return-object
                            hide-details
                            class="mt-0 pt-0"
                            :menu-props="{ top: false, offsetY: true }"
                        ></v-select>
                    </v-col>
                </v-row>
                <v-divider light></v-divider>
                <!-- <div class="cus-divider"></div> -->
                <v-row class="hover-cursor-point py-3">
                    <v-col cols="6" class="d-flex align-center">
                        交接时间
                    </v-col>
                    <v-col cols="6">
                        <v-datetime-picker 
                            label="交接时间" 
                            v-model="shiftData.scheduleDate"
                            hide-details
                            dense
                            class="mt-0 pt-0"
                            :okText='lang.ok'
                            :clearText='lang.cancel'
                        ></v-datetime-picker>
                    </v-col>
                </v-row>
                <v-divider light></v-divider>
                <!-- <div class="cus-divider"></div> -->
                <v-row class="hover-cursor-point py-3" @click="$refs.shiftItemList.focus()">
                    <v-col cols="6" class="d-flex align-center">
                        交接物品
                    </v-col>
                    <v-col cols="6">
                        
                        <v-textarea
                            solo
                            v-model="shiftData.itemList"
                            ref="shiftItemList"
                            label="交接物品"
                        ></v-textarea>
                    </v-col>
                </v-row>
            </v-container>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
    </v-container>
</template>

<script>

import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex'
import {getEmployeeList} from '~/api/user'
import {createShiftMng,getTemplateCnt,createTemplate} from '~/api/shiftMng'
import quickMenu from '~/components/quickMenu'
export default {

    components:{
        quickMenu,
    },

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
        isDraft:false,
        templateCnt:0,
        draftCnt:0,
        isPosting:false,

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
        if(this.currentPath.name == 'posts.shift'){
            this.isPosting = true
        }
        getTemplateCnt({schoolId:this.currentPath.params.schoolId}).then(res=>{
            this.draftCnt = res.data.draftCnt
            this.templateCnt = res.data.templateCnt
        })
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
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                this.isSubmit = false
                console.log(err.response)
            })
        },
        tempList(){
            this.isPosting = false
            this.$router.push({name:'shift.templateList'});
        },
        saveDraft(){

        },

        something(){

        },

    }
}
</script>

<style>

</style>