<template>
    <v-container class="h-100 pa-0">
        <v-row class="h-100 ma-0">
            <v-col cols="12" sm="12" md="9" class="h-100 mo-glow-bg pa-0">
                <v-row class="mo-glow-bg mo-ch-area-height ma-0 ">
                    <v-col cols="12" class="overflowY-auto h-100 mo-glow-bg mo-glow-inverse" v-chat-scroll="{always: false, smooth: true}" @v-chat-scroll-top-reached="reachedTop">
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
                <div id="push-popup-bottom-nav" class="push-popup-bottom-nav">
                    <v-row class="bg-secondary ma-0 pa-0 w-100" style="position:absolute; top: -62px; ">
                        <v-col cols="12" class="d-flex align-center position-relative" style="border-bottom: 1px solid lightgray;">
                            <div class="ch-icon-area d-flex align-center position-relative">
                                <v-icon @click="closeSheet()" size="30" v-if="isFileUploadSheet" class="hover-cursor-point">
                                    mdi-keyboard-outline
                                </v-icon>
                                <v-progress-circular size="30" indeterminate color="#7879ff" v-else-if="isFileUploadSheet == true && isUploadingFileInChat == true"></v-progress-circular>
                                <v-icon @click="showSheet('fileUpload')" size="30" v-else class="hover-cursor-point">
                                    mdi-paperclip
                                </v-icon>
                                
                                <v-icon @click="showSheet('emoji')" size="30" class="hover-cursor-point mr-4">
                                    mdi-emoticon-happy-outline
                                </v-icon>
                            </div>
                            <v-text-field
                                solo
                                class="mo-select-white-bg"
                                v-model="text"
                                :append-outer-icon="'mdi-send'"
                                label="输入内容"
                                dense
                                type="text"
                                hide-details
                                color="#7879ff"
                                ref="textField"
                                @click:append-outer="submit"
                                @click:clear="clearMessage"

                                @keydown.enter.exact.prevent 
                                @keyup.enter.exact="newline" 
                                @keydown.enter.shift.exact="submit" 
                                @keydown.enter.shift.exact.prevent
                                @keydown="sendTypingEvent"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-sheet class="" color="#F2F2F2">
                        <transition name="page" mode="out-in">
                            <v-container key="1" v-if="isFileUploadSheet == true" class="d-flex" :style="{ transitionDelay: delay }">  
                                <div class="text-center" @click="clickUploadImageBtn">
                                    <v-icon size="35" color="#757575">mdi-file-image-outline</v-icon>
                                    <p class="mb-0 font-size-0-75 font-color-gray-dark">图片</p>
                                </div>
                                <input
                                    ref="imageUploader"
                                    class="d-none"
                                    type="file"
                                    accept="image/*"
                                    @change="onImageFileChanged"
                                >
                                <div class="text-center mx-5" @click="clickUploadVideoBtn">
                                    <v-icon size="35" color="#757575">mdi-file-video-outline</v-icon>
                                    <p class="mb-0 font-size-0-75 font-color-gray-dark">视频</p>
                                </div>
                                <input
                                    ref="videoUploader"
                                    class="d-none"
                                    type="file"
                                    accept="video/*"
                                    @change="onVideoFileChanged"
                                >
                                <div class="text-center" @click="clickUploadFileBtn">
                                    <v-icon size="35" color="#757575">mdi-file-upload-outline</v-icon>
                                    <p class="mb-0 font-size-0-75 font-color-gray-dark">文档</p>
                                </div>
                                <input
                                    ref="fileUploader"
                                    class="d-none"
                                    type="file"
                                    accept="file/*"
                                    @change="onFileFileChanged"
                                >
                            </v-container>
                            <v-container key="2" class="pa-0" v-else-if="isEmojiSheet == true" :style="{ transitionDelay: delay }">
                                <Picker 
                                    class="w-100 h-350-px" 
                                    title="选择你的表情符号..." 
                                    set="twitter" 
                                    color="#7879ff"
                                    :data="emojiIndex" 
                                    :showPreview="false"
                                    :showSearch="false"
                                    :i18n="emojiI18n"
                                    @select="onInput" 
                                    />
                            </v-container>
                        </transition>
                    </v-sheet>
                </div>
            </v-col>                
        </v-row>
    </v-container>
    
</template>

<script>
import { mapGetters } from 'vuex';
import { videoPlayer } from 'vue-video-player';
import ChatMessage from './chatmessage';
import lang from '~/helper/lang.json';
import { getMessage, postMessage, postMessageImage, postMessageVideo, postMessageFile, getGroupChatMessage } from '~/api/chat';
//emoji
import emojiData from "emoji-mart-vue-fast/data/all.json";
import "emoji-mart-vue-fast/css/emoji-mart.css";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast";
let emojiIndex = new EmojiIndex(emojiData);

