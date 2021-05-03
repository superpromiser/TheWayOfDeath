<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/icon/recognition.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">表彰</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow">
            <v-col cols="12" sm="6" md="4">
                <v-select
                    class="mo-glow-v-select mt-0 pt-0"
                    :menu-props="{ top: false, offsetY: true }"
                    color="#7879ff"
                    :items="typeItem"
                    item-text="label"
                    item-value="value"
                    v-model="recognitionData.type"
                    label="表彰类型"
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
                    :items="userListItem"
                    :loading="isLoading"
                    item-text="name"
                    item-value="id"
                    @change="selectedUser"
                    :label="noData? '没有学生资料':'表彰对象'"
                    :disabled="noData"
                    hide-details
                    return-object
                    v-model="recognitionData.students"
                ></v-select>
            </v-col>
            <v-col
                cols="12"
                sm="6"
                md="4"
                >
                <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    :return-value.sync="recognitionData.publishDate"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        class="mo-glow-v-text mt-0 pt-0"
                        color="#7879ff"
                        v-model="recognitionData.publishDate"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        hide-details
                        placeholder="颁发日期"
                    ></v-text-field>
                    </template>
                    <v-date-picker
                    v-model="recognitionData.publishDate"
                    no-title
                    scrollable
                    locale="zh-cn"
                    >
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="primary"
                        @click="menu = false"
                    >
                        {{lang.cancel}}
                    </v-btn>
                    <v-btn
                        text
                        color="primary"
                        @click="$refs.menu.save(recognitionData.publishDate)"
                    >
                        {{lang.ok}}
                    </v-btn>
                    </v-date-picker>
                </v-menu>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-text-field
                    class="mo-glow-v-text mt-0 pt-0"
                    color="#7879ff"
                    v-model="recognitionData.awardTitle"
                    label="表彰称号"
                    counter="8"
                    :rules="maxEightRule"
                    hint="选填(最多8个字)"
                ></v-text-field>
            </v-col>
            <v-col cols="12">
                <v-textarea 
                    class="mo-glow-v-text mt-0 pt-0"
                    counter
                    color="#7879ff"
                    label="表彰内容"
                    :rules="maxFourtyRule"
                    v-model="recognitionData.description"
                    hint="限40字"
                ></v-textarea>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow">
            <v-col cols="12">
                <v-chip
                    class="ma-2 px-5"
                    color="primary"
                    outlined
                >
                    <v-icon left>
                        mdi-file-image-outline
                    </v-icon>
                    模板
                </v-chip>
            </v-col>
            <v-col cols="12">
                <v-row>
                    <v-col v-for="(imgUrl, index) in imgUrlItem" :key="index" cols="12" sm="6" md="4" class="position-relative hover-cursor-point" @click="chooseImageTemplate(index)">
                        <v-img :src="`${baseUrl}${imgUrl.path}`" min-height="300" max-height="300" alt="recognition" class="recognition-image" ></v-img>
                        <v-icon :color="imgUrl.selected ? 'green' : 'grey'" class="recognition-img-check-icon position-absolute" size="30">mdi-check-circle</v-icon>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-snackbar
            timeout="3000"
            v-model="isRequired"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
        <quick-menu @clickDraft="something" @clickPublish="submit" :isPublishing="isCreating"></quick-menu>
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
                    <h2>表彰</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        dark
                        color="#49d29e"
                        class="mr-md-8"
                        tile
                        :loading="isCreating"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        :menu-props="{ top: false, offsetY: true }"
                        solo
                        :items="typeItem"
                        item-text="label"
                        item-value="value"
                        v-model="recognitionData.type"
                        label="表彰类型"
                        hide-details
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        multiple
                        chips
                        :menu-props="{ top: false, offsetY: true }"
                        :items="userListItem"
                        item-text="name"
                        item-value="id"
                        @change="selectedUser"
                        :loading="isLoading"
                        :label="noData? '没有学生资料':'表彰对象'"
                        :disabled="noData"
                        hide-details
                        return-object
                        v-model="recognitionData.students"
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="recognitionData.awardTitle"
                        label="表彰称号"
                        counter="8"
                        :rules="maxEightRule"
                        hint="选填(最多8个字)"
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    >
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="recognitionData.publishDate"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            solo
                            v-model="recognitionData.publishDate"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            hide-details
                            placeholder="颁发日期"
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="recognitionData.publishDate"
                        no-title
                        scrollable
                        locale="zh-cn"
                        >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                            @click="menu = false"
                        >
                            {{lang.cancel}}
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$refs.menu.save(recognitionData.publishDate)"
                        >
                            {{lang.ok}}
                        </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12">
                    <v-textarea
                        counter
                        solo
                        label="表彰内容"
                        :rules="maxFourtyRule"
                        v-model="recognitionData.description"
                        hint="限40字"
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-chip
                        class="ma-2 px-5"
                        color="primary"
                        outlined
                    >
                        <v-icon left>
                            mdi-file-image-outline
                        </v-icon>
                        模板
                    </v-chip>
                </v-col>
                <v-col cols="12">
                    <v-row>
                        <v-col v-for="(imgUrl, index) in imgUrlItem" :key="index" cols="12" sm="6" md="4" class="position-relative hover-cursor-point" @click="chooseImageTemplate(index)">
                            <v-img :src="`${baseUrl}${imgUrl.path}`" min-height="300" max-height="300" alt="recognition" class="recognition-image" ></v-img>
                            <v-icon :color="imgUrl.selected ? 'green' : 'grey'" class="recognition-img-check-icon position-absolute" size="30">mdi-check-circle</v-icon>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
        <v-snackbar
            timeout="3000"
            v-model="isRequired"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
    </v-container>
