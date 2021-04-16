<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="" >
                    <v-img :src="`${baseUrl}/asset/img/appIcon/校园安全/交接班.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.shiftMng}}</h2>
            </v-col>
        </v-row>
        <v-container class="pa-0">
            <v-row class="ma-0 hover-cursor-point">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <v-text-field
                        color="#7879ff"
                        v-model="shiftData.prevName"
                        readonly
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
            <quick-menu @clickDraft="something" @clickPublish="submit" :isPublishing="isSubmit"></quick-menu>
        </v-container>
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
                    <h2>{{lang.shiftMng}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        text
                        color="primary"
                        @click="tempList"
                    >
                        可用模板 0， 草稿 0
                    </v-btn>
                    <v-btn
                        dark
                        tile
                        color="#49d29e"
                        @click="submit"
                        :loading="isSubmit"
                        class="mx-2"
                    >
                        提交
                    </v-btn>
                    <v-btn
                        tile
                        dark
                        color="#F19861"
                        :loading="isDraft"
                        @click="draft"
                    >
                        {{lang.saveDraft}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-container class="pa-10">
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
                        :menu-props="{ top: false, offsetY: true }"
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
        tempList(){

        },
        draft(){

        },

        something(){

        },

    }
}
</script>

<style>

</style>