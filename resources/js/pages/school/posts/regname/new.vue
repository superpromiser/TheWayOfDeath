<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.regname}}</h2>
            </div>
            <template v-slot:actions>
                <v-btn
                    text
                    color="primary"
                    @click="selContent('template')"
                >
                    可用模板 0， 草稿 0
                </v-btn>
                <v-btn
                    dark
                    tile
                    color="green lighten-1"
                    class="mx-2"
                    :loading="isSubmit"
                    @click="submit"
                >
                    {{lang.submit}}
                </v-btn>
                <v-btn
                    dark
                    tile
                    color="purple accent-4"
                    class="mr-8"
                    :loading="isDraft"
                    @click="saveDraft"
                >
                    {{lang.saveDraft}}
                </v-btn>
            </template>
        </v-banner>
        <v-container class="pa-10">
            <v-row class="align-start">
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="regNameData.title"
                        label="标题"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-datetime-picker 
                        label="开始时间" 
                        v-model="regNameData.startTime"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                    > </v-datetime-picker>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-datetime-picker 
                        label="截止时间" 
                        v-model="regNameData.endTime"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                    > </v-datetime-picker>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        multiple
                        chips
                        :menu-props="{ top: false, offsetY: true }"
                        :items="inputTypeItem"
                        item-text="label"
                        item-value="value"
                        @change="selectedInputType"
                        label="可见范围"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        multiple
                        chips
                        :menu-props="{ top: false, offsetY: true }"
                        :items="returnSchoolTree(currentPath.params.schoolId)"
                        item-text="lessonName"
                        item-value="lessonId"
                        @change="selectedLesson"
                        label="可见范围"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around py-6">
                    <span>是否需要审核</span>
                    <v-switch
                        v-model="regNameData.checkFlag"
                        color="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <QuestionItem :Label="lang.contentPlaceFirst" :emoji="false" :contact="false"  ref="child" @contentData="loadContentData"></QuestionItem>
                </v-col>
            </v-row>
        </v-container>
        <v-snackbar
            timeout="3000"
            v-model="requiredText"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
        <v-snackbar
        timeout="3000"
            v-model="isSuccessed"
            color="success"
            absolute
            top
            >
            {{lang.successText}}
        </v-snackbar>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {createRegname} from '~/api/regname'
export default {
    components:{
        QuestionItem,
    },

    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        isSubmit:false,
        isDraft:false,
        requiredText:false,
        regNameData:{
            schoolId:null,
            content:[],
            viewList: [],
            inputTypeList: [],
            startTime: null,
            endTime: null,
            checkFlag: false
        },
        isSuccessed: false,
        inputTypeItem:[
            {
                label: "姓名",
                value: "姓名"
            },
            {
                label: "头像",
                value: "头像"
            },
            {
                label: "性别",
                value: "性别"
            },
            {
                label: "手机号码",
                value: "手机号码"
            },
            {
                label: "民族",
                value: "民族"
            },
            {
                label: "出生日期",
                value: "出生日期"
            },
            {
                label: "毕业院校",
                value: "毕业院校"
            },
            {
                label: "家庭地址",
                value: "家庭地址"
            },
            {
                label: "户籍地址",
                value: "户籍地址"
            },
            {
                label: "身份证号",
                value: "身份证号"
            },
            {
                label: "email",
                value: "email"
            },
            {
                label: "父亲姓名",
                value: "父亲姓名"
            },
            {
                label: "父亲年龄",
                value: "父亲年龄"
            },
            {
                label: "父亲联系方式",
                value: "父亲联系方式"
            },
            {
                label: "父亲工作单位",
                value: "父亲工作单位"
            },
            {
                label: "母亲姓名",
                value: "母亲姓名"
            },
            {
                label: "母亲年龄",
                value: "母亲年龄"
            },
            {
                label: "母亲备注",
                value: "母亲备注"
            },
            {
                label: "父亲备注",
                value: "父亲备注"
            },
            {
                label: "母亲联系方式",
                value: "母亲联系方式"
            },
            {
                label: "母亲工作单位",
                value: "母亲工作单位"
            },
            {
                label: "家长是否陪同",
                value: "家长是否陪同"
            },
            {
                label: "来访事由",
                value: "来访事由"
            },
            {
                label: "户籍所在地",
                value: "户籍所在地"
            },

        ]
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        this.regNameData.schoolId = this.currentPath.params.schoolId
    },
    methods:{
        saveDraft(){

        },

        async submit(){
            this.$refs.child.emitData()
            if(this.regNameData.content.length == 0){
                return
            }
            this.isSubmit = true
            await createRegname(this.regNameData).then(res=>{
                console.log(res)
                this.isSubmit = false
                this.isSuccessed = true;
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                //console.log(err.response)
                this.isSubmit = false
            })
        },

        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true;
                this.regNameData.content = [];
                return;
            }
            this.regNameData.content.push(data)
        },

        selectedLesson(val){
            this.regNameData.viewList = val;
        },

        selectedInputType(val){
            this.regNameData.inputTypeList = val;
        },
    }
}
</script>

<style>

</style>