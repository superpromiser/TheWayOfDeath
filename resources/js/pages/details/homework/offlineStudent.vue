<template>
    <v-container>
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
                    <h2>{{contentData.homework.homeworkType}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <!-- <v-btn
                        dark
                        tile
                        color="#F19861"
                        @click="viewDetail"
                    >
                        查看详情
                    </v-btn> -->
                </v-col>
            </v-row>
        </v-container>
        <v-row>
            <v-col class="d-flex justify-space-between align-center" cols="12" v-if="user != null">
                <p class="pl-2">
                </p>
                <v-rating
                    half-increments
                    hover
                    background-color="orange lighten-3"
                    color="orange"
                    length="5"
                    size="50"
                    value="0"
                    v-model="user.rating"
                    readonly
                ></v-rating>
            </v-col>
            <v-col class="d-flex align-center justify-center category mt-15" v-else>
                没有数据
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {getOfflineStudent} from '~/api/homeworkResult'
export default {
    props:{
        contentData:{
            type:Object,
            required:true,
        }
    },
    data:()=>({
        user:null,
    }),
    async created(){
        console.log('=======',this.contentData)
        await getOfflineStudent({postId:this.contentData.id}).then(res=>{
            console.log("res.data",res.data)
            if(res.data != ''){
                this.user = res.data
            }
            console.log(typeof this.user)     
        }).catch(err=>{
            console.log(err.response)
        })
    }
}
</script>

<style>

</style>