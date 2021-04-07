<template>
    <v-container v-if="$isMobile()"> 
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/icon/相册.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">相册</h2>
            </v-col>
            <v-col cols="12" class="d-flex justify-center mo-glow-inverse mt-5">
                <div class="w-90 mo-glow">
                    <img :src="`${baseUrl}/asset/img/class/3.png`" alt="classImage" class="class-img-mo" />
                </div>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="6" md="3" lg="4">
                <img src="" alt="">
            </v-col>
        </v-row>
    </v-container>
    <v-container class="pa-0 " v-else> 
        <v-row class="d-flex justify-center pt-10  ma-0">
            <v-col cols="12 d-flex justify-center position-relative">
                <h2 class="red--text text--lighten-1 position-absolute" style="top:0; font-size: 3rem;">相册</h2>
                <img :src="`${baseUrl}/asset/img/icon/header-red-ribbon.png`" alt="ribbon" class="class-ribbon-img" />
                <h2 class="position-absolute white--text" style="bottom:55px">classname</h2>
            </v-col>
        </v-row>
        <v-row class="d-flex justify-center ma-0">
            <v-col cols="12" class="d-flex justify-center">
                <img :src="`${baseUrl}/asset/img/class/3.png`" alt="classImage" class="class-img" />
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="6" md="3" lg="4">
                <img src="" alt="">
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {getClassPhoto} from '~/api/photo'
export default {
    middleware:['post','auth'],
    data: ()=> ({
        baseUrl: window.Laravel.base_url,
        imgUrl:[],
    }),

    computed:{
        currentPath(){
            return this.$route
        }
    },

    created(){
        getClassPhoto(this.currentPath.params.lessonId).then(res=>{
            console.log('getphoto',res.data)
            let tempData = [];
            // res.data.map(post=>{
            //     switch(post.contentId){
            //         case 19:
            //             tempData.push(post.recognitions.imgUrl);
            //             break;
            //         case 18:
            //             tempData.push(post.evaluations.selMedalList);
            //             break;
            //         case 17:
            //             tempData.push(JSON.parse(post.notifications.description));
            //             break;
            //         case 16:
            //             tempData.push(JSON.parse(post.home_visit.content))
            //             break;
            //         case 13:
            //             tempData.push(JSON.parse(post.votings.content))
            //             break;
            //         case 12:
            //             tempData.push(JSON.parse(post.questionnaires.content))
            //             break;
            //         default:
            //             break
            //     }
            // })
            // //console.log('tempData',tempData)
        }).catch(err=>{
            //console.log(err.response)
        })
    },

    methods:{

    }

}
</script>

<style>

</style>