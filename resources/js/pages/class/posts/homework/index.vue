<template>
    <v-container v-if="$isMobile()" class="ma-0 pa-0 h-100">
        <v-container v-if="showRule == false" class="pa-0 h-100 bg-white mb-16 pb-3 pt-12" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="navToBackCustom" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
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
                    <v-select
                        :menu-props="{ top: false, offsetY: true }"
                        color="#7879ff"
                        :items="subjectList"
                        v-model="homeworkData.subjectName"
                        label="科目"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        :menu-props="{ top: false, offsetY: true }"
                        color="#7879ff"
                        :items="homeworkType"
                        v-model="homeworkData.homeworkType"
                        item-text="label"
                        item-value="value"
                        label="类型"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-select>
                </v-col>
                <v-col @click="setRule" v-ripple cols="12" class="d-flex align-center justify-space-between">
                    <p class="mb-0">发布规则</p>
                    <v-icon right> mdi-chevron-right </v-icon>
                </v-col>
            </v-row>
            <QuestionItem Label="" :emoji="true" :isAnnouncement="true" :isShareView="true" :item="homeworkData.content[0]" ref="child" @contentData="loadContentData"></QuestionItem>
            <v-btn @click="templateList" rounded color="#E0E0E0" small elevation="0" class="position-absolute font-color-gray-dark-btn" style="bottom: 54px; left: 12px;"> <v-icon left>mdi-buffer</v-icon>模板</v-btn>
            <v-menu top offset-y :close-on-content-click="true" :content-class="publishSpecUserList !== null&&publishSpecUserList.length > 0 ? 'box-shadow-none publish-type-menu-with-btn': 'box-shadow-none publish-type-menu'" tile min-width="90">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn v-bind="attrs" v-on="on" rounded color="#E0E0E0" small elevation="0" class="position-absolute font-color-gray-dark-btn" style="bottom: 54px; right: 12px;"> <v-icon left>mdi-earth</v-icon>
                        {{homeworkData.publishType=="all"? '公开' : homeworkData.publishType=="me"? '私密' : publishSpecUserList == null ? '部分看见' : `部分看见(${publishSpecUserList.length})`}}
                    </v-btn>
                </template>
                <div class="pa-3 text-right">
                    <v-radio-group class="mt-0 pt-0" v-model="homeworkData.publishType" @change="selectPublishType" mandatory dense hide-details >
                        <v-radio name="homeworkData.publishType" color="#7879ff" label="公开" value="all" ></v-radio>
                        <v-radio name="homeworkData.publishType" color="#7879ff" label="私密" value="me" ></v-radio>
                        <v-radio name="homeworkData.publishType" color="#7879ff" label="部分看见" value="some" ></v-radio>
                    </v-radio-group>
                    <v-btn v-if="publishSpecUserList !== null&&publishSpecUserList.length > 0" elevation="0" small text color="#7879ff" @click="changeSelectedUserList">重选名单</v-btn>
                </div>
            </v-menu>
        </v-container>
        <v-container class="pa-0 ma-0" v-else>
            <router-view></router-view>
        </v-container>
    </v-container>
    <v-container v-else class="pa-0">
        <div v-if="showRule == false">
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
                        <h2>{{lang.homework}}</h2>
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
            <v-container class="px-10">
                <v-row class="ma-0">
                    <v-col cols="6" class="d-flex align-center text-left">
                        <p class="mb-0">科目</p>
                    </v-col>
                    <v-col cols="6" class="d-flex align-center">
                        <v-select
                            :items="subjectList"
                            v-model="homeworkData.subjectName"
                            label="科目"
                            solo
                            :menu-props="{ top: false, offsetY: true }"
                            class="mt-0 pt-0"
                            hide-details
                        ></v-select>
                    </v-col>
                </v-row>
                <v-divider light></v-divider>
                <v-row class="ma-0">
                    <v-col cols="6" class="d-flex align-center text-left">
                        <p class="mb-0 w-100">类型</p>
                    </v-col>
                    <v-col cols="6" class="d-flex align-center">
                        <v-select
                            :items="homeworkType"
                            label="类型"
                            item-text="label"
                            item-value="value"
                            solo
                            v-model="homeworkData.homeworkType"
                            :menu-props="{ top: false, offsetY: true }"
                            class="mt-0 pt-0"
                            hide-details
                        ></v-select>
                    </v-col>
                </v-row>
                <v-divider light></v-divider>
                <v-row class="ma-0 hover-cursor-point" v-ripple @click="setRule">
                    <v-col cols="12" class="d-flex align-center justify-space-between py-6">
                        <p class="mb-0">发布规则</p>
                        <div class="d-flex align-center">
                            <span>即时发布</span>
                            <v-icon right>
                                mdi-chevron-right
                            </v-icon>
                        </div>
                    </v-col>
                </v-row>
                <v-divider light></v-divider>
                <QuestionItem class="mt-3" Label="作业内容" :emoji="true"  ref="child" @contentData="loadContentData" :item="homeworkData.content[0]"></QuestionItem>
                <v-row>
                    <v-col cols="8" md="10"></v-col>
                    <v-col cols="4" class="justify-end" md="2">
                        <v-select
                            :items='viewList'
                            item-text="label"
                            item-value="value"
                            v-model="viewType"
                            @change="selViewList"
                            :menu-props="{ top: false, offsetY: true }"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {getMySubject,createHomeworkData,getTemplateCnt,createTemplate} from '~/api/homework'
