<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/家访 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.homeVist}}</h2>
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
                        :items="userInfoItem"
                        :menu-props="{ top: false, offsetY: true }"
                        item-text="label"
                        item-value="value"
                        v-model="visitData.camposeCategory"
                        label="栏目"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="visitData.title"
                        label="标题"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <UploadImage @upImgUrl="upImgUrl" @clearedImg="clearedImg" :solo="true" uploadLabel="模板封面" />
                </v-col>
                <v-col cols="12">
                    <vue-editor v-model="visitData.content" placeholder="公告内容"></vue-editor>
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
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import QuestionItem from '~/components/questionItem'
import UploadImage from '~/components/UploadImage'
import lang from '~/helper/lang.json'
import { VueEditor } from "vue2-editor";


import {createCampus} from '~/api/campus'

export default {
    components: {
        VueEditor,
        QuestionItem,
        UploadImage,
    },

    data: () => ({
        lang,
        menu: false,
        requiredText:false,
        baseUrl: window.Laravel.base_url,
        userInfoItem : [
            { 
                label : "sammie", 
                value : 1 
            },
            { 
                label : "tommy", 
                value : 2 
            },
            { 
                label : "hommey", 
                value : 3 
            },
            { 
                label : "gammy", 
                value : 4 
            },
            { 
                label : "bammy", 
                value : 5
            },
            { 
                label : "gymmie", 
                value : 6
            },
            { 
                label : "Qummie", 
                value : 7
            },
            
        ],
        visitData:{
            userInfo:null,
            deadline:'',
            type:'15题',
            description:[
            [
                {
                    title:"孩子的家庭成员有哪些？（多选题）",
                    type:"多选题"
                },
                {title:"妈妈"},
                {title:"外公外婆"},
                {title:"爷爷奶奶"},
                {title:"爸爸"}
            ],
            [
                {
                    title:"孩子是否住宿（单选题）",
                    type:"单选题"
                },
                {title:"否"},
                {title:"是"},
            ],
            [
                {title:"您的孩子中午是否在校休息（单选题）",type:"单选题"},
                {title:"是"},
                {title:"否"},
            ],
            [
                {title:"您重视对孩子哪方面能力的培养？ （多选题）",type:"多选题"},
                {title:"个人卫生"},
                {title:"语言能力"},
                {title:"思维能力"},
                {title:"文明礼貌"},
                {title:"学习能力"},
                {title:"自主劳动"}
            ],
            [
                {title:"孩子比较擅长哪方面的能力？（多选题）",type:"多选题"},
                {title:"文明礼貌"},
                {title:"学习能力"},
                {title:"自主劳动"},
                {title:"个人卫生"},
                {title:"语言能力"},
                {title:"思维能力"}
            ],
            [
                {title:"您家里适合孩子阅读的课外书数量？（单选题）",type:"单选题"},
                {title:"文明礼貌"},
                {title:"学习能力"},
                {title:"自主劳动"},
            ],
            [
                {title:"孩子的学习环境如何？（单选题）",type:"单选题"},
                {title:"有独立的房间"},
                {title:"与兄弟姐妹共用房间"},
                {title:"无独立房间"},
            ],
            [
                {title:"家里的卫生情况如何（单选题）",type:"单选题"},
                {title:"很干净"},
                {title:"一般"},
                {title:"不干净"},
            ],
            [
                {title:"孩子和家庭成员的关系？",type:"单选题"},
                {title:"操作成功"},
                {title:"一般"},
                {title:"差"},
            ],
            [
                {title:"当您发现孩子成绩下降后，您的常用做法是？（单选题）",type:"单选题"},
                {title:"帮助分析原因，制定措施"},
                {title:"口头训斥"},
                {title:"打骂"},
                {title:"老师教育方法不对"},
                {title:"成绩不代表什么，身体健康就操作成功"},
            ],
            [
                {title:"间隔多长时间主动与老师联系一次？（单选题）",type:"单选题"},
                {title:"一个月"},
                {title:"一周"},
                {title:"每天"},
                {title:"从来没有"},
                {title:"一学期"},
            ],
            [
                {title:"您孩子定期帮助家人做家务吗？（单选题）",type:"单选题"},
                {title:"经常有"},
                {title:"偶尔有"},
                {title:"从来没有"},
            ],
            [
                {title:"孩子对课外阅读的兴趣如何？（单选题）",type:"单选题"},
                {title:"很喜欢书，涉猎广泛，懂得很多课外知识"},
                {title:"喜欢看书，但范围较窄"},
                {title:"比较喜欢"},
                {title:"很少看书"},
                {title:"完全不看书"},
            ],
            [
                {title:"孩子经常有朋友到家里来玩吗？（单选题）",type:"单选题"},
                {title:"他有很操作成功的朋友，经常来家里"},
                {title:"几乎没有朋友，也从不邀请到家"},
                {title:"有一些朋友，但不常到家"},
                {title:"有自己的朋友，但我不喜欢他带朋友到家里"},
            ],
            [
                {title:"孩子为人处世的态度，您觉得比较符合下列哪一条？（单选题）",type:"单选题"},
                {title:"态度粗暴，比较自我，不容易被人接受"},
                {title:"态度蛮横，性情暴躁，容易与人发生矛盾"},
                {title:"态度冷淡，与世无争，性格较孤僻"},
                {title:"态度友善，情感真诚，容易被人喜爱"},
                {title:"态度畏缩，容易跟随，缺乏自我和自信"},
            ]
            
            ],
            content:{
                text:'',
                imgUrl:[],
                otherUrl:[],
                videoUrl:[]
            },
            viewList:[],
            postShow:[], 
        },
        isCreating:false
    }),

    computed: {
       
    },

    created() {
    },

    methods: {
        selectedLesson(val){
            console.log(val)
        },  
        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true
                this.visitData.content = []
                return;
            }
            this.visitData.content.push(data);
        },

        upImgUrl(value) {
            this.visitData.imgUrl = value;
            console.log(this.visitData.imgUrl);
        },
        clearedImg(){
            this.visitData.imgUrl = ''
            console.log(this.visitData.imgUrl);
        },

        async publishcampusData(){
            this.isCreating = true
            console.log("visitData", this.visitData);
            await createCampus(this.visitData).then(res=>{
                console.log(res)
                this.isCreating = false
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                this.isCreating = false
                console.log(err.response)
            })
        },
    }
}
</script>

<style>

</style>