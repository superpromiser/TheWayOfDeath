<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()" >
        <v-container class="pt-0 px-0 h-100 bg-white pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.regname}}</p>
                <v-progress-circular v-if="isLoadingContents" indeterminate color="#7879ff" size="25" class="position-absolute put-align-center mr-3" style="right: 0px; top:50%"></v-progress-circular>
                <v-chip v-else-if="isAlreadyAnswer && (answerData.status == 'allow')" color="#49d29e"  label text-color="white" class="position-absolute put-align-center mr-3" style="right: 0px; top:50%">
                    <v-icon left> mdi-hand   </v-icon> 允许
                </v-chip>
                <v-chip v-else-if="isAlreadyAnswer && (answerData.status == 'pending')" color="#feb31a"  label text-color="white" class="position-absolute put-align-center mr-3" style="right: 0px; top:50%">
                    <v-icon left> mdi-clock-outline   </v-icon> 待办的
                </v-chip>
                <v-chip v-else-if="isAlreadyAnswer && (answerData.status == 'deny')" color="#eb5846"  label text-color="white" class="position-absolute put-align-center mr-3" style="right: 0px; top:50%">
                    <v-icon left> mdi-cancel </v-icon> 否定
                </v-chip>
                <v-btn v-else-if="!isAlreadyAnswer" @click="submit" :loading="isAnswering" text :disabled="isAlreadyAnswer" color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    报名
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>

            <v-row class="ma-0 pt-0">
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
                    <p class="mb-0 d-flex align-start" v-if="inputTypeItem[item] == '头像'"> <strong>{{inputTypeItem[item]}}</strong> : 
                        <v-avatar v-if="user[item] == '/'" color="#7879ff" size="60" class="ma-5">
                            <span class="white--text headline">{{user.name[0]}}</span>
                        </v-avatar>
                        <v-avatar v-else
                            class="ml-3"
                            size="45"
                            >
                            <v-img :src="user[item]"></v-img>
                        </v-avatar>
                    </p>
                    <p class="mb-0" v-else> <strong>{{inputTypeItem[item]}}</strong> :{{convertItem(user[item], inputTypeItem[item])}}</p>
                </v-col>
            </v-row>
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
                    <h2>{{lang.regname}}</h2>
                </v-col>
                <v-col v-if="isLoadingContents" cols="12" md="4" class="d-flex align-center justify-end">
                    <v-progress-circular v-if="isLoadingContents" indeterminate color="#7879ff" size="30" ></v-progress-circular>
                </v-col>
                <v-col v-else-if="isAlreadyAnswer" cols="12" md="4" class="d-flex align-center justify-end">
                    <v-chip v-if="answerData.status == 'allow'" color="#49d29e"  label text-color="white" >
                        <v-icon left> mdi-hand   </v-icon> 允许
                    </v-chip>
                    <v-chip v-else-if="answerData.status == 'pending'" color="#feb31a"  label text-color="white" >
                        <v-icon left> mdi-clock-outline   </v-icon> 待办的
                    </v-chip>
                    <v-chip v-else-if="answerData.status == 'deny'" color="#eb5846"  label text-color="white" >
                        <v-icon left> mdi-cancel </v-icon> 否定
                    </v-chip>
                </v-col>
                <v-col v-else cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn @click="submit" color="#7879ff" :dark="!isAnswering" tile :loading="isAnswering">
                        报名
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <div v-if="isLoadingContents == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="#7879ff"
            ></v-progress-circular>
        </div>
        <div v-else>
            <v-col cols="12" class="d-flex align-center hover-cursor-point">
                <v-avatar v-if="contentData.users.name !== '' && contentData.users.avatar == '/'" color="#7879ff" size="60" class="ma-5">
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
                    <v-icon medium color="#7879ff" class="mr-2">mdi-clock-outline </v-icon>
                    <p class="mb-0 mr-8">{{TimeView(contentData.created_at)}}</p>
                    <v-icon medium color="#7879ff" class="mr-2">mdi-account </v-icon>
                    <p class="mb-0">{{contentData.users.name}}</p>
                    </div>
                </div>
                <div class="ml-auto mr-5">
                    <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                        <v-btn icon color="#7879ff" v-bind="attrs" v-on="on" >
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
            <v-row class="px-10 pt-0 ma-0">
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
                    <p class="mb-0 d-flex align-start" v-if="inputTypeItem[item] == '头像'"> <strong>{{inputTypeItem[item]}}</strong> : 
                        <v-avatar v-if="user[item] == '/'" color="#7879ff" size="60" class="ma-5">
                            <span class="white--text headline">{{user.name[0]}}</span>
                        </v-avatar>
                        <v-avatar v-else
                            class="ml-3"
                            size="60"
                            >
                            <v-img :src="user[item]"></v-img>
                        </v-avatar>
                    </p>
                    <p class="mb-0" v-else> <strong>{{inputTypeItem[item]}}</strong> :{{convertItem(user[item], inputTypeItem[item])}}</p>
                </v-col>
                
            </v-row>
            <FooterPost :footerInfo='contentData' @updateFooterInfo='updateFooterInfo'></FooterPost>
            <CommentView></CommentView>
        </div>
    </v-container>
