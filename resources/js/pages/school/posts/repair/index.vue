<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="" >
                    <v-img :src="`${baseUrl}/asset/img/appIcon/校园安全/维修工单.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">维修工单</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12" class="d-flex align-center">
                <v-text-field
                    color="#7879ff"
                    v-model="repairData.userName"
                    label="姓名"
                    hide-details
                    readonly
                    class="mt-0 pt-0"
                ></v-text-field>
            </v-col>
        </v-row>
        <!-- <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0">发布位置</p>
                <p class="mb-0">{{repairData.viewList}}</p>
            </v-col>
        </v-row> -->
        <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <v-select
                    color="#7879ff"
                    small-chips
                    :items="returnSchoolTree(currentPath.params.schoolId)"
                    :menu-props="{ top: false, offsetY: true }"
                    item-text="lessonName"
                    item-value="lessonId"
                    @change="selectedLesson"
                    label="发布位置"
                    hide-details
                    return-object
                    v-model="viewList"
                    class="mt-0 pt-0"
                ></v-select>
            </v-col>
        </v-row>
        <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <v-datetime-picker 
                    label="发布时间" 
                    v-model="repairData.deadline"
                    :okText='lang.ok'
                    :clearText='lang.cancel'
                ></v-datetime-picker>
            </v-col>
        </v-row>
        <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <v-select
                    :menu-props="{ top: false, offsetY: true }"
                    :items="itemList"
                    color="#7879ff"
                    v-model="repairData.repairType"
                    class="mt-0 pt-0"
                    label="维修物品"
                    hide-details
                ></v-select>
            </v-col>
        </v-row>
        <v-row class="ma-0 hover-cursor-point">
            <v-col cols="12">
                <QuestionItem :Label="lang.contentPlaceFirst" ref="child" @contentData="loadContentData"></QuestionItem>            
            </v-col>
        </v-row>
        <quick-menu @clickDraft="something" @clickPublish="submit" :isPublishing="isSubmit"></quick-menu>
    </v-container>
    <v-container v-else>
        <v-banner>
            <v-row class="ma-0">
                <v-col>
                    <div class="text-center d-flex justify-space-between align-center">
                        <a @click="$router.go(-1)" class="float-left">
                            <v-icon size="70">
                                mdi-chevron-left
                            </v-icon>
                        </a>
                        <span style="font-size:30px;line-height:2">维修工单</span> 
                        <div class="float-right">
                            <!-- <v-btn class="mr-3" @click="draft">
                                取消
                            </v-btn> -->
                            <v-btn dark color="#7879ff" @click="submit" :loading="isSubmit">
                                确定
                            </v-btn>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-banner>
        <v-row class="ma-0 py-3 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0">姓名</p>
                <p class="mb-0">{{repairData.userName}}</p>
            </v-col>
        </v-row>
        <!-- <v-row class="ma-0 py-3 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <p class="mb-0">发布位置</p>
                <p class="mb-0">{{repairData.viewList}}</p>
            </v-col>
        </v-row> -->
        <v-row class="ma-0 py-3 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <v-row>
                    <v-col cols="6">
                        <p class="mb-0"  >发布位置</p>
                    </v-col>
                    <v-col cols="6">
                        <v-select
                            solo
                            small-chips
                            :items="returnSchoolTree(currentPath.params.schoolId)"
                            :menu-props="{ top: false, offsetY: true }"
                            item-text="lessonName"
                            item-value="lessonId"
                            @change="selectedLesson"
                            label="班级"
                            hide-details
                            return-object
                            v-model="viewList"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row class="ma-0 py-3 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <v-row>
                    <v-col cols="6">
                        <p class="mb-0">维修物品</p>
                    </v-col>
                    <v-col cols="6">
                        <v-select
                            :items="itemList"
                            solo
                            v-model="repairData.repairType"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row class="ma-0 py-3 hover-cursor-point">
            <QuestionItem Label="请输入维修物品的详细信息，例如：桌子、椅子等" ref="child" @contentData="loadContentData"></QuestionItem>            
        </v-row>
        <v-row class="ma-0 py-3 hover-cursor-point">
            <v-col cols="12" class="d-flex justify-space-between align-center">
                <v-row>
                    <v-col cols="6">
                        <p class="mb-0"  >发布时间</p>
                    </v-col>
                    <v-col cols="6">
                        <v-datetime-picker 
                            label="发布时间" 
                            v-model="repairData.deadline"
                            :okText='lang.ok'
                            :clearText='lang.cancel'
                        ></v-datetime-picker>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {mapGetters} from 'vuex'
import {createRepairData} from '~/api/repair'
import quickMenu from '~/components/quickMenu'
export default {
    components:{
        QuestionItem,
        quickMenu,
    },
    data:()=>({
        repairData:{
            userName:'',
            viewListId:'',
            viewListName:'',
            repairType:'',
            content:null,
            deadline:'',
            schoolId:'',
        },
        itemList:[
            '设备维修',
            '保洁服务',
            '桶装水配送',
            '其他'
        ],
        isSubmit:false,
        lang,
        viewList:null,
        baseUrl: window.Laravel.base_url,
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            user:'auth/user'
        })
    },
    created(){
        this.repairData.userName = this.user.name
        this.repairData.schoolId = this.currentPath.params.schoolId
    },
    methods:{
        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true;
                this.repairData.content = null;
                return;
            }
            this.repairData.content = data
        },
        async submit(){
            this.$refs.child.emitData()
            if(this.repairData.content == null){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            // console.log(this.viewList)
            // return
            this.repairData.viewListId = this.viewList.lessonId
            this.repairData.viewListName = this.viewList.lessonName 
            console.log(this.repairData)
            this.isSubmit = true
            await createRepairData(this.repairData).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                this.isSubmit = false
                console.log(err.response)
            })
        },
        draft(){

        },
        selectedLesson(val){
            //console.log(val)
        },

        something(){

        }
    }
}
</script>

<style>

</style>