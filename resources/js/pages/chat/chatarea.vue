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
    </v-row>
</template>

<script>
import ChatMessage from './chatmessage'
export default {
    components:{
        ChatMessage,
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
        isReachedTop : false,
    }),

    computed:{
        // player() {
        //     return this.$refs.videoPlayer.player
        // },
    },

    methods:{
        syncCenterAndZoom(e){
            const {lng, lat} = e.target.getCenter()
            this.marker.lng = lng
            this.marker.lat = lat
        },
        //video play method
        // listen event
        onPlayerPlay(player) {
            // console.log('player play!', player)
        },
        onPlayerPause(player) {
            // console.log('player pause!', player)
        },
        onPlayerEnded(player) {
            // console.log('player ended!', player)
        },
        onPlayerLoadeddata(player) {
            // console.log('player Loadeddata!', player)
        },
        onPlayerWaiting(player) {
            // console.log('player Waiting!', player)
        },
        onPlayerPlaying(player) {
            // console.log('player Playing!', player)
        },
        onPlayerTimeupdate(player) {
            // console.log('player Timeupdate!', player.currentTime())
        },
        onPlayerCanplay(player) {
            // console.log('player Canplay!', player)
        },
        onPlayerCanplaythrough(player) {
            // console.log('player Canplaythrough!', player)
        },
        // or listen state event
        playerStateChanged(playerCurrentState) {
            // console.log('player current update state', playerCurrentState)
        },
        // player is ready
        playerReadied(player) {
            // seek to 10s
            // console.log('example player 1 readied', player)
            player.currentTime(10)
            // console.log('example 01: the player is readied', player)
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
            console.log("VideoInfoFromChild", value);
            this.playMsgSentVideoModal = true;
            // this.playerOptions.sources[0].src = "http://127.0.0.1:8000" + value.video;
            this.playerOptions.sources[0].src = "http://8.131.231.180" + value.video;
            this.playerOptions.poster = "/img/coverImage/chatVideoCoverImage.jpg";
        },

        reachedTop(){
            this.isReachedTop = true;
            console.log("sss");
        }
        
    }
}
</script>

<style>

</style>