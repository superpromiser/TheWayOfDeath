<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()" >
        <v-container class="pt-0 px-0 h-100 bg-white pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.regname}}</p>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>

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
    </v-container>
    <v-container v-else>
        <v-row class="justify-center align-center z-index-2 banner-custom">
            <v-icon size="70" @click="$router.go(-1)" class="position-absolute put-align-center" style="top:50%; left:20px">
                mdi-chevron-left
            </v-icon>
            <h2 class="py-7">{{lang.regname}}</h2>
        </v-row>
        <div v-if="isLoadingContents == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="primary"
            ></v-progress-circular>
        </div>
        <div v-else>
            <v-col cols="12" class="d-flex align-center hover-cursor-point">
                <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="primary" size="60" class="ma-5">
                    <span class="white--text headline">{{contentData.users.name[0]}}</span>
                </v-avatar>
                <v-avatar v-else
                    class="ma-5"
                    size="60"
                >
                    <v-img :src="contentData.users.avatar"></v-img>
                </v-avatar>
                <div>
                    <p class="font-weight-black fs-15 mb-3"> {{lang.regname}}  </p>
                    <div class="d-flex align-center">
                    <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                    <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
                    <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                    <p class="mb-0">{{contentData.users.name}}</p>
                    </div>
                </div>
                <div class="ml-auto mr-5">
                    <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                        <v-btn icon color="primary" v-bind="attrs" v-on="on" >
                        <v-icon size="30">mdi-chevron-down </v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item link >
                        <v-list-item-title class="px-2" @click="fixTop(contentData)" v-if="contentData.fixTop == null">{{lang.toTop}}</v-list-item-title>
                        <v-list-item-title class="px-2" @click="relaseTop(contentData.id)" v-else>{{lang.toRelase}}</v-list-item-title>
                        </v-list-item>
                        <v-list-item link >
                        <v-list-item-title class="px-2" @click="postRemove(contentData)">{{lang.remove}}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                    </v-menu>
                </div>
            </v-col>
            <v-row class="px-10 pt-0">
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
            <div class="mt-3 px-10">
                <v-divider light></v-divider>
            </div>
            <v-row class="ma-0 pt-10 px-10">
                <v-col cols="12" class="text-center">
                    <h2>- 报名 -</h2>
                </v-col>
                <v-col cols="12" sm="6" md="4" v-for="(item, i) in regNameData.inputTypeList" :key="i">
                    <p>{{inputTypeItem[item]}}:{{user[item]}}</p>
                </v-col>
                <v-col cols="12" class="text-right">
                    <v-btn @click="submit" color="#7879ff" dark tile :loading="isAnswering" :disabled="isAlreadyAnswer">
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
            <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
            <CommentView></CommentView>
        </div>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
import {answerRegname, getAnswerDataOne, updateAnswerRegname} from '~/api/regname'
import AttachItemViewer from '~/components/attachItemViewer';
import FooterPost from '~/components/contents/footerPost'
import CommentView from '~/pages/school/posts/comments/commentView';
export default {
    components:{
        AttachItemViewer,
        FooterPost,
        CommentView
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
        inputTypeItem:{
            name:"姓名",
            avatar:"头像",
            gender:"性别",
            phoneNumber:"手机号码",
            nation:"民族",
            birthday:"出生日期",
            familyAddress:"家庭地址",
            cardNum:"身份证号",
            fatherName:"父亲姓名",
            fatherPhone:"父亲联系方式",
            fatherJob:"父亲工作单位"
        },
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
            this.isLoadingContents = true
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
            
        },
        updateFooterInfo(){
            console.log('test')
        }
    }
}
</script>

<style>

</style>