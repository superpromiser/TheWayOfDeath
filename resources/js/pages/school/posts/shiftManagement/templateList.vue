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
                    <h2>{{lang.announcement}}模板清单</h2>
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
                color="#7879ff"
            ></v-progress-circular>
        </div>
        <v-row v-else>
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
import {getTemplateList,deleteTemplate} from '~/api/shiftMng'
export default {
    data:()=>({
        lang,
        isSubmit:false,
        tempList:[],
        isDelete:false,
        isLoading:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        // this.$router.push({name:'posts.share'})
        this.isLoading = true
        getTemplateList({schoolId:this.currentPath.params.schoolId}).then(res=>{
            console.log(res.data)
            this.tempList = res.data
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
        })
    },
    methods:{
        submit(){
            this.$router.push({name:'shift.newTemplate'})
        },
        selTemp(tempData){
            // console.log("-=-=--==-=-=-=-",tempData)
            // return
            this.$router.push({name:'posts.shift',query:{tempData:JSON.stringify(tempData.content)}})
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
            }).catch(err=>{
                console.log(err.response)
                this.isDelete = false
            })
        }
    }
}
</script>

<style>

</style>