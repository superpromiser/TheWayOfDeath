<template>
    <v-container class="pa-0">
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
                    <h2>{{lang.voting}}模板清单</h2>
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
        
        <div v-if="noData == true" class="d-flex justify-center align-center py-16">
            <v-chip class="ma-2" color="#7879ff" outlined pill >
                {{lang.noData}}
                <v-icon right> mdi-cancel  </v-icon>
            </v-chip>
        </div>
        <div v-else-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="#7879ff"
            ></v-progress-circular>
        </div>
        <v-row v-else class="px-10">
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
                        <v-spacer></v-spacer>
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
</template>

<script>
import lang from '~/helper/lang.json'
import {getTemplateList,deleteTemplate} from '~/api/voting'
export default {
    middleware:'auth',
    data:()=>({
        lang,
        templateList:[],
        isLoading:false,
        baseUrl:window.Laravel.base_url,
        isSubmit:false,
        noData: false,
    }),
    
    computed:{
        currentPath(){
            return this.$route
        }
    },

    async created(){
        this.isLoading = true
        await getTemplateList({schoolId:this.currentPath.params.schoolId}).then(res=>{
            this.templateList = res.data
            if(this.templateList.length == 0){
                this.noData = true;
            }
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
        })
    },
    methods:{
        selTemp(tempData){
            this.$router.push({name:'posts.voting',query:{tempData:JSON.stringify(tempData.content)}})
        },
        submit(){
            this.$router.push({name:'voting.newTemp'})
        },
        delTemp(tempData){
            deleteTemplate ({id:tempData.id}).then(res=>{
                let index = this.templateList.indexOf(tempData)
                if(index > -1){
                    this.templateList.splice(index,1)
                }
                if(this.templateList.length == 0){
                    this.noData = true;
                }
            }).catch(err=>{
                console.log(err.response)
            })
        }
    }
}
</script>

<style>

</style>