</template>

<script>

import { mapGetters } from 'vuex';
import lang from '~/helper/lang.json';
import QuestionItem from '~/components/questionItem';
import {createRecognition} from '~/api/recognition';
import quickMenu from '~/components/quickMenu';
import {getLessonUserList} from '~/api/user';

export default {
    middleware:['post','auth'],
    data: () => ({
        lang,
        baseUrl: window.Laravel.base_url,
        maxEightRule: [v => v.trim().split(' ').length <= 8 || '选填(最多8个字)'],
        maxFourtyRule: [v => v.length <= 40 || '选填(最多40个字)'],
        recognitionData:{
            type:'',
            students:[],
            awardTitle:'',
            publishDate:'',
            description:'',
            imgUrl:'',
            schoolId:null,
            classId:null,
            // viewList:[],
            // postShow:[],
        },
        isRequired:false,
        isCreating:false,
        typeItem : [
            { 
                label : "投票后可见", 
                value : "投票后可见" 
            },
            { 
                label : "投票前后均可见", 
                value : "投票前后均可见" 
            },
            { 
                label : "投票前后均不可见", 
                value : "投票前后均不可见" 
            },
            
        ],
        userListItem : [],
        imgUrlItem : [
            {
                path: '/asset/img/icon/recognition/2_副本.jpg',
                selected : false,
            },
            {
                path: '/asset/img/icon/recognition/def_commend_model1.png',
                selected : false,
            },
            {
                path: '/asset/img/icon/recognition/def_commend_model3.png',
                selected : false,
            },
            {
                path: '/asset/img/icon/recognition/def_commend_model4.png',
                selected : false,
            },
            {
                path: '/asset/img/icon/recognition/微信图片_20190712095501.jpg',
                selected : false,
            },
            {
                path: '/asset/img/icon/recognition/微信图片_20190712095608.jpg',
                selected : false,
            },
        ],
        dialog:false,
        date: new Date().toISOString().substr(0, 10),
        menu: false,
        noData: false,
        isLoading: false,
    }),

    components: {
        QuestionItem,
        quickMenu
    },

    computed: {
        currentPath(){
            return this.$route;
        }
    },

    async created(){
        this.isLoading = true;
        await getLessonUserList({lessonId:this.currentPath.params.lessonId})
        .then(res=>{
            this.userListItem = res.data
            if(this.userListItem.length == 0){
                this.noData = true;
            }
        }).catch(err=>{
            console.log(err.response)
        })
        this.isLoading = false;

        //console.log(this.recognitionData.content)
        this.recognitionData.schoolId = this.currentPath.params.schoolId
        this.recognitionData.classId = this.currentPath.params.lessonId
    },

    methods:{
        updateImageFile(imageFile){
            //console.log(imageFile)
        },
        selectedUser(val){
            //console.log(val)
            this.recognitionData.students = val;
        },
        chooseImageTemplate(index){
            this.imgUrlItem.map(item => {
                item.selected = false;
            })
            this.imgUrlItem[index].selected = true;
            this.recognitionData.imgUrl = this.imgUrlItem[index].path;
        },
        async submit(){
            console.log(this.recognitionData)
            if(this.recognitionData.type == '' ){
                return this.$snackbar.showMessage({content: '请选择识别类型', color: 'error'});
            }
            if(this.recognitionData.students.length == 0){
                return this.$snackbar.showMessage({content: '选择学生获得认可', color: 'error'});
            }
            if(this.recognitionData.awardTitle.trim() == ''){
                return this.$snackbar.showMessage({content: '奖励标题不能为空', color: 'error'});
            }
            if(this.recognitionData.awardTitle.trim().length > 8 ){
                return this.$snackbar.showMessage({content: '奖励标题不得超过8个字符', color: 'error'});
            }
            if(this.recognitionData.publishDate == ''){
                return this.$snackbar.showMessage({content: '奖励的颁发日期不可空白', color: 'error'});
            }
            if(this.recognitionData.description.trim() == ''){
                return this.$snackbar.showMessage({content: '奖项说明不能空白', color: 'error'});
            }
            if(this.recognitionData.description.trim().length > 40){
                return this.$snackbar.showMessage({content: '奖励内容不得超过40个字符', color: 'error'});
            }
            if(this.recognitionData.imgUrl == ''){
                return this.$snackbar.showMessage({content: '请选择引文模板', color: 'error'});
            }
            this.isCreating = true
            await createRecognition(this.recognitionData).then(res=>{
                console.log(res)
                this.isCreating = false
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'classSpace.news'})
                }
            }).catch(err=>{
                this.isCreating = false
                //console.log(err.response)
            })

        },

        something(){
            
        }
    }
}
</script>

<style>

</style>