<template>
    <v-container>
        <v-row class="justify-center align-center z-index-2 banner-custom position-relative">
            <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
                mdi-chevron-left
            </v-icon>
            <h2 class="py-7">{{lang.regname}}</h2>
        </v-row>
        <v-row class="pl-10 pt-0">
            <v-col cols="12" class="text-center">
                <h1>{{regNameData.title}}</h1>
            </v-col>
            <v-col cols="12" >
                <p class="text-wrap">{{regNameData.content[0].text}}</p>
            </v-col>
            <v-col cols="12" v-if="checkIfAttachExist(regNameData.content[0])">
                <AttachItemViewer :items="regNameData.content[0]" />
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row class="ma-0 pt-10">
            <v-col cols="12" class="text-center">
                <h2>- 报名 -</h2>
            </v-col>
            <v-col cols="12" sm="6" md="4" v-for="(item, i) in regNameData.inputTypeList" :key="i">
                <p>{{item}}:{{user[item]}}</p>
            </v-col>
            <v-col cols="12" class="text-right">
                <v-btn @click="submit" color="primary" tile :loading="isAnswering" :disabled="isAlreadyAnswer">
                    {{lang.submit}}
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
import {answerRegname, getAnswerDataOne, updateAnswerRegname} from '~/api/regname'
import AttachItemViewer from '~/components/attachItemViewer';

export default {
    components:{
        AttachItemViewer,
    },

    data: ()=> ({
        lang,
        regNameData: null,
        baseUrl:window.Laravel.base_url,
        regAnswerData: {},
        isAnswering: false,
        myAnswerData: null,
        isAlreadyAnswer: false,
        updateAnswerData: {},
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
            {
                label: "民族",
                value: "nation"
            },
            {
                label: "出生日期",
                value: "birthday"
            },
            {
                label: "毕业院校",
                value: "gradedUniversity"
            },
            {
                label: "家庭地址",
                value: "homeAddress"
            },
            {
                label: "户籍地址",
                value: "livingAddress"
            },
            {
                label: "身份证号",
                value: "cardNum"
            },
            {
                label: "email",
                value: "email"
            },
            {
                label: "父亲姓名",
                value: "fatherName"
            },
            {
                label: "父亲年龄",
                value: "fatherAge"
            },
            {
                label: "父亲联系方式",
                value: "fatherPhoneNumber"
            },
            {
                label: "父亲工作单位",
                value: "fatherJob"
            },
            {
                label: "母亲姓名",
                value: "motherName"
            },
            {
                label: "母亲年龄",
                value: "motherAge"
            },
            {
                label: "母亲备注",
                value: "motherMemo"
            },
            {
                label: "父亲备注",
                value: "fatherMemo"
            },
            {
                label: "母亲联系方式",
                value: "motherPhoneNumber"
            },
            {
                label: "母亲工作单位",
                value: "motherJob"
            },
            {
                label: "家长是否陪同",
                value: "parentTogether"
            },
            {
                label: "来访事由",
                value: "reasonOfVisit"
            },
            {
                label: "户籍所在地",
                value: "homeRegPlace"
            },

        ],
        isLoadingContents:false,
        attrs: {
          class: 'mb-6',
        },
    }),

    computed:{
        ...mapGetters({
            contentData: 'content/postDetail',
            user: 'auth/user'
        })
    },

    async created(){
        if(this.contentData == null){
            this.$router.push({name: 'schoolSpace.news'});
        }
        else{
            console.log("^^^", this.contentData);
            this.regNameData = this.contentData.regnames;
            this.regNameData.content = JSON.parse(this.regNameData.content);
            this.regNameData.inputTypeList = JSON.parse(this.regNameData.inputTypeList);
            this.regNameData.viewList = JSON.parse(this.regNameData.viewList);
            console.log("this.regNameData.inputTypeList",this.regNameData.inputTypeList)
            console.log("this.user",this.user)
            this.regNameData.inputTypeList.map(item=>{
                this.regAnswerData[item] = this.user[item]
                // let obj = {}
                // obj[item] = this.user[item]
                // this.regAnswerData.push(this.user[item])
            })
            
            let params = {
                userId: this.user.id,
                postId: this.regNameData.postId
            }
            // this.isLoadingContents = true
            await getAnswerDataOne(params)
            .then((res) => {
                console.log(res.data)
                if(res.data.answer != null){
                    this.isAlreadyAnswer = true
                }
                this.isLoadingContents = false
            }).catch((err) => {
                console.log(err);
                this.isLoadingContents = false
            });
            
            // console.log("###",this.regNameData, this.regAnswerData);
        }
    },

    methods:{
        async submit(){
            console.log(this.regAnswerData);
            // return
            let payload = {
                postId: this.regNameData.postId,
                regnameId: this.regNameData.id,
                answer: this.regAnswerData
            }
            this.isAnswering = true;
            await answerRegname(payload)
            .then((res) => {
                console.log(res);
                this.$router.push({name: 'schoolSpace.news'});
            }).catch((err) => {
                console.log(err);
            });
            this.isAnswering = false;
        },

        convertLabel(item){
            let label = ""
            for(let i = 0; i < this.inputTypeItem.length; i++){
                if(this.inputTypeItem[i].value === item){
                    label = this.inputTypeItem[i].label;
                    break;
                }
            }
            return label;
        },
        async update(){
            console.log(this.updateAnswerData)
            let payload = {
                id: this.myAnswerData.id,
                answer: this.updateAnswerData
            }
            this.isAnswering = true;
            await updateAnswerRegname(payload)
            .then((res) => {
                console.log(res);
                this.isAnswering = false;
                this.$router.push({name: 'schoolSpace.news'});
            }).catch((err) => {
                console.log(err);
                this.isAnswering = false;
            });
            
        }
    }
}
</script>

<style>

</style>