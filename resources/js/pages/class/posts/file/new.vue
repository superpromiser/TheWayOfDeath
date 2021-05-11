<template>
    <v-container class="pa-0 "> 
        <v-row v-if="$isMobile()">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="mo-glow-small-shadow" >
                    <v-img :src="`${baseUrl}/asset/img/appIcon/工具/相册.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">文件</h2>
            </v-col>
        </v-row>
        <v-row v-else class="d-flex justify-center pt-10  ma-0">
            <v-col cols="12 d-flex justify-center position-relative">
                <h2 class="red--text text--lighten-1 position-absolute" style="top:0; font-size: 3rem;">文件</h2>
                <img :src="`${baseUrl}/asset/img/icon/header-red-ribbon.png`" alt="ribbon" class="class-ribbon-img" />
                <h2 class="position-absolute white--text" style="bottom:55px">{{className}}</h2>
            </v-col>
        </v-row>
        
        <!--video--->
        <v-row class="ma-0">
            <v-col cols="12">
                <v-chip
                    class="ma-2 px-5"
                    color="primary"
                    outlined
                >
                    影片档案
                    <v-icon right>
                        mdi-file-video 
                    </v-icon>
                </v-chip>
            </v-col>
            <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-col>
            <v-col v-else-if="noVideo" cols="12" class="d-flex justify-center align-center">
                <v-chip class="ma-2" color="#F19861" outlined pill >
                    没有视频数据
                    <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-else v-for="(video, index) in videoDataList" :key="index" cols="12" sm="6" md="4" lg="3" class="position-relative px-1">
                <v-card
                    class="d-flex align-center "
                    color="blue lighten-4"
                    flat
                    tile
                    v-if="$isMobile()"
                >
                    <img :src="`${baseUrl}/asset/img/upload_video_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="font-size-0-75">
                        <div><span><strong>{{video.fileOriName}}</strong></span></div>
                        <div>{{video.fileSize}}</div>
                    </div>
                    <div class="ml-auto mr-2">
                        <v-btn icon color="blue darken-1" @click="openVideoViewDialog(index, video)" >
                            <v-icon size="25" >mdi-eye </v-icon>
                        </v-btn>
                    </div>
                    
                </v-card>
                <v-card
                    class="d-flex align-center "
                    color="blue lighten-4"
                    flat
                    tile
                    v-else
                >
                    <img :src="`${baseUrl}/asset/img/upload_video_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="">
                        <div><span><strong>{{video.fileOriName}}</strong></span></div>
                        <div>{{video.fileSize}}</div>
                    </div>
                    <div class="ml-auto mr-2">
                        <v-btn icon color="blue darken-1" @click="openVideoViewDialog(index, video)" >
                            <v-icon size="30" >mdi-eye </v-icon>
                        </v-btn>
                    </div>
                    
                </v-card>
            </v-col>
        </v-row >
        <v-dialog persistent v-model="videoViewDialog" width="100%" max-width="1000">
            <v-card>
                <v-card-title class="title">
                {{selectedViedoName}}
                </v-card-title>
                <v-card-text class="px-0">
                    <video-player  
                        class="video-player-box vjs-custom-skin w-100"
                        ref="videoPlayer"
                        :options="playerOptionsGroup[selectedVideoIndex]"
                        :playsinline="true"
                        >
                    </video-player>
                </v-card-text>
                
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    text
                    color="primary"
                    @click="videoViewDialog = false"
                >
                    {{lang.ok}}
                </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!--file--->
        <v-row class="ma-0 mb-16">
            <v-col cols="12">
                <v-chip
                    class="ma-2 px-5"
                    color="primary"
                    outlined
                >
                    文件
                    <v-icon right>
                        mdi-file 
                    </v-icon>
                </v-chip>
            </v-col>
            <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-col>
            <v-col v-else-if="noFile" cols="12" class="d-flex justify-center align-center">
                <v-chip class="ma-2" color="#F19861" outlined pill >
                    没有文件数据
                    <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-else v-for="(other, index) in fileDataList" :key="index" cols="12" sm="6" md="4" lg="3" class="position-relative px-1">
                <v-card
                    class="d-flex align-center "
                    color="blue lighten-4"
                    flat
                    tile
                    v-if="$isMobile()"
                >
                    <img :src="`${baseUrl}/asset/img/upload_file_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="font-size-0-75">
                        <div><span><strong>{{other.fileOriName}}</strong></span></div>
                        <div>{{other.fileSize}}</div>
                    </div>
                    <div class="ml-auto mr-2">
                        <a class="file-box" :href="other.imgUrl" :download="other.fileOriName">
                            <v-btn icon color="blue darken-1" >
                                <v-icon size="25" >mdi-download-circle-outline </v-icon>
                            </v-btn>
                        </a>
                    </div>
                </v-card>
                <v-card
                    class="d-flex align-center "
                    color="blue lighten-4"
                    flat
                    tile
                    v-else
                >
                    <img :src="`${baseUrl}/asset/img/upload_file_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="">
                        <div><span><strong>{{other.fileOriName}}</strong></span></div>
                        <div>{{other.fileSize}}</div>
                    </div>
                    <div class="ml-auto mr-2">
                        <a class="file-box" :href="other.imgUrl" :download="other.fileOriName">
                            <v-btn icon color="blue darken-1" >
                                <v-icon size="30" >mdi-download-circle-outline </v-icon>
                            </v-btn>
                        </a>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import {getClassFile} from '~/api/photo'
import lang from '~/helper/lang.json'

export default {
    data: ()=> ({
        lang,
        videoViewDialog: false,
        baseUrl: window.Laravel.base_url,
        className: '',
        fileDataList: [],
        videoDataList: [],
        noFile: false,
        noVideo: false,
        isLoading: false,
        playerOptionsGroup:[],
        playerOptions: {
            // videojs options
            height:'650',
            muted: true,
            language: 'en',
            playbackRates: [0.7, 1.0, 1.5, 2.0],
            sources: [{
                type: "video/mp4",
                src: "https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm"
            }],
        },
        selectedVideoIndex: -1,
        selectedViedoName: "",
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            schoolData: 'schooltree/schoolData',
            user: 'auth/user',
            
        })
    },

    async created(){
        this.schoolData[0].grades.map(grade=>{
            grade.lessons.map(lesson=>{
                if(lesson.id == this.currentPath.params.lessonId){
                    this.className = lesson.lessonName;
                }
            })
        })
        this.isLoading = true;
        await getClassFile(this.currentPath.params.lessonId)
        .then((res) => {
            this.fileDataList = res.data.fileData;
            this.videoDataList = res.data.videoData;
            if(this.fileDataList.length == 0){
                this.noFile = true;
            }
            if(this.videoDataList.length == 0){
                this.noVideo = true;
            }
            else{
                for(let i = 0; i < this.videoDataList.length ; i++){
                    let clonedOption = JSON.parse(JSON.stringify(this.playerOptions));
                    clonedOption.sources[0].src = this.baseUrl + '/uploads/video/'+this.videoDataList[i].fileName;
                    this.playerOptionsGroup.push(clonedOption);
                }
            }
        }).catch((err) => {
            
        });
        this.isLoading = false;
    },
    methods:{
        openVideoViewDialog(index, video){
            this.selectedVideoIndex = index;
            this.selectedViedoName = video.fileOriName
            this.videoViewDialog = true;
        }
    }

}
</script>

<style>

</style>