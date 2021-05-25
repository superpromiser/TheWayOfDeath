<template>
    <v-container v-if="$isMobile()"  class="ma-0 pa-0 h-100">
        <v-container v-if="isPosting == true" class="pa-0 h-100 bg-white mb-16 pb-3 pt-12" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="navToBackCustom" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.share}}</p>
                <v-btn @click="submit" :loading="isSubmit" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <QuestionItem Label="" :emoji="true" :isShareView="true" :item="shareData.content[0]" ref="child" @contentData="loadContentData"></QuestionItem>
            <v-btn @click="templateList()" rounded color="#E0E0E0" small elevation="0" class="position-absolute font-color-gray-dark-btn" style="bottom: 54px; left: 12px;"> <v-icon left>mdi-buffer</v-icon>模板</v-btn>
            <v-menu top offset-y :close-on-content-click="true" :content-class="publishSpecUserList !== null&&publishSpecUserList.length > 0 ? 'box-shadow-none publish-type-menu-with-btn': 'box-shadow-none publish-type-menu'" tile min-width="90">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn v-bind="attrs" v-on="on" rounded color="#E0E0E0" small elevation="0" class="position-absolute font-color-gray-dark-btn" style="bottom: 54px; right: 12px;"> <v-icon left>mdi-earth</v-icon>
                        {{shareData.publishType=="pub"? '公开' : shareData.publishType=="pvt"? '私密' : publishSpecUserList == null ? '部分看见' : `部分看见(${publishSpecUserList.length})`}}
                    </v-btn>
                </template>
                <div class="pa-3 text-right">
                    <v-radio-group class="mt-0 pt-0" v-model="shareData.publishType" @change="selectPublishType" mandatory dense hide-details >
                        <v-radio name="shareData.publishType" color="#7879ff" label="公开" value="pub" ></v-radio>
                        <v-radio name="shareData.publishType" color="#7879ff" label="私密" value="pvt" ></v-radio>
                        <v-radio name="shareData.publishType" color="#7879ff" label="部分看见" value="spec" ></v-radio>
                    </v-radio-group>
                    <v-btn v-if="publishSpecUserList !== null&&publishSpecUserList.length > 0" elevation="0" small text color="#7879ff" @click="changeSelectedUserList">重选名单</v-btn>
                </div>
            </v-menu>
        </v-container>
        <v-container class="pa-0 ma-0" v-else>
            <router-view></router-view>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
        <div v-if="isPosting == true">
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
                        <h2>{{lang.share}}</h2>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex align-center justify-end">
                        <v-btn
                            text
                            color="#999999"
                            @click="templateList"
                        >
                            可用模板 {{templateCnt}}， 草稿 {{draftCnt}}
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
                <QuestionItem Label="分享内容" :emoji="true" :item="shareData.content[0]" ref="child" @contentData="loadContentData"></QuestionItem>
            </v-container>
            <v-row class="px-10 ma-0">
                <v-col cols="8" md="10"></v-col>
                <v-col cols="4" class="justify-end" md="2">
                    <v-select
                        :items='viewList'
                        item-text="label"
                        item-value="value"
                        v-model="shareData.publishType"
                        @change="selViewList"
                        :menu-props="{ top: false, offsetY: true }"
                    ></v-select>
                </v-col>
            </v-row>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import { mapGetters } from 'vuex'
