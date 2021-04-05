<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/icon/家访 拷贝.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.homeVisit}}</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow mt-5">
            <v-col cols="12" sm="6" md="4">
                <v-select
                    class="mo-glow-v-select"
                    solo
                    multiple
                    small-chips
                    :items="userInfoItem"
                    :menu-props="{ top: false, offsetY: true }"
                    item-text="name"
                    item-value="name"
                    @change="selectedLesson"
                    label="班级"
                    hide-details
                    v-model="visitData.userInfo"
                ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="4" class="d-flex justify-space-between align-center">
                <v-datetime-picker 
                    label="开始时间" 
                    v-model="visitData.deadline"
                    :okText='lang.ok'
                    :clearText='lang.cancel'
                > </v-datetime-picker>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-btn block large class="mo-glow" @click="openDetailDialog" style="height:48px!important;">
                    <v-icon>
                        mdi-eye
                    </v-icon>家访内容
                </v-btn>
            </v-col>
            <v-col cols="12">
                <QuestionItem :Label="lang.contentPlace" :emoji="true" :contact="true"  ref="child" @contentData="loadContentData"></QuestionItem>
            </v-col>
        </v-row>
        <v-dialog v-model="detailDialog" max-width="900px" style="background:white!important">
            <v-container class="pa-0">
                <v-card>
                    <v-card-title class="headline grey lighten-2">
                        上门拜访详情
                    </v-card-title>
                
                    <v-row class="ma-0" v-for="(item, i) in visitData.description" :key="i">
                        <v-col class="px-5 " cols="12" v-for="(data, j) in item" :key="j">
                            <p :class="{textMain: j==0}">{{data.title}}</p>
                        </v-col>
                    </v-row>
                </v-card>
            </v-container>            
        </v-dialog>
        <v-snackbar
            timeout="3000"
            v-model="requiredText"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
        <quick-menu @clickDraft="something" @clickPublish="publishcampusData" :isPublishing="isCreating"></quick-menu>
    </v-container>
    <v-container class="pa-0" v-else>
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <v-avatar
                    class="ma-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/家访 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.homeVisit}}</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                text
                color="primary"
            >
                可用模板 0， 草稿 0
            </v-btn>
            <v-btn
                dark
                color="green lighten-1"
                :loading="isCreating"
                @click="publishcampusData"
                tile
                class="mr-md-8"
            >
                提交
            </v-btn>
            </template>
        </v-banner>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        multiple
                        chips
                        :items="userInfoItem"
                        :menu-props="{ top: false, offsetY: true }"
                        item-text="name"
                        item-value="name"
                        @change="selectedLesson"
                        label="班级"
                        hide-details
                        v-model="visitData.userInfo"
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4" class="d-flex justify-space-between align-center">
                    <v-datetime-picker 
                        label="开始时间" 
                        v-model="visitData.deadline"
                        :okText='lang.ok'
                        :clearText='lang.cancel'
                    > </v-datetime-picker>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block large color="transparent" @click="openDetailDialog" style="height:48px!important;">
                        <v-icon>
                            mdi-eye
                        </v-icon>家访内容
                    </v-btn>
                </v-col>
                <v-col cols="12">
                    <QuestionItem :Label="lang.contentPlace" :emoji="true" :contact="true"  ref="child" @contentData="loadContentData"></QuestionItem>
                </v-col>
            </v-row>
            
        </v-container>
        <v-dialog v-model="detailDialog" max-width="900px" style="background:white!important">
            <v-container class="pa-0">
                <v-card>
                    <v-card-title class="headline grey lighten-2">
                        上门拜访详情
                    </v-card-title>
                
                    <v-row class="ma-0" v-for="(item, i) in visitData.description" :key="i">
                        <v-col class="px-5 " cols="12" v-for="(data, j) in item" :key="j">
                            <p :class="{textMain: j==0}">{{data.title}}</p>
                        </v-col>
                    </v-row>
                </v-card>
            </v-container>            
        </v-dialog>
        <v-snackbar
            timeout="3000"
            v-model="requiredText"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import QuestionItem from '~/components/questionItem'
import UploadImage from '~/components/UploadImage'
import lang from '~/helper/lang.json'
import { VueEditor } from "vue2-editor";
import Fragment from 'vue-fragment';
import quickMenu from '~/components/quickMenu'

