<template>
    <div>
        <div v-if="message.text !== null && message.text !== undefined">
            <div v-if="checkIfCreateRoomInfo(message)" class="text-center pa-3 mo-glow-inverse">
                <p class="pt-5"><strong style="font-size: 25px">{{message.text.createdUser}}</strong>在{{TimeViewHMS(message.created_at)}}创建了一个称为{{message.text.roomName}}的房间</p>
                <p class="">
                    受邀的人:&nbsp;&nbsp;
                    <span 
                        v-for="(userName, i) in message.text.invitedUser" 
                        :key="'A'+ i"
                    >
                        <strong>{{userName}}</strong> &nbsp;&nbsp;
                    </span>
                </p>
            </div>

            <div v-else-if="chatfrom === message.from.id" class="d-flex justify-end mb-4 position-relative">
                <div class="msg-container-send-mo mo-glow-inverse">
                    <p v-html="detectUrl(message.text)" class="messagebox_p"></p>
                </div>
                <div class="ch-time-mo">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="ch-user-avatar-sender-mo">
                    <!-- <avatar :size="30" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
            </div>

            <div v-else class="d-flex justify-start mb-4 position-relative">
                <div class="ch-user-avatar-mo">
                    <!-- <avatar :size="40" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
                <div class="ch-name-and-time-mo d-flex">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="msg-container-mo">
                    <p v-html="detectUrl(message.text)" class="messagebox_p"></p>
                </div>
            </div>

        </div>
        <div v-else-if="message.image !== null && message.image !== undefined">
            <div v-if="chatfrom === message.from.id" class="d-flex justify-end mb-4 position-relative">
                <div class="msg-container-send-mo pa-1 mo-glow-inverse">
                    <div class="msg-image-container-send-mo d-flex align-center" v-viewer>
                        <img :src="message.image" alt="" @click="showSendImage">
                    </div>
                </div>
                <div class="ch-time-mo">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="ch-user-avatar-sender-mo">
                    <!-- <avatar :size="30" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
            </div>

            <div v-else class="d-flex justify-start mb-4 position-relative">
                <div class="ch-user-avatar-mo">
                    <!-- <avatar :size="40" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
                <div class="ch-name-and-time-mo d-flex">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="msg-container-mo pa-1">
                    <div class="msg-image-container-mo d-flex align-center" v-viewer>
                        <img :src="message.image" alt="" @click="showReceiveImage">
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="message.video !== null && message.video !== undefined">
            <div v-if="chatfrom === message.from.id" class="d-flex justify-end mb-4 position-relative">
                <div class="msg-container-send-mo pa-1 mo-glow-inverse">
                    <div class="msg-video-container-send-mo position-relative d-flex align-center">
                        <img :src="`${baseUrl}/asset/img/coverImage/chatVideoCoverImage.jpg`" alt="">
                        <v-icon @click="sendVideoInfoToParent(message)" class="msg-video-play-icon" size="43" color="#2D8CF0"  type="logo-youtube">
                            mdi-play-circle 
                        </v-icon>
                    </div>
                </div>
                <div class="ch-time-mo">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="ch-user-avatar-sender-mo">
                    <!-- <avatar :size="30" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
            </div>

            <div v-else class="d-flex justify-start mb-4 position-relative">
                <div class="ch-user-avatar-mo">
                    <!-- <avatar :size="40" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
                <div class="ch-name-and-time-mo d-flex">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="msg-container-mo pa-1">
                    <div class="msg-video-container-mo position-relative d-flex align-center">
                        <img :src="`${baseUrl}/asset/img/coverImage/chatVideoCoverImage.jpg`" alt="">
                        <v-icon @click="sendVideoInfoToParent(message)" class="msg-video-play-icon" size="43" color="#2D8CF0"  type="logo-youtube">
                            mdi-play-circle 
                        </v-icon>
                    </div>
                </div>
            </div>
            
        </div>
        <div v-else-if="message.voice !== null && message.voice !== undefined">
            <div v-if="chatfrom === message.from.id" class="d-flex justify-end mb-4 position-relative">
                <div class="msg-container-send-mo msg-voice-send mo-glow-inverse">
                    <audio  :src="message.voice" controls />
                </div>
                <div class="ch-time-mo">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="ch-user-avatar-sender-mo">
                    <!-- <avatar :size="30" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
            </div>

            <div v-else class="d-flex justify-start mb-4 position-relative">
                <div class="ch-user-avatar-mo">
                    <!-- <avatar :size="40" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
                <div class="ch-name-and-time-mo d-flex">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="msg-container-mo msg-voice">
                    <audio  :src="message.voice" controls />
                </div>
            </div>
        </div>
        <div v-else-if="message.file !== null && message.file !== undefined">
            <div v-if="chatfrom === message.from.id" class="d-flex justify-end mb-4 position-relative">
                <div class="msg-container-send-mo mo-glow-inverse">
                    <div class="msg-file-container d-flex">
                        <v-icon size="22" color="white" >mdi-file-outline</v-icon>
                        <p class="mb-0"><strong>{{message.file.name}}</strong></p>
                    </div>
                    <p class="mb-0 font-size-0-75">{{message.file.size}} bytes</p>
                    <a class="msg-file-download-ico-send-a" :href="message.file.path" :download="message.file.name">
                        <v-icon size="25" class="msg-file-download-ico msg-file-download-ico-send" color="#7879ff">
                            mdi-download
                        </v-icon>
                    </a>
                </div>
                <div class="ch-time-mo">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="ch-user-avatar-sender-mo">
                    <!-- <avatar :size="30" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
            </div>

            <div v-else class="d-flex justify-start mb-4 position-relative">
                <div class="ch-user-avatar-mo">
                    <!-- <avatar :size="40" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
                <div class="ch-name-and-time-mo d-flex">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="msg-container-mo">
                    <div class="msg-file-container d-flex">
                        <v-icon size="22" color="#757575">mdi-file-outline</v-icon>
                        <p class="mb-0"><strong>{{message.file.name}}</strong></p>
                    </div>
                    <p class="mb-0 font-size-0-75">{{message.file.size}} bytes</p>
                    <a class="msg-file-download-ico-a" :href="message.file.path" :download="message.file.name">
                        <v-icon size="25" class="msg-file-download-ico" color="#7879ff">
                            mdi-download
                        </v-icon>
                    </a>
                </div>
                
            </div>
            


        </div>
        <div v-else-if="message.map !== null && message.map !== undefined">
            <div v-if="chatfrom === message.from.id" class="d-flex justify-end mb-4 position-relative">
                <div class="msg-container-send-mo mo-glow-inverse">
                    <Icon @click="sendLocationInfoToParent(message.map)" type="md-eye" size="25" class="p-8px msg-map-view-icon msg-map-view-icon-send" />
                    <div class="msg-map-container d-flex">
                        <Icon size="22" type="md-pin" />
                        <p><strong>{{message.map.address}}</strong></p>
                    </div>
                </div>
                <div class="ch-time-mo">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="ch-user-avatar-sender-mo">
                    <!-- <avatar :size="30" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
            </div>

            <div v-else class="d-flex justify-start mb-4 position-relative">
                <div class="ch-user-avatar-mo">
                    <!-- <avatar :size="40" :username="message.from.name"></avatar> -->
                    <v-avatar size="40" color="#49d29e" class="rounded-lg">
                        <v-img v-if="message.from.avatar !== '/'" :src="`${baseUrl}${message.from.avatar}`" :alt="message.from.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{message.from.name[0]}}</span>
                    </v-avatar>
                </div>
                <div class="ch-name-and-time-mo d-flex">
                    <p v-html="TimeViewHMS(message.created_at)" class="mb-0"></p>
                </div>
                <div class="msg-container-mo">
                    <div class="msg-map-container d-flex">
                        <Icon size="22" color="white" type="md-pin" />
                        <p><strong>{{message.map.address}}</strong></p>
                    </div>
                    <Icon @click="sendLocationInfoToParent(message.map)" type="md-eye" size="25" class="p-8px msg-map-view-icon" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Viewer from 'v-viewer'
