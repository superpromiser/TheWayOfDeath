<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/newIcon/分享.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.share}}</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow mt-5">
            <v-col cols="12">
                <QuestionItem :Label="lang.contentPlaceFirst" :emoji="true" :contact="true"  ref="child" @contentData="loadContentData"></QuestionItem>
            </v-col>
        </v-row>
        <v-snackbar
            timeout="3000"
            v-model="requiredText"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
        <v-snackbar
        timeout="3000"
            v-model="isSuccessed"
            color="success"
            absolute
            top
            >
            {{lang.successText}}
        </v-snackbar>
        <quick-menu @clickDraft="something" @clickPublish="submit" :isPublishing="isSubmit"></quick-menu>
  </v-container>
    <v-container class="pa-0" v-else>
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center w-50 justify-space-between">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <h2>{{lang.share}}</h2>
            </div>
            <div class="d-flex align-center justify-center">
                <v-btn
                    text
                    color="primary"
                    @click="selContent('template')"
                >
                    可用模板 0， 草稿 0
                <v-btn
                    dark
                    tile
                    color="#F19861"
                    :loading="isDraft"
                    class="mx-2"
                    @click="saveDraft"
                >
                    {{lang.saveDraft}}
                </v-btn>
                </v-btn>
                <v-btn
                    dark
                    tile
                    color="#49d29e"
                    class="mr-8"
                    :loading="isSubmit"
                    @click="submit"
                >
                    {{lang.submit}}
                </v-btn>
            </div>
        </v-banner>
        <v-container class="pa-10">
            <QuestionItem :Label="lang.contentPlaceFirst" :emoji="true" :contact="true"  ref="child" @contentData="loadContentData"></QuestionItem>
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
        <v-snackbar
        timeout="3000"
            v-model="isSuccessed"
            color="success"
            absolute
            top
            >
            {{lang.successText}}
        </v-snackbar>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {createShare} from '~/api/share'
import quickMenu from '~/components/quickMenu'
export default {
    components:{
        QuestionItem,
        quickMenu,
    },

    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        isSubmit:false,
        isDraft:false,
        requiredText:false,
        shareData:{
            schoolId:null,
            content:[]
        },
        isSuccessed:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        this.shareData.schoolId = this.currentPath.params.schoolId
    },
    methods:{
        saveDraft(){

        },
        async submit(){
            this.$refs.child.emitData()
            if(this.shareData.content.length == 0){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            //console.log(this.shareData)
            this.isSubmit = true
            await createShare(this.shareData).then(res=>{
                console.log(res)
                this.isSubmit = false
                this.isSuccessed = true;
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                //console.log(err.response)
                this.isSubmit = false
            })
        },

        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true;
                this.shareData.content = [];
                return;
            }
            this.shareData.content.push(data)
        },
        something(){

        }
    }
}
</script>

<style>

</style>