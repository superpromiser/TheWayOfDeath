<template>
    <v-container>
        <v-container v-if="istemplateNew == true">
            <v-container class="z-index-2 mb-15 banner-custom">
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
                            color="green lighten-1"
                            class="mx-2"
                            :loading="isSubmit"
                            @click="submit"
                        >
                            {{lang.submit}}
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
            <div class="d-flex align-center text-center justify-center" v-if='templateList.length == 0'>
                {{lang.noData}}
            </div>
            <v-row v-else>
                <v-col cols="12" sm="12" md="6" lg="4" xl="3"  v-for="template in templateList" :key="template.id">
                    <v-card
                    class="mx-auto"
                    max-width="400"
                    >
                        <v-img
                            class="white--text align-end"
                            height="200px"
                            :src="baseUrl+template.imgUrl"
                        >
                            <v-card-title>{{template.temTitle}}</v-card-title>
                        </v-img>

                        <v-card-subtitle class="pb-0">
                            {{template.title}}
                        </v-card-subtitle>

                        <v-card-text class="text--primary">
                            <div>{{template.description}}</div>
                        </v-card-text>

                        <v-card-actions class="justify-end">
                            <v-btn
                                color="orange"
                                tile
                                dark
                                @click="selTemp(template.content)"
                            >
                                选择
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
                
                <!-- <div>
                    {{template}}
                </div>
            </div>
            <v-btn
                dark
                color="#49d29e"
                class="mr-8"
                @click="submit"
            >
                {{lang.submit}}
            </v-btn>
                </div> -->
            </v-row>
        </v-container>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-container>
</template>

<script>
import {getQuestionnaireTemp} from '~/api/questionnaire'
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        templateList:[],
        isLoading:false,
        lang,
        istemplateNew:false,
        baseUrl:window.Laravel.base_url,
        isSubmit:false,
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
        await getQuestionnaireTemp().then(res=>{
            //console.log(res.data)
            this.isLoading = false
            this.templateList = res.data
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
        selTemp(content){
            // //console.log(content)
            this.$router.push({name:'posts.questionnaire',query:{'tempData':content}})
        }
    }
}
</script>

<style>

</style>