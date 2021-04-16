<template>
    <v-row class="bg-white ch-area-height ma-0 pa-0">
        <v-col cols="12" class="overflowY-auto h-100" v-chat-scroll="{always: false, smooth: true}" @v-chat-scroll-top-reached="reachedTop">
            <ChatMessage
                v-for="(message, index) in messages"
                :key="index"
                :message="message"
                :chatto="chatto"
                :chatin="chatin"
                :chatfrom="chatfrom"
                @mapInfoToParent="passMapDataFromChild"
                @videoInfoToParent="passVideoDataFromChild"
            />
        </v-col>
        <v-dialog v-model="videoViewDialog" width="100%" max-width="1000">
            <v-card>
                <v-card-text class="px-0">
                    <video-player  
                        class="video-player-box vjs-custom-skin w-100"
                        ref="videoPlayer"
                        :options="playerOptions"
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
</template>

<script>

import { videoPlayer } from 'vue-video-player';
import ChatMessage from './chatmessage';
import lang from '~/helper/lang.json';
export default {
    components:{
        ChatMessage,
        videoPlayer,
    },  
    props:{
        chatto:{
            type:Number,
            required:false
        },
        chatfrom:{
            type:Number,
            required:true
        },
        chatin:{
            type:Number,
            required:false
        },
        messages:{
            type:Array,
            required:true
        }
    },

    data: ()=> ({
        lang,
        isReachedTop : false,
        selectedViedoName: '',
        videoViewDialog: false,
        baseUrl:window.Laravel.base_url,
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
    }),

    computed:{
        player() {
            return this.$refs.videoPlayer.player
        },
    },

    methods:{
        syncCenterAndZoom(e){
            const {lng, lat} = e.target.getCenter()
            this.marker.lng = lng
            this.marker.lat = lat
        },
        

        closeSendMapModal(){
            this.viewLocationMapMessageModal = false;
            this.center.lng = null;
            this.center.lat = null;
            this.zoom = null;
        },

        passMapDataFromChild(value){
            this.center.lng = value.lng;
            this.center.lat = value.lat;
            // this.zoom = value.zoom;
            // this.syncCenterAndZoom()
            this.viewLocationMapMessageModal = true;
        },

        passVideoDataFromChild(value){
            this.playerOptions.sources[0].src = this.baseUrl + value.video;
            this.playerOptions.poster = this.baseUrl + "/asset/img/coverImage/chatVideoCoverImage.jpg";
            this.videoViewDialog = true;
        },

        reachedTop(){
            this.isReachedTop = true;
        }
        
    }
}
</script>

<style>

</style>