import {createShare,getTemplateCnt,createTemp} from '~/api/share'

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
        shareData:{
            schoolId:null,
            lessonId:null,
            content:[
                {
                    text:'',
                    imgUrl:[],
                    otherUrl:[],
                    videoUrl:[]
                },
            ],
            publishType: 'pub'
        },
        isSuccessed:false,
        contentData:{
            text:'',
            imgUrl:[],
            otherUrl:[],
            videoUrl:[]
        },

        publishTypeRadio: null,
        viewList:[
            {
                label:'公开',
                value:'pub'
            },
            {
                label:'私密',
                value:'pvt'
            },
            {
                label:'部分可见',
                value:'spec'
            },
        ],
        isPosting:false,
        draftCnt:0,
        templateCnt:0,
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            publishContent: 'mo/publishContent',
            publishSpecUserList: 'mo/publishSpecUserList',
            backWithoutSelect: 'mo/backWithoutSelect',
            backWithChange: 'mo/backWithChange',
            clickedChange: 'mo/clickedChange',
            specUsers:'member/specUsers',
            user:'auth/user'
        }),
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name == 'posts.Cshare'){
                    this.isPosting = true
                }
                if(val.query.tempData){
                    console.log(JSON.parse(val.query.tempData))
                    this.shareData.content = JSON.parse(val.query.tempData)
                }
            },
            deeper:true
        }
    },
    created(){
        console.log(this.publishContent);
        console.log(this.publishSpecUserList);
        if(this.publishContent !== null){
            this.shareData = this.publishContent;
        }
        if(this.backWithoutSelect == true){
            this.shareData.publishType = 'pub';
        }
        if(this.currentPath.name == 'posts.Cshare'){
            this.isPosting = true
        }
        this.shareData.schoolId = this.currentPath.params.schoolId;
        this.shareData.lessonId = this.currentPath.params.lessonId;
        getTemplateCnt({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            this.templateCnt = res.data.templateCnt
            this.draftCnt = res.data.draftCnt
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        async saveDraft(){
            this.$refs.child.emitData()
            let draftData = {}
            draftData.tempType = 2
            draftData.content = this.contentData
            draftData.schoolId = this.currentPath.params.schoolId
            if(this.currentPath.params.lessonId){
                draftData.lessonId = this.currentPath.params.lessonId
            }
            let currentTime = this.TimeView(new Date());
            draftData.title = 'title-' + currentTime
            draftData.description = 'description-' + currentTime
            console.log(draftData)
            if(this.shareData.content.length == 0){
                return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
            }
            draftData.content = this.shareData.content
            this.isDraft = true
            await createTemp(draftData).then(res=>{
                console.log(res.data)
                this.isDraft = false
                this.draftCnt ++ 
            }).catch(err=>{
                console.log(err.response)
                this.isDraft = false
            })
        },

        templateList(){
            this.$router.push({name:"Cshare.templateList"})
            this.isPosting = false
        },

        async submit(){
            console.log(this.shareData)
            if(this.$isMobile()){
                if(this.shareData.content[0].text.trim() == ''){
                    return this.$snackbar.showMessage({content: this.lang.share+this.lang.requireContent, color: "error"})
                }
                if(this.shareData.publishType == 'spec'){
                    this.$set(this.shareData, 'specUsers', this.publishSpecUserList);
                    this.shareData.specUsers.push(this.user.id)
                }
                console.log("MO", this.shareData);
                this.isSubmit = true
                await createShare(this.shareData).then(res=>{
                    this.$store.dispatch('mo/onPublishContent', null);
                    this.$store.dispatch('mo/onPublishSpecUserList', null);
                    this.$store.dispatch('mo/onBackWithoutSelect', false);
                    this.$store.dispatch('mo/onClickedChange', false);
                    this.$store.dispatch('mo/onBackWithChange', false);
                    this.$router.push({name:'home'})
                }).catch(err=>{
                })
                this.isSubmit = false
            }
            else{
                this.$refs.child.emitData()
                if(this.shareData.content.length == 0){
                    return this.$snackbar.showMessage({content: this.lang.share+this.lang.requireContent, color: "error"})
                }
                if(this.shareData.publishType == 'spec'){
                    this.$set(this.shareData, 'specUsers', this.specUsers);
                    this.shareData.specUsers.push(this.user.id)
                }
                this.isSubmit = true
                await createShare(this.shareData).then(res=>{
                    this.$store.dispatch('member/storeSpecUsers', []);
                    this.$router.push({name:'classSpace.news'})
                }).catch(err=>{
                })
                this.isSubmit = false
            }
        },

        loadContentData(data){
            if(data.text === ''){
                this.shareData.content = [];
                return;
            }
            this.shareData.content.push(data)
        },
        
        selectPublishType( val ){
            console.log(val);
            if(val == 'spec'){
                if(this.shareData.content[0].text.trim() == ''){
                    this.shareData.publishType = null;
                    return this.$snackbar.showMessage({content: this.lang.share+this.lang.requireContent, color: "error"})
                }
                this.$store.dispatch('mo/onPublishContent', this.shareData);
                this.$store.dispatch('mo/onBackWithoutSelect', false);
                this.$router.push({name: 'member.selectMo'});
            }
            else{
                if(this.publishSpecUserList !== null){
                    this.$store.dispatch('mo/onPublishSpecUserList', null);
                }
                if(this.clickedChange == true){
                    this.$store.dispatch('mo/onClickedChange', false);
                }
            }
        },

        changeSelectedUserList(){
            this.$store.dispatch('mo/onClickedChange', true);
            this.$router.push({name: 'member.selectMo'});
        },

        navToBackCustom(){
            this.$store.dispatch('mo/onPublishContent', null);
            this.$store.dispatch('mo/onPublishSpecUserList', null);
            this.$store.dispatch('mo/onBackWithoutSelect', false);
            this.$store.dispatch('mo/onClickedChange', false);
            this.$store.dispatch('mo/onBackWithChange', false);
            this.$router.go(-1);
        },
        selViewList(){
            if(this.shareData.publishType == 'spec'){
                this.isPosting = false
                this.$router.push({name:'Cshare.contacts'})
            }
        }
    }
}
</script>

<style>
    
</style>