<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0 align-center">
            <v-col cols="12">
                <v-datetime-picker 
                    label="最后期限" 
                    v-model="homeworkData.deadline"
                    :okText='lang.ok'
                    :clearText='lang.cancel'
                > </v-datetime-picker>
            </v-col>
            <v-col cols="12">
                <v-select
                    :items="userList"
                    label="课代表"
                    item-text="name"
                    item-value="id"
                    color="#7879ff"
                    class="mt-0 pt-0"
                    v-model="homeworkData.monitorName"
                    :menu-props="{ top: false, offsetY: true }"
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
            <v-col cols="12" class="text-right">
                <v-btn
                    tile
                    color="#feb31a"
                    @click="submit"
                    :loading="isSubmit"
                    dark
                    >
                    确定
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
    <v-container v-else>
        <v-row class="mt-1 align-center">
            <v-col cols="6">
                <p class="">发布时间</p>
            </v-col>
            <v-col cols="6">
                <v-datetime-picker 
                    label="发布时间" 
                    v-model="homeworkData.deadline"
                    :okText='lang.ok'
                    :clearText='lang.cancel'
                > </v-datetime-picker>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="mt-1 align-center">
            <v-col cols="6">
                <p class="">课代表</p>
            </v-col>
            <v-col cols="6">
                <v-select
                    :items="userList"
                    label=""
                    item-text="name"
                    item-value="id"
                    solo
                    v-model="homeworkData.monitorName"
                ></v-select>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="mt-1 ">
            <v-col class="d-flex align-center justify-space-between" cols="12">
                <p class="">家长评价提示</p>
                <v-switch
                    v-model="homeworkData.parentCheck"
                    inset
                ></v-switch>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="mt-1 align-center">
            <v-col cols="12">
                <v-btn
                    depressed
                    color="primary"
                    class="float-right"
                    @click="submit"
                    :loading="isSubmit"
                    >
                    确定
                </v-btn>
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
        menu:false,
        date: new Date().toISOString().substr(0, 10),
        userList:[]
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        getLessonUserList({lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            this.userList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        templateList(){
            
        },
        saveDraft(){

        },
        submit(){
            this.$router.push({name:'posts.Chomework',query:{rule:this.homeworkData}})

        }
    }
}
</script>

<style>

</style>