import {getLessonUserList} from '~/api/user'
export default {
    components:{
        QuestionItem,
    },
    data:()=>({
        lang,
        isSubmit:false,
        isDraft:false,
        tempCnt:0,
        draftCnt:0,
        baseUrl:window.Laravel.base_url,
        homeworkData:{
            subjectName:'',
            homeworkType:'',
            content:[{
                text: '',
                imgUrl: [],
                otherUrl: [],
                videoUrl: []
            }],
            deadline:'',
            monitorName:'',
            parentCheck:false,
            viewList:[],
            publishType: 'all'
        },
        homeworkType:[
            {
                label:'常规作业',
                value:'常规作业'
            },
            {
                label:'在线作业',
                value:'在线作业'
            },
            // {
            //     label:'在线测试',
            //     value:'在线测试'
            // }
        ],
        subjectList:[],
        showRule:false,
        viewList:[
            {
                label:'公开',
                value:'all'
            },
            {
                label:'私密',
                value:'me'
            },
            {
                label:'部分可见',
                value:'some'
            },
        ],
        viewType:'all',
        userList:[],
        templateCnt:0,
        draftCnt:0,
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            user: 'auth/user',
            publishContent: 'mo/publishContent',
            publishSpecUserList: 'mo/publishSpecUserList',
            backWithoutSelect: 'mo/backWithoutSelect',
            backWithChange: 'mo/backWithChange',
            clickedChange: 'mo/clickedChange',
            specUsers:'member/specUsers',
       }),
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name == 'posts.Chomework'){
                    this.showRule = false
                }
                if(val.query.rule){
                    console.log(val.query.rule)
                    this.homeworkData.deadline = val.query.rule.deadline
                    this.homeworkData.monitorName = val.query.rule.monitorName
                    this.homeworkData.parentCheck = val.query.rule.parentCheck

                    // this.homeworkData = val.query.rule
                    // console.log(this.homeworkData)
                }
                if(val.query.tempData){
                    this.homeworkData.content = JSON.parse(val.query.tempData)
                }
            },
            deep:true
        }
    },
    created(){
        this.$router.push({name:'posts.Chomework'})
        if(this.currentPath.name == 'posts.Chomework'){
            this.showRule = false
        }
        if(this.publishContent !== null){
            this.homeworkData = this.publishContent;
        }
        if(this.backWithoutSelect == true){
            this.homeworkData.publishType = 'all';
        }
        // if(this.currentPath.name == 'posts.Cannouncement'){
        //     this.isPosting = true
        // }
        getMySubject({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            this.subjectList = res.data
        })
        getLessonUserList({lessonId:this.currentPath.params.lessonId}).then(res=>{
            res.data.map(data=>{
                this.$set(data,'checkbox',false)
            })
            this.userList = res.data
            console.log("this.userList",this.userList)
        }).catch(err=>{
            console.log(err.response)
        })
        getTemplateCnt({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            this.templateCnt = res.data.templateCnt
            this.draftCnt = res.data.draftCnt
        })
    },
    methods:{
        submit(){
            console.log("submit")
            this.$refs.child.emitData()
            
            if(this.homeworkData.subjectName == ''){
                return this.$snackbar.showMessage({content: this.lang.homework+this.lang.requireSubjectName, color: "error"})             
            }
            if(this.homeworkData.homeworkType == ''){
                return this.$snackbar.showMessage({content: this.lang.homework+this.lang.requireSubjectType, color: "error"})             
            }
            // if(this.homeworkData.deadline == '' || this.homeworkData.monitorName == ''){
            //     return this.$snackbar.showMessage({content: '您没有设定发布规则', color: "error"})             
            // }

            if(this.homeworkData.content[0].text.trim() == ''){
                return this.$snackbar.showMessage({content: this.lang.homework+this.lang.requireContent, color: "error"})
            }
            this.isSubmit = true
            if(this.$isMobile()){
                if(this.homeworkData.publishType == 'all'){
                    this.userList.map(user=>{
                        this.homeworkData.viewList.push(user.id)
                    })
                }
                else if(this.homeworkData.publishType == 'me'){
                    
                }
                else if(this.homeworkData.publishType == 'some'){
                    this.homeworkData.viewList = this.publishSpecUserList;
                }
            }
            else{
                if(this.viewType == 'all'){
                    this.userList.map(user=>{
                        this.homeworkData.viewList.push(user.id)
                    })
                }else if(this.viewType == 'me'){

                }else if(this.viewType == 'some'){
                    this.homeworkData.viewList = this.specUsers
                }
            }
            this.homeworkData.viewList.push(this.user.id)
            console.log("this.homeworkData",this.homeworkData)
            // return
            createHomeworkData({
                schoolId:this.currentPath.params.schoolId,
                lessonId:this.currentPath.params.lessonId,
                subjectName:this.homeworkData.subjectName,
                homeworkType:this.homeworkData.homeworkType,
                content:this.homeworkData.content,
                deadline: this.homeworkData.deadline=='' ? null : this.TimeViewSam(this.homeworkData.deadline),
                monitorName:this.homeworkData.monitorName,
                parentCheck:this.homeworkData.parentCheck,
                viewList:this.homeworkData.viewList
            }).then(res=>{
                this.isSubmit = false
                console.log(res.data)
                this.clearStore();
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'classSpace.news'})
                }
                
            }).catch(err=>{
                console.log(err.response)
                this.clearStore();
                this.isSubmit = false
            })
        },
        templateList(){
            console.log("go to template list")
            this.showRule = true
            this.$router.push({name:"Chomework.templateList"})
        },
        async saveDraft(){
            this.$refs.child.emitData()
            let draftData = {}
            draftData.tempType = 2
            draftData.content = []
            draftData.schoolId = this.currentPath.params.schoolId
            if(this.currentPath.params.lessonId){
                draftData.lessonId = this.currentPath.params.lessonId
            }
            let currentTime = this.TimeView(new Date());
            draftData.title = 'title-' + currentTime
            draftData.description = 'description-' + currentTime
            console.log(draftData)
            if(this.homeworkData.content.length == 0){
                return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
            }
            draftData.content = this.homeworkData.content
            this.isDraft = true
            await createTemplate(draftData).then(res=>{
                console.log(res.data)
                this.isDraft = false
                this.draftCnt ++ 
            }).catch(err=>{
                console.log(err.response)
                this.isDraft = false
            })
        },
        setRule(){
            this.showRule = true
            console.log('setRule')
            this.$router.push({name:'Chomework.setRule'});
        },
        loadContentData(data){
            console.log(data)
            if(data.text == ''){
                this.homeworkData.content = []
                return
            }
            this.homeworkData.content.push(data)
        },
        selViewList(){
            console.log(this.viewType)
            
            if(this.viewType == 'some'){
                this.showRule = true
                this.$router.push({name:'Chomework.contacts'})
            }
        },

        selectPublishType( val ){
            console.log(val, this.homeworkData.content);
            if(val == 'some'){
                if(this.homeworkData.content.text.trim() == ''){
                    this.homeworkData.publishType = null;
                    return this.$snackbar.showMessage({content: this.lang.homework+this.lang.requireContent, color: "error"})
                }
                this.$store.dispatch('mo/onPublishContent', this.homeworkData);
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
            this.clearStore();
            this.$router.go(-1);
        },

        clearStore(){
            this.$store.dispatch('mo/onPublishContent', null);
            this.$store.dispatch('mo/onPublishSpecUserList', null);
            this.$store.dispatch('mo/onBackWithoutSelect', false);
            this.$store.dispatch('mo/onClickedChange', false);
            this.$store.dispatch('mo/onBackWithChange', false);
            this.$store.dispatch('member/storeSpecUsers',[])
        }
    }
}
</script>

<style>

</style>