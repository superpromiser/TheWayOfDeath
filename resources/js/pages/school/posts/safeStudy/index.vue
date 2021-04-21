<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/appIcon/校园安全/闸机.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.safeStudy}}</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow">
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
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
              <v-col cols="6" md="4" class="d-flex align-center position-relative">
                <a @click="$router.go(-1)">
                    <v-icon size="70" class=" left-24p">
                        mdi-chevron-left
                    </v-icon>
                </a>
              </v-col>
              <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                 <h2>{{lang.safeStudy}}</h2>
              </v-col>
              <v-col cols="12" md="4" class="d-flex align-center justify-end">
                <v-btn
                  text
                  color="primary"
                  @click="selContent('template')"
                >
                    可用模板 0， 草稿 0
                </v-btn>
                <v-btn
                    tile
                    dark
                    color="#49d29e"
                    class="mx-2"
                    :loading="isSubmit"
                    @click="submit"
                >
                    {{lang.submit}}
                </v-btn>
                <v-btn
                    tile
                    dark
                    color="#F19861"
                    :loading="isDraft"
                    @click="saveDraft"
                >
                    {{lang.saveDraft}}
                </v-btn>
              </v-col>
            </v-row>
        </v-container>
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
import {createSafeStudy} from '~/api/safeStudy'
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
            await createSafeStudy(this.shareData).then(res=>{
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
                this.shareData.content = [];
                // return this.$snackbar.showMessage({content: this.lang.requiredText, color: "error"})
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