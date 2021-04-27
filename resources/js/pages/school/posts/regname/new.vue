<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/appIcon/基础沟通/报名.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.regname}}</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow">
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        class="mo-glow-v-text mt-0 pt-0"
                        v-model="regNameData.title"
                        label="标题"
                        color="#7879ff"
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
                        class="mo-glow-v-select mt-0 pt-0"
                        color="#7879ff"
                        multiple
                        small-chips
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
                        class="mo-glow-v-select mt-0 pt-0"
                        color="#7879ff"
                        multiple
                        small-chips
                        :menu-props="{ top: false, offsetY: true }"
                        :items="returnSchoolTree(currentPath.params.schoolId)"
                        item-text="lessonName"
                        item-value="lessonId"
                        @change="selectedLesson"
                        label="可见范围"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-between">
                    <span class="mo-glow-inverse">是否需要审核</span>
                    <v-switch
                        v-model="regNameData.checkFlag"
                        color="#7879ff"
                        hide-details
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow mb-16">
            <v-col cols="12">
                <QuestionItem :Label="lang.contentPlaceFirst" :emoji="false" :contact="false"  ref="child" @contentData="loadContentData"></QuestionItem>
            </v-col>
        </v-row>
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
        <quick-menu @clickDraft="something" @clickPublish="submit" :isPublishing="isSubmit"></quick-menu>
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
                    <h2>{{lang.regname}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        text
                        color="#999999"
                        @click="selContent('template')"
                    >
                        可用模板 0， 草稿 0
                    </v-btn>
                    <v-btn
                        dark
                        tile
                        color="#F19861"
                        :loading="isDraft"
                        @click="saveDraft"
                    >
                        {{lang.saveDraft}}
                    </v-btn>
                    <v-btn
                        dark
                        tile
                        color="#7879ff"
                        class="mx-2"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>
                    
                </v-col>
            </v-row>
        </v-container>
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
                        label="报名信息可见"
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
                    <QuestionItem Label="报名内容" :emoji="false" :contact="false"  ref="child" @contentData="loadContentData"></QuestionItem>
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
import quickMenu from '~/components/quickMenu'

export default {
    middleware:['auth','post'],
    components:{
        QuestionItem,
        quickMenu,
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
                value: "name"
            },
            {
                label: "头像",
                value: "avatar"
            },
            {
                label: "性别",
                value: "gender"
            },
            {
                label: "手机号码",
                value: "phoneNumber"
            },
            // {
            //     label: "民族",
            //     value: "nation"
            // },
            {
                label: "出生日期",
                value: "birthday"
            },
            // {
            //     label: "毕业院校",
            //     value: "gradedUniversity"
            // },
            {
                label: "家庭地址",
                value: "familyAddress"
            },
            // {
            //     label: "户籍地址",
            //     value: "livingAddress"
            // },
            {
                label: "身份证号",
                value: "cardNum"
            },
            // {
            //     label: "email",
            //     value: "email"
            // },
            {
                label: "父亲姓名",
                value: "fatherName"
            },
            // {
            //     label: "父亲年龄",
            //     value: "fatherAge"
            // },
            {
                label: "父亲联系方式",
                value: "fatherPhone"
            },
            {
                label: "父亲工作单位",
                value: "fatherJob"
            },
            // {
            //     label: "母亲姓名",
            //     value: "motherName"
            // },
            // {
            //     label: "母亲年龄",
            //     value: "motherAge"
            // },
            // {
            //     label: "母亲备注",
            //     value: "motherMemo"
            // },
            // {
            //     label: "父亲备注",
            //     value: "fatherMemo"
            // },
            // {
            //     label: "母亲联系方式",
            //     value: "motherPhoneNumber"
            // },
            // {
            //     label: "母亲工作单位",
            //     value: "motherJob"
            // },
            // {
            //     label: "家长是否陪同",
            //     value: "parentTogether"
            // },
            // {
            //     label: "来访事由",
            //     value: "reasonOfVisit"
            // },
            // {
            //     label: "户籍所在地",
            //     value: "homeRegPlace"
            // },

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
                return this.$snackbar.showMessage({content: this.lang.requiredText, color: "error"})
            }
            this.isSubmit = true
            await createRegname(this.regNameData).then(res=>{
                console.log(res)
                this.isSubmit = false
                this.isSuccessed = true;
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                //console.log(err.response)
                this.isSubmit = false
            })
        },

        loadContentData(data){
            if(data.text === ''){
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

        something(){

        }
    }
}
</script>

<style>

</style>