export default {
    components:{
        ChatMessage,
        videoPlayer,
        Picker
    },  
    props:{
        chatto:{
            type:Number,
            required:false
        },
        chatfrom:{
            type:Number,
            required:false
        },
        chatin:{
            type:Number,
            required:false
        },
        messages:{
            type:Array,
            required:false
        }
    },

    data: ()=> ({

        emojiIndex: emojiIndex,
        emojisOutput: "",
        emojiI18n: { 
            search: 'Recherche', 
            categories: { 
                search: '//Search Results',
                recent: '最近常用',
                smileys: '黄脸',
                people: '人和手势',
                nature: '动物和植物',
                foods: '食物',
                activity: '活动',
                places: '交通 ',
                objects: '物品',
                symbols: '标志',
                flags: '国旗',
                custom: '其他',
            } 
                
        },
        delay: "0.25s",

        fab: false,
        lang,
        isReachedTop : false,
        selectedViedoName: '',
        videoViewDialog: false,
        baseUrl:window.Laravel.base_url,
        isUploadingFileInChat: false,
        selectedImageFile: null,
        selectedVideoFile: null,
        selectedFile: null,
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
        ChatWith: null,
        ChatIn: null,
        contactNow: null,
        //recording
        recording: {
            src:null,
        },
        recordingBlobData:null,
        //emoji
        emoStatus:false,
        text:'',
        warning: false,
        warningMessage: '',
        isFormValid: false,

        toggle_none: null,
        isEmojiSheet: false,
        isFileUploadSheet: false,
                
    }),

    computed:{
        player() {
            return this.$refs.videoPlayer.player
        },

        ...mapGetters({
            currentUser: 'auth/user',
        }),

        activeFab () {
            switch (this.tabs) {
                case 'one': return { class: 'purple', icon: 'account_circle' }
                case 'two': return { class: 'red', icon: 'edit' }
                case 'three': return { class: 'green', icon: 'keyboard_arrow_up' }
                default: return {}
            }
        },
    },

    created(){
        console.log(this.chatto, this.chatfrom, this.chatin, this.messages);
        this.ChatWith = this.chatto;
        this.ChatIn = this.chatin;
        if(this.ChatWith == null && this.ChatIn == null){
            this.$router.push({name: "mochat.news"});
        }
        this.listen();
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
        },

        removeRecordedAudio(){
            this.recording.src = null;
            this.recordingBlobData = null;
        },

        //uploadImage
        clickUploadImageBtn() {
            this.fab = false;
            this.isUploadingFileInChat = true
            window.addEventListener('focus', () => {
                this.isUploadingFileInChat = false
            }, { once: true })
            this.$refs.imageUploader.click()
        },
        clickUploadVideoBtn() {
            this.fab = false;
            this.isUploadingFileInChat = true
            window.addEventListener('focus', () => {
                this.isUploadingFileInChat = false
            }, { once: true })
            this.$refs.videoUploader.click()
        },
        clickUploadFileBtn() {
            this.fab = false;
            this.isUploadingFileInChat = true
            window.addEventListener('focus', () => {
                this.isUploadingFileInChat = false
            }, { once: true })
            this.$refs.fileUploader.click()
        },
        async onImageFileChanged(e) {
            this.selectedImageFile = e.target.files[0];
            if(this.selectedImageFile !== undefined && this.selectedImageFile !== null) {
                this.isUploadingFileInChat = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedImageFile);
                fileData.append('from',this.currentUser.id)
                fileData.append('to',this.ChatWith)
                fileData.append('roomId',this.ChatIn)
                
                await postMessageImage(fileData)
                .then((res) => {
                    this.fab = false;
                    console.log(res)
                    this.messages.push(res.data.message);
                    this.isUploadingFileInChat = false;
                    this.selectedImageFile = null;
                    this.isFileUploadSheet = false;
                    document.getElementById("push-popup-bottom-nav").style.height = "0";
                }).catch((err) => {
                    console.log(err)
                    this.isUploadingFileInChat = false
                }); 
            }
        },
        async onVideoFileChanged(e) {
            this.selectedVideoFile = e.target.files[0];
            if(this.selectedVideoFile !== undefined && this.selectedVideoFile !== null) {
                this.isUploadingFileInChat = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedVideoFile);
                fileData.append('from',this.currentUser.id);
                fileData.append('to',this.ChatWith);
                fileData.append('roomId',this.ChatIn);
                await postMessageVideo(fileData)
                .then((res) => {
                    this.messages.push(res.data.message);
                    this.fab = false;
                    this.selectedVideoFile = null;
                    console.log(res)
                    this.isUploadingFileInChat = false;
                    this.isFileUploadSheet = false;
                    document.getElementById("push-popup-bottom-nav").style.height = "0";
                }).catch((err) => {
                    //console.log(err);
                    this.isUploadingFileInChat = false
                });
            }
        },
        async onFileFileChanged(e) {
            this.selectedFile = e.target.files[0];
            if(this.selectedFile !== undefined && this.selectedFile !== null) {
                this.isUploadingFileInChat = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedFile);
                fileData.append('from',this.currentUser.id);
                fileData.append('to',this.ChatWith);
                fileData.append('roomId',this.ChatIn);
                await postMessageFile(fileData)
                .then((res) => {
                    res.data.message.file = JSON.parse(res.data.message.file);
                    this.messages.push(res.data.message);
                    this.fab = false;
                    this.selectedFile = null;
                    console.log(res);
                    this.isUploadingFileInChat = false;
                    this.isFileUploadSheet = false;
                    document.getElementById("push-popup-bottom-nav").style.height = "0";
                }).catch((err) => {
                    //console.log(err);
                    this.isUploadingFileInChat = false
                });
            }
        },
        clickUploadMapBtn(){
            console.log("send map");
        },

        submit(){
            if(this.text.trim() == '' && this.recordingBlobData == null){
                return;
            }
            if(this.ChatIn == null){
                if(this.text){
                    this.emoStatus = false;
                    let currentTime = new Date();
                    let from = {}
                    this.$set(from,'id',this.currentUser.id)
                    this.$set(from,'name',this.currentUser.name)
                    this.$set(from,'avatar',this.currentUser.avatar)
                    
                    let messageData = {
                        text: this.text,
                        to: this.ChatWith,
                        from: from,
                        created_at:currentTime,
                    };
                    this.messages.push(messageData);
                    let messageText = this.text;
                    this.text = "";
                
                    let payload = {
                        text: messageText,
                        to: this.ChatWith,
                        from: this.currentUser.id,
                    }
                    postMessage(payload)
                    .then((res) => {
                    }).catch((err) => {
                        
                    });
                }
                else if(this.recordingBlobData){
                    let formdata = new FormData();
                    formdata.append('voice',this.recordingBlobData);
                    formdata.append('from',this.currentUser.id);
                    formdata.append('to',this.ChatWith);

                    postMessageVoice(formdata)
                    .then((res) => {
                        if(res.errors){
                            this.warning = true;
                            this.warningMessage = '出了些问题'
                        }
                        this.removeRecordedAudio();
                        this.messages.push(res.data.message);
                    }).catch((err) => {
                        console.log(err)
                    });

                    axios
                        .post(`/api/messages/voice`, formdata ,{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                        })
                        .then((res) => {
                        
                        });
                }
            }
            else if(this.ChatWith == null){
                if(this.text){
                this.emoStatus = false;
                let currentTime = new Date();
                let from = {}
                this.$set(from,'id',this.currentUser.id)
                this.$set(from,'name',this.currentUser.name)
                this.$set(from,'avatar',this.currentUser.avatar)
                
                let messageData = {
                    text: this.text,
                    to: this.ChatWith,
                    roomId: this.ChatIn,
                    from: from,
                    created_at:currentTime
                };
                
                this.messages.push(messageData);
                let messageText = this.text;
                this.text = "";
                let payload = {
                    text: messageText,
                    to: this.ChatWith,
                    roomId: this.ChatIn,
                    from: this.currentUser.id,
                }
                console.log("payload",payload);
                postMessage(payload)
                    .then((res) => {
                    }).catch((err) => {
                        
                    });
                }
                else if(this.recordingBlobData){
                let formdata = new FormData();
                formdata.append('voice',this.recordingBlobData);
                formdata.append('from',this.currentUser.id);
                formdata.append('to',this.ChatWith);
                formdata.append('roomId',this.ChatIn);
                axios
                    .post(`/api/messages/voice`, formdata ,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                    })
                    .then((res) => {
                    if(res.errors){
                        this.warning = true;
                        this.warningMessage = '出了些问题'
                    }
                    this.removeRecordedAudio();
                    this.messages.push(res.data.message);
                    });
                }
            }
            
        },

        listen(){
        Echo.join('chats')
            .listenForWhisper('typing', (e) => {
                if(this.ChatWith !== null){
                    if(this.ChatWith == e.id && this.currentUser.id == e.ChatWith){
                        this.userTypingNow = true;
        
                        if(this.typingTimer){
                        clearTimeout(this.typingTimer);
                        }
        
                        this.typingTimer = setTimeout(()=>{
                            this.userTypingNow = false;
                        }, 3000)
                    }
                }
                else if (this.ChatIn !== null){
                    if(this.ChatIn == e.ChatIn){
                        if(!this.groupTypingList.includes(e.name)){
                        this.groupTypingList.push(e.name);
                        }

                        if(this.typingTimer){
                        clearTimeout(this.typingTimer);
                        }
        
                        this.typingTimer = setTimeout(()=>{
                        this.groupTypingList = [];
                        }, 2000)
                    }
                }
            })
            .listen('NewMessage', (message) => {
                console.log("---listenIndex", message)
                console.log(this.currentUser.id, this.ChatWith)
                if (
                message.message.to == this.currentUser.id &&
                message.message.from.id == this.ChatWith
                ) {
                    if(message.message.file){
                        message.message.file = JSON.parse(message.message.file);
                    }
                    if(message.message.map){
                        message.message.map = JSON.parse(message.message.map);
                    }
                    this.messages.push(message.message);
                }
                else if(message.message.roomId !== null && message.message.roomId == this.ChatIn && message.message.from.id !== this.currentUser.id){
                    if(message.message.file){
                        message.message.file = JSON.parse(message.message.file);
                    }
                    if(message.message.map){
                        message.message.map = JSON.parse(message.message.map);
                    }
                    this.messages.push(message.message);
                }
            });
        },

        //groupchat history
        getMessageGroup() {
            let payload =  {
                to: this.ChatIn,
                from: this.currentUser.id,
            };
            console.log("payload",payload)
            getGroupChatMessage(payload)
                .then((res) => {
                    console.log("res", res);
                for(let i = 0; i < res.data.messages.length ; i++){
                    if(res.data.messages[i].file){
                    res.data.messages[i].file = JSON.parse(res.data.messages[i].file);
                    }
                    if(res.data.messages[i].map){
                    res.data.messages[i].map = JSON.parse(res.data.messages[i].map);
                    }
                }
                this.messages = res.data.messages;
                
            });
        },

        //chat history
        getMessage() {
            let payload = {
                to: this.ChatWith,
                from: this.currentUser.id,
            }
            getMessage(payload)
            .then((res) => {
                for(let i = 0; i < res.data.messages.length ; i++){
                    if(res.data.messages[i].file){
                        res.data.messages[i].file = JSON.parse(res.data.messages[i].file);
                    }
                    if(res.data.messages[i].map){
                        res.data.messages[i].map = JSON.parse(res.data.messages[i].map);
                    }
                }
                this.messages = res.data.messages;
                
            }).catch((err) => {
                console.log(err);
            });
        },

        //emoji
        toggleEmo(){
            this.emoStatus = !this.emoStatus;
        },
        onInput(e){
            if(!e){
                return false;
            }
            if(!this.text){
                this.text = e.native
            }else{
                this.text = this.text + e.native
            }
        },

        showEmoji(emoji) {
            this.emojisOutput = this.emojisOutput + emoji.native;
        },

        outSidePicker(){
            this.emoStatus = false;
        },


        toggleMarker () {
            this.marker = !this.marker
        },
        sendMessage () {
            this.resetIcon()
            this.clearMessage()
        },
        clearMessage () {
            this.text = ''
        },
        resetIcon () {
            this.iconIndex = 0
        },
        changeIcon () {
            this.iconIndex === this.icons.length - 1
            ? this.iconIndex = 0
            : this.iconIndex++
        },
        newline(){
            this.text = `${this.text}\n`
        },
        goToContactList(){
            this.$router.push({})
        },
        sendTypingEvent(){

        },

        closeSheet() {
            this.$refs.textField.focus();
            document.getElementById("push-popup-bottom-nav").style.height = "0";
            this.isFileUploadSheet = false;
            this.isEmojiSheet = false;
        },

        showSheet(type){
            if(type == "fileUpload"){
                this.isFileUploadSheet = true;
                this.isEmojiSheet = false;
                document.getElementById("push-popup-bottom-nav").style.height = "77px";
            }
            else if(type == 'emoji'){
                if(this.isEmojiSheet == false){
                    this.isEmojiSheet = true;
                    this.isFileUploadSheet = false;
                    document.getElementById("push-popup-bottom-nav").style.height = "350px";
                }
                else{
                    document.getElementById("push-popup-bottom-nav").style.height = "0";
                    this.isEmojiSheet = false;
                    this.isFileUploadSheet = false;
                }
            }
        },

    }
}
</script>

<style>

</style>