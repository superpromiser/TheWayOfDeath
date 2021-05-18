<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3 pt-12" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="navToNew" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.questionnaire}}模板清单</p>
                <v-btn @click="submit" :loading="isSubmit" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row v-if="isLoading == true" class="ma-0 d-flex justify-center align-center py-16">
                <v-progress-circular
                    indeterminate
                    color="#7879ff"
                ></v-progress-circular>
            </v-row>
            <v-row v-else-if="noData == true" class="ma-0 d-flex justify-center align-center py-16">
                <v-chip class="ma-2" color="#7879ff" outlined pill >
                    {{lang.noData}}
                    <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-row>
            <v-row v-else class="ma-0">
                <v-col cols="12" v-for="tempData in templateList" :key="tempData.id">
                    <v-card class="mx-auto">
                        <v-card-text>
                            <p class="display-1 text--primary">
                                {{tempData.tempTitle}}
                            </p>
                            <div class="text--primary">
                                {{tempData.description}}
                            </div>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="#7879ff" @click="selTemp(tempData)" >
                                选项
                            </v-btn>
                            <v-btn text color="#f19861" @click="delTemp(tempData)" >
                                删除
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
    <v-container v-else class="pa-0">
        <v-container class="pa-0" v-if="istemplateNew == true">
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
                        <h2>{{lang.questionnaire}}模板清单</h2>
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
            <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </div>
            <v-row class="px-10" v-else>
                <v-col cols="4" sm="6" md="4" v-for="template in templateList" :key="template.id">
                    <v-card
                    class="mx-auto"
                    max-width="400"
                    >
                        <v-card-text>
                            <p class="display-1 text--primary">
                                {{template.tempTitle}}
                            </p>
                            <div class="text--primary">
                                {{template.description}}
                            </div>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn
                                text
                                color="#7879ff"
                                @click="selTemp(template)"
                            >
                                选项
                            </v-btn>
                            <v-btn
                                text
                                color="#f19861"
                                @click="delTemp(template)"
                            >
                                删除
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-container>
</template>

<script>
import {getQuestionnaireTemp,deleteQuestionnaireTemp} from '~/api/questionnaire'
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        templateList:[],
        isLoading:false,
        lang,
        istemplateNew:false,
        baseUrl:window.Laravel.base_url,
        isSubmit:false,
        noData: false
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        this.isLoading = true;
        if(this.currentPath.name == 'questionnaire.templateList'){
            this.istemplateNew = true
        }
        await getQuestionnaireTemp({schoolId:this.currentPath.params.schoolId}).then(res=>{
            console.log(res.data)
            this.isLoading = false
            this.templateList = res.data
            if(this.templateList.length == 0){
                this.noData = true;
            }
        }).catch(err=>{
            this.isLoading = false
            //console.log(err.response)
        })
    },

    watch:{
        currentPath:{
            handler(val){
                if(val.name=="questionnaire.templateList"){
                    this.istemplateNew = true
                }
            },
            deep:true
        }
    },
    methods:{
        submit(){
            this.istemplateNew = false
            this.$router.push({name:'questionnaire.templateNew'})
        },
        selTemp(tempData){
            // //console.log(content)
            // his.$router.push({name:'posts.share',query:{tempData:JSON.stringify(tempData.content)}})
            this.$router.push({name:'posts.questionnaire',query:{tempData:JSON.stringify(tempData.content)}})
        },
        delTemp(tempData){
            deleteQuestionnaireTemp({id:tempData.id}).then(res=>{
                console.log(res.data)
                let index = this.templateList.indexOf(tempData)
                if(index > -1){
                    this.templateList.splice(index,1)
                }
                if(this.templateList.length == 0){
                    this.noData = true;
                }
                // this.$router.path({name:'posts.questionnaire'})
            }).catch(err=>{
                console.log(err.response)
            })    
        },

        navToNew(){
            this.$router.go(-1)
        }
    }
}
</script>

<style>

</style>