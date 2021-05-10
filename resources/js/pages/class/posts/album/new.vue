<template>
    <v-container class="mb-16" v-if="$isMobile()"> 
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/appIcon/工具/相册.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">相册</h2>
            </v-col>
            <v-col cols="12" class="d-flex justify-center mo-glow-inverse mt-5">
                <div class="w-90 mo-glow">
                    <img :src="`${baseUrl}${classImage}`" alt="classImage" class="class-img-mo" />
                </div>
            </v-col>
        </v-row>
        <v-row v-if="isLoading" class="justify-center">
            <v-progress-circular
                indeterminate
                color="primary"
            ></v-progress-circular>
        </v-row>
        <v-row v-else-if="imgUrlList.length == 0" class="justify-center">
            <v-chip class="ma-2" color="#F19861" outlined pill >
                没有照片数据
                <v-icon right> mdi-cancel  </v-icon>
            </v-chip>
        </v-row>
        <v-row v-else class="justify-center">
            <v-col cols="12" sm="6" md="3" lg="2" v-for="(imgUrl, i) in imgUrlList" :key="i">
                <v-img :src="`${baseUrl}${imgUrl}`" >
                </v-img>
            </v-col>
        </v-row>
    </v-container>
    <v-container class="pa-0 mb-16" v-else> 
        <v-row class="d-flex justify-center pt-10  ma-0">
            <v-col cols="12 d-flex justify-center position-relative">
                <h2 class="red--text text--lighten-1 position-absolute" style="top:0; font-size: 3rem;">相册</h2>
                <img :src="`${baseUrl}/asset/img/icon/header-red-ribbon.png`" alt="ribbon" class="class-ribbon-img" />
                <h2 class="position-absolute white--text" style="bottom:55px">{{className}}</h2>
            </v-col>
        </v-row>
        <v-row class="d-flex justify-center ma-0">
            <v-col cols="12" class="d-flex justify-center">
                <img :src="`${baseUrl}${classImage}`" alt="classImage" class="class-img" />
            </v-col>
        </v-row>
        <v-row v-if="isLoading" class="justify-center">
            <v-progress-circular
                indeterminate
                color="primary"
            ></v-progress-circular>
        </v-row>
        <v-row v-else-if="imgUrlList.length == 0" class="justify-center">
            <v-chip class="ma-2" color="#F19861" outlined pill >
                暂无
                <v-icon right> mdi-cancel  </v-icon>
            </v-chip>
        </v-row>
        <v-row v-else v-viewer="options" class="images clearfix ma-0">
            <template v-for="img in imgUrlList">
                <img :src="`${baseUrl}${img}`" :data-source="`${baseUrl}${img}`" class="image" :key="img" >
            </template>
        </v-row>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import {getClassPhoto} from '~/api/photo'
import Viewer from 'v-viewer'
export default {
    components: {
        Viewer,
    },
    middleware:['post','auth'],
    data: ()=> ({
        baseUrl: window.Laravel.base_url,
        imgUrlList:[],
        isLoading: false,
        className: '',
        classImage: '',
        options: {
            toolbar: true,
            url: 'data-source'
        },
    }),

    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            schoolData : 'schooltree/schoolData',
            user : 'auth/user',
        })
    },

    async created(){
        this.schoolData[0].grades.map(grade=>{
            grade.lessons.map(lesson=>{
                if(lesson.id == this.currentPath.params.lessonId){
                    this.className = lesson.lessonName;
                    this.classImage = lesson.imgUrl;
                }
            })
        })

        this.isLoading = true;
        await getClassPhoto(this.currentPath.params.lessonId).then(res=>{
            console.log('getphoto',res.data)
            this.imgUrlList = res.data
        }).catch(err=>{
            //console.log(err.response)
        })
        this.isLoading = false;
    },

    methods:{
        // show () {
        //     const viewer = this.$el.querySelector('.images').$viewer
        //     viewer.show()
        // },
    }

}
</script>

<style lang="scss" rel="stylesheet/scss" scoped>
  .image {
    width: calc(20% - 10px);
    cursor: pointer;
    margin: 5px;
    display: inline-block;
    max-height: 280px;
  }
</style>