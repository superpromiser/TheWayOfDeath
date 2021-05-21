<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3 pt-12" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.schoolStory}}模板清单</p>
                <v-btn @click="submit" :loading="isSubmit" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0 mo-glow bg-white">
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        color="#7879ff"
                        v-model="templateData.title"
                        label="模板名称"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        color="#7879ff"
                        v-model="templateData.description"
                        label="说明"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-text-field>
                </v-col>
            </v-row>
            <QuestionItem Label="" :emoji="true" :isShareView="true" :item="templateData.content[0]" ref="child" @contentData="loadContentData"></QuestionItem>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
        <v-container class="z-index-2 mb-15 banner-custom px-10">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class=" left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.schoolStory}}模板清单</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        tile
                        dark
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
        <v-row class="px-10 ma-0">
            <v-col cols="12" sm="6" md="4">
                <v-text-field
                solo
                v-model="templateData.title"
                label="模板名称"
                hide-details
                ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-text-field
                solo
                v-model="templateData.description"
                label="说明"
                hide-details
                ></v-text-field>
            </v-col>
        </v-row>
        <v-container class="pa-10">
            <QuestionItem Label="分享内容" :emoji="true" ref="child" @contentData="loadContentData"></QuestionItem>
        </v-container>
    </v-container>
</template>

<script>
import {createTemplate} from '~/api/schoolStory'
import QuestionItem from '~/components/questionItem'
import lang from '~/helper/lang.json'
export default {
    components:{
        QuestionItem
    },
    data:()=>({
        templateData:{
            title:"",
            description:"",
            tempType:1,
            content:[],
            schoolId:null,
            lessonId:null
        },
        isSubmit:false,
        lang
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        this.templateData.schoolId = this.currentPath.params.schoolId
    },
    methods:{
        loadContentData(data){
            console.log(data)
            if(data.text === ''){
                this.templateData.content = [];
                return;
            }
            this.templateData.content.push(data)
        },
        async submit(){
            this.$refs.child.emitData()
            console.log(this.templateData)
            if(this.templateData.title.trim() == ''){
                return this.$snackbar.showMessage({content: this.lang.share + this.lang.requireTitle, color: 'error'})
            }
            if(this.templateData.description.trim() == ''){
                return this.$snackbar.showMessage({content: this.lang.share + this.lang.requireDescription, color: 'error'})
            }
            if(this.templateData.content.length == 0){
                return this.$snackbar.showMessage({content: this.lang.share + this.lang.requireContent, color: 'error'})
            }
            this.isSubmit = true
            await createTemplate(this.templateData).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                this.$router.push({name:'schoolStory.templateList'})
            }).catch(err=>{
                console.log(err.response)
                this.isSubmit = false
            })
        }
    }
}
</script>

<style>

</style>