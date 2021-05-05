
<template>
    <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
        <v-container class="pt-0 px-0 h-100 bg-white">
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.recognition}}</p>
            </v-row>
        </v-container>
        <v-container>
            <v-row class="justify-center">
                <v-col cols="12" sm="10" md="8">
                    <v-img :src="`${baseUrl}${recognitionData.imgUrl}`" >
                        <p class="recognition-title mb-0 position-absolute font-weight-bold" style="top:30%; left:50%; word-wrap: break-word; transform: translateX(-50%);">{{recognitionData.awardTitle}}</p>
                        <p class="recognition-desc mb-0 position-absolute" style="top:35%; left:5%; width: 90%; word-wrap: break-word; height:39%; overflow:hidden">{{recognitionData.description}}</p>
                        <p class="recognition-date mb-0 position-absolute" style="bottom:10%; right:5%; word-wrap: break-word;">{{recognitionData.publishDate}}</p>
                        <p class="recognition-user mb-0 position-absolute" style="top:25%; left:5%; width: 90%; word-wrap: break-word;"><span class="mr-2" v-for="student in recognitionData.students" :key="student.id">{{student.name}}</span></p>
                    </v-img>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
    <v-container class="pa-0" v-else>
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
                    <h2>{{lang.recognition}}</h2>
                </v-col>
            </v-row>
        </v-container>
        <v-container>
            <v-row class="justify-center">
                <v-col cols="12" sm="10" md="8">
                    <v-img :src="`${baseUrl}${recognitionData.imgUrl}`" >
                        <p class="recognition-title mb-0 position-absolute font-weight-bold" style="top:30%; left:50%; word-wrap: break-word; transform: translateX(-50%);">{{recognitionData.awardTitle}}</p>
                        <p class="recognition-desc mb-0 position-absolute" style="top:35%; left:5%; width: 90%; word-wrap: break-word; height:39%; overflow:hidden">{{recognitionData.description}}</p>
                        <p class="recognition-date mb-0 position-absolute" style="bottom:10%; right:5%; word-wrap: break-word;">{{recognitionData.publishDate}}</p>
                        <p class="recognition-user mb-0 position-absolute" style="top:25%; left:5%; width: 90%; word-wrap: break-word;"><span class="mr-2" v-for="student in recognitionData.students" :key="student.id">{{student.name}}</span></p>
                    </v-img>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>


<script>
import {mapGetters} from 'vuex';
import lang from '~/helper/lang.json';
export default {
    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        recognitionData:{},
    }),

    computed:{
        ...mapGetters({
            contentData:'content/postDetail'
        }),
        currentpath(){
            return this.$route;
        },
    },

    created(){
        if(this.contentData == null){
            if(this.currentpath.params.lessonId){
                return this.$router.push({name:'classSpace.news'})
            }else{
                return this.$router.push({name:'schoolSpace.news'})
            }
        }
        
        this.recognitionData = this.contentData.recognitions;
        this.recognitionData.students = JSON.parse(this.recognitionData.students);
        console.log("this.recognitionData", this.recognitionData);
    },

    methods:{
        
    }
}
</script>

<style>

</style>