// import Avatar from 'vue-avatar'

export default {
    components:{
        Viewer,
        // Avatar,
    },

    created(){
    },

    data(){
        return{
            baseUrl: window.Laravel.base_url,
        }
    },
    // watch:{
    //     center:{
    //         handler(val){
    //             if(val.lng !== null && val.lat !== null){
    //                 this.viewLocationMapMessageModal = true;
    //             }
    //         }
    //     }
    // },
    props: {
        message: {
            type: Object,
            required: true,
        },
        chatto: {
            type: Number,
            required: false,
        },
        chatfrom: {
            type: Number,
            required: true,
        },
        chatin:{
            type:Number,
            required:false
        },
    },

    methods:{
        showSendImage(){
            const viewer = this.$el.querySelector('.msg-image-container-send-mo').$viewer
            viewer.show()
        },

        showReceiveImage(){
            const viewer = this.$el.querySelector('.msg-image-container').$viewer
            viewer.show()
        },

        detectUrl(text){
            if(typeof text == "object"){
                return;
            }
            let urlRegex = /(https?:\/\/[^\s]+)/g;
            return text.replace(urlRegex, function(url) {
                return `<a href="${url}" target="_blank">${url}</a>`;
            });
        },
        sendLocationInfoToParent(mapInfo){
            this.$emit('mapInfoToParent', mapInfo)
        },
        sendVideoInfoToParent(videoInfo){
            this.$emit('videoInfoToParent', videoInfo)
        },

        checkIfCreateRoomInfo(message){
            if((typeof message.text == "string" && (message.text[0] == "{" && message.text[message.text.length - 1] == "}"))){
                message.text = JSON.parse(message.text);
                return true;
            }
            else if(typeof message.text == "string"){
                return false;
            }
            else if('createdUser' in message.text){
                return true;
            }
            else{
                return false;
            }
        },

        isJson(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
    }
}
</script>


<style scoped>
.recording-result audio{
    width: 237px!important;
    height: 30px!important;
}

.msg-container-send-mo{
    max-width: 70%;
}
.msg-container-send-mo{
    max-width: 70%;
}
.msg-container-mo{
    max-width: 70%;
}
.msg-voice-send audio{
    width: 210px!important;
}
.msg-container-send-mo audio{
    width: 210px!important;
}
.msg-container-mo audio{
    width: 210px!important;
}

@media only screen and (max-width: 360px) {
    .recording-result audio{
        width: 200px!important;
        height: 30px!important;
    }
}

</style>