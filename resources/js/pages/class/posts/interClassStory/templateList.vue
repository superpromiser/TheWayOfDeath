<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3 pt-12" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="navToNew" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.interClassStory}}模板清单</p>
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
                <v-col cols="12" v-for="tempData in tempList" :key="tempData.id">
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
                    <h2>{{lang.interClassStory}}模板清单</h2>
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
        <v-row v-else class="px-10">
            <v-col cols="4" sm="6" md="4" v-for="tempData in tempList" :key="tempData.id">
                <v-card
                    class="mx-auto"
                    max-width="300"
                >
                    <v-card-text>
                        <p class="display-1 text--primary">
                            {{tempData.tempTitle}}
                        </p>
                        <div class="text--primary">
                            {{tempData.description}}
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            text
                            color="#7879ff"
                            @click="selTemp(tempData)"
                        >
                            选项
                        </v-btn>
                        <v-btn
                            text
                            color="#f19861"
                            @click="delTemp(tempData)"
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
import {getTemplateList,deleteTemplate} from '~/api/interClassStory'
export default {
    data:()=>({
        lang,
        isSubmit:false,
        tempList:[],
        isDelete:false,
        isLoading:false,
        noData: false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        // this.$router.push({name:'posts.share'})
        this.isLoading = true
        getTemplateList({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            this.tempList = res.data
            if(this.tempList.length == 0){
                this.noData = true;
            }
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
        })
    },
    methods:{
        submit(){
            console.log('submit')
            this.$router.push({name:'interClassStory.newTemplate'})
        },
        selTemp(tempData){
            this.$router.push({name:'posts.interClassStory',query:{tempData:JSON.stringify(tempData.content)}})
        },
        async delTemp(tempData){
            // console.log(tempData)
            // return
            this.isDelete = true
            await deleteTemplate({id:tempData.id}).then(res=>{
                console.log(res.data)
                this.isDelete = false
                let index = this.tempList.indexOf(tempData)
                if(index > -1){
                    this.tempList.splice(index,1)
                }
                if(this.tempList.length == 0){
                    this.noData = true;
                }
            }).catch(err=>{
                console.log(err.response)
                this.isDelete = false
            })
        },

        navToNew(){
            this.$router.push({name: 'posts.interClassStory'})
        }
    }
}
</script>

<style>

</style>