</template>

<script>
import cityListJson from '!!raw-loader!../../cityLaw.txt';
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
        provinceListJsonArr:[],
        madeJsonFromString : [],
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
        answerData: null,
    }),

    computed:{
        ...mapGetters({
            contentData: 'content/postDetail',
            user: 'auth/user'
        })
    },

    async created(){
        this.provinceListJsonArr = cityListJson.split("#");
        for (let i = 0; i < this.provinceListJsonArr.length; i++) {
          let provinceObj = {
              value : 1,
              label : "",
              city : []
          }
          let province = this.provinceListJsonArr[i].split("$")[0];
          provinceObj.value = province.split("-")[0];
          provinceObj.label = province.split("-")[1];
          this.madeJsonFromString.push(provinceObj);
          let TArea = this.provinceListJsonArr[i].split("$")[1].split("|");
          for(let j = 0 ; j < TArea.length ; j++){
              let cityObj = {
                  value : 1,
                  label : "",
                  region : []
              }
              let cityArr = TArea[j].split(",");
              cityObj.value = cityArr[0].split("-")[0];
              cityObj.label = cityArr[0].split("-")[1];
              for( let k = 1 ; k < cityArr.length ; k++){
                  let regionObj = {
                      value : 1, 
                      label : "",
                  }
                  regionObj.value = cityArr[k].split("-")[0];
                  regionObj.label = cityArr[k].split("-")[1];
                  cityObj.region.push(regionObj);
              }
              this.madeJsonFromString[i].city.push(cityObj);
          }
      }
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
                    this.answerData = res.data.answer;
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
                if(this.$isMobile()){
                    this.$router.push({name: 'home'});
                }   
                else{
                    this.$router.push({name: 'schoolSpace.news'});
                }
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
        },

        convertItem(item, itemType){
            switch (itemType) {
                case '姓名': //name
                    return item;
                case '头像': //avatar
                    return item;
                case '性别': //gender
                    return this.transGender(item);
                case '手机号码': //phoneNumber
                    return item;
                case '出生日期': //dob
                    return this.TimeViewYMD(item);
                case '家庭地址': //address
                    return this.convertAddress(item);
                case '身份证号': //cardNum
                    return item;
                case '父亲姓名': //fatherName
                    return item;
                case '父亲工作单位': //fatherJob
                    return item;
                case '父亲联系方式': //fatherPhoneNumber
                    return item;
                
                default:
                    break;
            }
        },

        convertAddress(address){
            address = JSON.parse(address);
            let province = '';
            let city = '';
            let region = '';
            for(let i = 0 ; i < this.madeJsonFromString.length ; i++){
            if( address.province == this.madeJsonFromString[i].value ){
                province = this.madeJsonFromString[i].label;
                for(let j = 0 ; j < this.madeJsonFromString[i].city.length ; j++){
                if( address.city == this.madeJsonFromString[i].city[j].value ){
                    city = this.madeJsonFromString[i].city[j].label;
                    for(let k = 0 ; k < this.madeJsonFromString[i].city[j].region.length ; k++){
                    if( address.region == this.madeJsonFromString[i].city[j].region[k].value ){
                        region = this.madeJsonFromString[i].city[j].region[k].label;
                    }
                    }
                }
                }
            }
            }
            return province + ' ' + city + ' ' + region + ' ' + address.detail;
        },
    }
}
</script>

<style>

</style>