import {createHomeVisit} from '~/api/homeVisit'
import {getSchoolMemberList} from '~/api/user'
export default {
    components: {
        VueEditor,
        QuestionItem,
        UploadImage,
        Fragment,
        quickMenu
    },

    data: () => ({
        lang,
        menu: false,
        requiredText:false,
        baseUrl: window.Laravel.base_url,
        detailDialog: false,
        userInfoItem : [
        ],
        visitData:{
            userInfo:null,
            deadline:'',
            type:'15题',
            description:[
            [
                {
                    title:"孩子的家庭成员有哪些？（多选题）",
                    type:"multi"
                },
                {title:"妈妈"},
                {title:"外公外婆"},
                {title:"爷爷奶奶"},
                {title:"爸爸"}
            ],
            [
                {
                    title:"孩子是否住宿（单选题）",
                    type:"single"
                },
                {title:"否"},
                {title:"是"},
            ],
            [
                {title:"您的孩子中午是否在校休息（单选题）",type:"single"},
                {title:"是"},
                {title:"否"},
            ],
            [
                {title:"您重视对孩子哪方面能力的培养？ （多选题）",type:"multi"},
                {title:"个人卫生"},
                {title:"语言能力"},
                {title:"思维能力"},
                {title:"文明礼貌"},
                {title:"学习能力"},
                {title:"自主劳动"}
            ],
            [
                {title:"孩子比较擅长哪方面的能力？（多选题）",type:"multi"},
                {title:"文明礼貌"},
                {title:"学习能力"},
                {title:"自主劳动"},
                {title:"个人卫生"},
                {title:"语言能力"},
                {title:"思维能力"}
            ],
            [
                {title:"您家里适合孩子阅读的课外书数量？（单选题）",type:"single"},
                {title:"文明礼貌"},
                {title:"学习能力"},
                {title:"自主劳动"},
            ],
            [
                {title:"孩子的学习环境如何？（单选题）",type:"single"},
                {title:"有独立的房间"},
                {title:"与兄弟姐妹共用房间"},
                {title:"无独立房间"},
            ],
            [
                {title:"家里的卫生情况如何（单选题）",type:"single"},
                {title:"很干净"},
                {title:"一般"},
                {title:"不干净"},
            ],
            [
                {title:"孩子和家庭成员的关系？",type:"single"},
                {title:"操作成功"},
                {title:"一般"},
                {title:"差"},
            ],
            [
                {title:"当您发现孩子成绩下降后，您的常用做法是？（单选题）",type:"single"},
                {title:"帮助分析原因，制定措施"},
                {title:"口头训斥"},
                {title:"打骂"},
                {title:"老师教育方法不对"},
                {title:"成绩不代表什么，身体健康就操作成功"},
            ],
            [
                {title:"间隔多长时间主动与老师联系一次？（单选题）",type:"single"},
                {title:"一个月"},
                {title:"一周"},
                {title:"每天"},
                {title:"从来没有"},
                {title:"一学期"},
            ],
            [
                {title:"您孩子定期帮助家人做家务吗？（单选题）",type:"single"},
                {title:"经常有"},
                {title:"偶尔有"},
                {title:"从来没有"},
            ],
            [
                {title:"孩子对课外阅读的兴趣如何？（单选题）",type:"single"},
                {title:"很喜欢书，涉猎广泛，懂得很多课外知识"},
                {title:"喜欢看书，但范围较窄"},
                {title:"比较喜欢"},
                {title:"很少看书"},
                {title:"完全不看书"},
            ],
            [
                {title:"孩子经常有朋友到家里来玩吗？（单选题）",type:"single"},
                {title:"他有很操作成功的朋友，经常来家里"},
                {title:"几乎没有朋友，也从不邀请到家"},
                {title:"有一些朋友，但不常到家"},
                {title:"有自己的朋友，但我不喜欢他带朋友到家里"},
            ],
            [
                {title:"孩子为人处世的态度，您觉得比较符合下列哪一条？（单选题）",type:"single"},
                {title:"态度粗暴，比较自我，不容易被人接受"},
                {title:"态度蛮横，性情暴躁，容易与人发生矛盾"},
                {title:"态度冷淡，与世无争，性格较孤僻"},
                {title:"态度友善，情感真诚，容易被人喜爱"},
                {title:"态度畏缩，容易跟随，缺乏自我和自信"},
            ]
            
            ],
            content: null,
            schoolId:null,
            // viewList:[],
            // postShow:[], 
        },
        isCreating:false
    }),

    computed: {
       currentPath(){
           return this.$route
       }
    },

    created() {
        this.visitData.schoolId = this.currentPath.params.schoolId
        getSchoolMemberList({roleId:5,schoolId:this.currentPath.params.schoolId}).then(res=>{
            // console.log(res.data)
            this.userInfoItem = res.data
            console.log(this.userInfoItem)
        }).catch(err=>{
            console.log(err.response)
        })
    },

    methods: {
        selectedLesson(val){
            //console.log(val)
        },  
        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true;
                this.visitData.content = null;
                return;
            }
            this.visitData.content = data;
        },

        upImgUrl(value) {
            this.visitData.imgUrl = value;
            //console.log(this.visitData.imgUrl);
        },
        clearedImg(){
            this.visitData.imgUrl = ''
            //console.log(this.visitData.imgUrl);
        },

        async publishcampusData(){
            this.$refs.child.emitData()
            if(this.visitData.content == null){
                return
            }
            this.isCreating = true
            //console.log("this.visitData", this.visitData);
            await createHomeVisit(this.visitData).then(res=>{
                this.isCreating = false;
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                //console.log(err.response)
                this.isCreating = false;
            })


        },

        openDetailDialog(){
            this.detailDialog = true;
            //console.log("something");
        },

        something(){

        }
    }
}
</script>

<style>

</style>