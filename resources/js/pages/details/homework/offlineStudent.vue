<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white mb-16 pb-10-px pt-12">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{contentData.homework.homeworkType}}</p>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0">
                <v-col class="d-flex justify-center align-center" cols="12" v-if="user != null">
                    <v-rating
                        half-increments
                        hover
                        background-color="orange lighten-3"
                        color="orange"
                        length="5"
                        size="30"
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
    </v-container>
    <v-container v-else class="pa-0">
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
        <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="primary"
            ></v-progress-circular>
        </div>
        <v-row v-else>
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
        isLoading:false
    }),
    async created(){
        this.isLoading = true
        await getOfflineStudent({postId:this.contentData.id}).then(res=>{
            if(res.data != ''){
                this.user = res.data
            }
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
        })
    }
}
</script>

<style>

</style>