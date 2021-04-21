<template>
    <v-container>
        <!--- my image file --->
        <v-row>
            <v-col cols="12">
                <v-chip class="ma-2 px-5" color="primary" outlined >
                    我的图片文件
                    <v-icon right> mdi-file-image  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-col>
            <v-col v-else-if="noImageFile" cols="12" class="d-flex justify-center align-center">
                <v-chip class="ma-2" color="#F19861" outlined pill >
                    我的图片文件没有数据
                    <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-col>
            <v-col cols="12" v-else v-viewer="options" class="images clearfix ma-0">
                <template v-for="img in imageFileList">
                    <img :src="`${baseUrl}${img}`" :data-source="`${baseUrl}${img}`" class="image" :key="img" >
                </template>
            </v-col>
        </v-row>
        <!--- my video file --->
        <v-row>
            <v-col cols="12">
                <v-chip class="ma-2 px-5" color="primary" outlined >
                    我的视频文件数据
                    <v-icon right> mdi-file-video  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-col>
            <v-col v-else-if="noImageFile" cols="12" class="d-flex justify-center align-center">
                <v-chip class="ma-2" color="#F19861" outlined pill >
                    我的视频文件没有数据
                    <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-else v-for="(video, index) in videoFileList" :key="index" cols="12" sm="6" md="4" lg="3" class="position-relative px-1">
                <v-card class="d-flex align-center " color="blue lighten-4" flat tile >
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
            <v-dialog v-model="videoViewDialog" width="100%" max-width="1000">
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
        </v-row>
        <!--- my other file --->
        <v-row class="ma-0 mb-16">
            <v-col cols="12">
                <v-chip class="ma-2 px-5" color="primary" outlined >
                    我的文件
                    <v-icon right> mdi-file  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-col>
            <v-col v-else-if="noOtherFile" cols="12" class="d-flex justify-center align-center">
                <v-chip class="ma-2" color="#F19861" outlined pill >
                    没有我的文件数据
                    <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-else v-for="(other, index) in otherFileList" :key="index" cols="12" sm="6" md="4" lg="3" class="position-relative px-1">
                <v-card class="d-flex align-center " color="blue lighten-4" flat tile >
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
import {getMyFile} from '~/api/user';
import lang from '~/helper/lang.json'
export default {
    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        videoViewDialog: false,
        imageFileList: [],
        videoFileList: [],
        otherFileList: [],
        isLoading: false,
        noImageFile: false,
        noVideoFile: false,
        noOtherFile: false,
        options: {
            toolbar: true,
            url: 'data-source'
        },
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

    async created(){
        this.isLoading = true;
        await getMyFile()
        .then((res) => {
            console.log(res);
            this.imageFileList = res.data.imageFileList
            this.videoFileList = res.data.videoFileList
            this.otherFileList = res.data.otherFileList
            if(this.imageFileList.length == 0){
                this.noImageFile = true;
            }
            if(this.otherFileList.length == 0){
                this.noOtherFile = true;
            }
            if(this.videoFileList.length == 0){
                this.noVideoFile = true;
            }
            else if(this.videoFileList.length > 0){
                for(let i = 0; i < this.videoFileList.length ; i++){
                    let clonedOption = JSON.parse(JSON.stringify(this.playerOptions));
                    clonedOption.sources[0].src = this.baseUrl + '/uploads/video/'+this.videoFileList[i].fileName;
                    this.playerOptionsGroup.push(clonedOption);
                }
                console.log("this.playerOptionsGroup", this.playerOptionsGroup);
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

<style lang="scss" rel="stylesheet/scss" scoped>
  .image {
    width: calc(20% - 10px);
    cursor: pointer;
    margin: 5px;
    display: inline-block;
    max-height: 280px;
  }
</style>