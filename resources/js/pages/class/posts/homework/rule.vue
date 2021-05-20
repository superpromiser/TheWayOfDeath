<template>
    <v-container v-if="$isMobile()" class="ma-0 pa-0 h-100">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3 pt-12" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.homework}}</p>
                <v-btn @click="submit" :loading="isSubmit" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0 mo-glow bg-white">
                <v-col cols="12" sm="6" md="4">
                    <v-datetime-picker 
                        label="截止时间" 
                        v-model="testTime"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                    > </v-datetime-picker>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        :items="userList"
                        label="课代表"
                        item-text="name"
                        item-value="id"
                        color="#7879ff"
                        class="mt-0 pt-0"
                        v-model="homeworkData.monitorName"
                        :menu-props="{ top: false, offsetY: true }"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" class="d-flex align-center justify-space-between">
                    <p class="mb-0">家长评价提示</p>
                    <v-switch
                        v-model="homeworkData.parentCheck"
                        color="#7879ff"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-switch>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
    <v-container v-else class="pa-0">
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row >
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class="left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.homework}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        depressed
                        color="#7879ff"
                        dark
                        @click="submit"
                        :loading="isSubmit"
                        >
                        确定
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-row class="mt-1 pa-0 align-center mx-7 ma-0">
            <v-col cols="6">
                <p class="mb-0">发布时间</p>
            </v-col>
            <v-col cols="6">
                <v-datetime-picker 
                    label="发布时间" 
                    v-model="testTime"
                    :okText='lang.ok'
                    :clearText='lang.cancel'
                ></v-datetime-picker>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="mt-1 align-center mx-7 ma-0">
            <v-col cols="6">
                <p class="mb-0">课代表</p>
            </v-col>
            <v-col cols="6">
                <v-select
                    :items="userList"
                    label=""
                    item-text="name"
                    item-value="id"
                    solo
                    v-model="homeworkData.monitorName"
                    hide-details
                    :loading="isLoading"
                    :menu-props="{ top: false, offsetY: true }"
                ></v-select>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="mt-1 mx-7 ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12">
                <p class="mb-0">家长评价提示</p>
                <v-switch
                    v-model="homeworkData.parentCheck"
                    inset
                    class="mt-0 pt-0"
                ></v-switch>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {getLessonUserList} from '~/api/user'
export default {
    data:()=>({
        lang,
        isSubmit:false,
        isDraft:false,
        tempCnt:0,
        draftCnt:0,
        baseUrl:window.Laravel.base_url,
        homeworkData:{
            deadline:'',
            monitorName:'',
            parentCheck:false
        },
        testTime:'',
        menu:false,
        date: new Date().toISOString().substr(0, 10),
        userList:[],
        isLoading: false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        this.isLoading = true;
        await getLessonUserList({lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            this.userList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
        this.isLoading = false;
    },
    methods:{
        templateList(){
            
        },
        saveDraft(){

        },
        submit(){
            // console.log(new Date(this.homeworkData.deadline))
            // this.homeworkData.deadline = new Date(this.homeworkData.deadline)
            // if(typeof this.homeworkData.deadline == 'object'){
            //     console.log(typeof this.homeworkData.deadline)
            //     return this.$snackbar.showMessage({content: "确定日期", color: "error"})
            // }
            // console.log('rule',this.homeworkData)
            if(this.homeworkData.monitorName == ''){
                return this.$snackbar.showMessage({content: this.lang.homework+this.lang.requireMonitorName, color: "error"});
            }
            if(this.testTime == ''){
                return this.$snackbar.showMessage({content: this.lang.homework+this.lang.requireDeadline, color: "error"});
            }
            console.log(this.testTime.toString())
            this.homeworkData.deadline = this.testTime.toString()
            console.log(this.homeworkData)
            this.$router.push({name:'posts.Chomework',query:{rule:this.homeworkData}})

        }
    }
}
</script>

<style>

</style>