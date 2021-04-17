<template>
    <v-container>
        <div v-if="showDetail == false">
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
                        <h2>{{homeworkData.homeworkType}}</h2>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex align-center justify-end">
                        <v-btn
                            dark
                            tile
                            color="#F19861"
                            @click="viewDetail"
                        >
                            查看详情
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
            <v-col cols="12" class="pl-10 pt-0 mt-5">
            <div class="d-flex align-center">
                <p class="text-wrap mb-0">
                <strong>作业科目:</strong>
                {{homeworkData.subjectName}}
                </p>
            </div>
            <div class="d-flex align-center">
                <p class="text-wrap mb-0">
                <strong>作业类型:</strong>
                {{homeworkData.homeworkType}}
                </p>
            </div>
            <div class="d-flex align-center">
                <p class="text-wrap mb-0">
                <strong>作业内容:</strong>
                {{homeworkData.content.text}}
                </p>
            </div>
            </v-col>
            <v-col cols="12" class="pl-10 pt-0">
            <v-row>
                <v-col cols="12" v-if="checkIfAttachExist(homeworkData.content)">
                <AttachItemViewer :items="homeworkData.content" />
                </v-col>
            </v-row>
            </v-col>
        </div>
        <div v-else>
            <router-view :contentData="contentData"></router-view>
        </div>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
import AttachItemViewer from '~/components/attachItemViewer';
export default {
    components:{
        AttachItemViewer,
    },
    data:()=>({
        baseUrl:window.Laravel.base_url,
        lang,
        homeworkData:null,
        showDetail:false,
    }),
    computed:{
         currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail',
            user:'auth/user'
        })
    },
    created(){
        if(this.contentData == null){
            if(this.currentpath.params.lessonId){
                this.$router.push({name:'classSpace.news'})
            }else{
                this.$router.push({name:'schoolSpace.news'})
            }
        }
        console.log("this.contentData",this.contentData)
        this.homeworkData = this.contentData.homework
    },
    methods:{
        viewDetail(){
            console.log('viewDetail')
            this.showDetail = true
        }
    }

}
</script>

<style>

</style>