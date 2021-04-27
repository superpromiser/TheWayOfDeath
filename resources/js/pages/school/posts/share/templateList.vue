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
                    <h2>{{lang.share}}模板清单</h2>
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
        <v-row class="px-5">
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
                            Learn More
                        </v-btn>
                        <v-btn
                            text
                            color="#f19861"
                            @click="delTemp(tempData)"
                        >
                            Learn More
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {getTempList,deleteTemp} from '~/api/share'
export default {
    data:()=>({
        lang,
        isSubmit:false,
        tempList:[],
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        // this.$router.push({name:'posts.share'})
        getTempList({schoolId:this.currentPath.params.schoolId}).then(res=>{
            console.log(res.data)
            this.tempList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        submit(){
            console.log('submit')
            this.$router.push({name:'share.newTemplate'})
        },
        selTemp(tempData){
            this.$router.push({name:'posts.share',query:{tempData:JSON.stringify(tempData.content)}})
        },
        delTemp(){

        }
    }
}
</script>

<style>

</style>