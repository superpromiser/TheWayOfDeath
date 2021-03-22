<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/表彰.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>表彰</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                dark
                color="green lighten-1"
                class="mr-8"
                tile
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
                        :items="userListItem"
                        item-text="name"
                        item-value="id"
                        @change="selectedUser"
                        label="表彰对象"
                        hide-details
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
                            @click="$refs.menu.save(date)"
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
    </v-container>
</template>

<script>

import { mapGetters } from 'vuex'
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
export default {
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
            imgStyle:{
                recImg:'',
                imgUrl:''
            },
            className:'',
            viewList:[],
            postShow:[],
        },
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
        userListItem : [
            { 
                name : "sammie", 
                id : 1 
            },
            { 
                name : "tommy", 
                id : 2 
            },
            { 
                name : "hommey", 
                id : 3 
            },
            
        ],
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
    }),

    components: {
        QuestionItem,
    },

    computed: {
        ...mapGetters({
            schoolTree : 'schooltree/schoolTree',
        })
    },

    mounted(){
        console.log(this.recognitionData.content)
    },

    methods:{
        updateImageFile(imageFile){
            console.log(imageFile)
        },
        selectedUser(val){
            console.log(val)
            this.recognitionData.students = val;
        },
        chooseImageTemplate(index){
            this.imgUrlItem.map(item => {
                item.selected = false;
            })
            this.imgUrlItem[index].selected = true;
            this.recognitionData.imgStyle.imgUrl = this.imgUrlItem[index].path;
        }
    }
}
</script>

<style>

</style>