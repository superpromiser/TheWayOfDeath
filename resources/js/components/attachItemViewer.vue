<template>
    <v-container>
        <!--  IMAGE VIEWER  -->
        <!-- <v-row>
            <v-col v-for="(imgUrl, index) in items.imgUrl" :key="index" cols="6" sm="4" md="3" lg="2" class="position-relative images" v-viewer>
                <v-img :src="`${baseUrl}${imgUrl.path}`" alt="upload image" class="uploaded-image" ></v-img>
            </v-col>
        </v-row> -->
        <v-row v-viewer="options" class="images clearfix">
            <template v-for="img in items.imgUrl">
                <img :src="`${baseUrl}${img.path}`" :data-source="`${baseUrl}${img.path}`" class="image" :key="img.path" >
            </template>
        </v-row>
        <!--  VIDEO VIEWER  -->
        <v-row>
            <v-col v-for="(video, index) in items.videoUrl" :key="index" cols="12" sm="6" md="4" lg="3" class="position-relative px-1">
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
        </v-row>
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
        <!--  FILE VIEWER  -->
        <v-row>
            <v-col v-for="(other, index) in items.otherUrl" :key="index" cols="12" sm="6" md="4" lg="3" class="position-relative px-1">
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
import { videoPlayer } from 'vue-video-player'
import Viewer from 'v-viewer'
import lang from '~/helper/lang.json'
export default {
    components: {
        Viewer,
        videoPlayer,
    },
    props:{
        items:{
            type: Object,
            required: false,
        },
    },

    computed:{
        player() {
            return this.$refs.videoPlayer.player
        },
    },

    data: () => ({
        lang,
        videoViewDialog: false,
        baseUrl:window.Laravel.base_url,
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

    mounted(){
        for(let i = 0; i < this.items.videoUrl.length ; i++){
            let clonedOption = JSON.parse(JSON.stringify(this.playerOptions));
            clonedOption.sources[0].src = this.baseUrl + '/uploads/video/'+this.items.videoUrl[i].fileName;
            this.playerOptionsGroup.push(clonedOption);
        }
    },

    methods: {
        show () {
            const viewer = this.$el.querySelector('.images').$viewer
            viewer.show()
        },

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