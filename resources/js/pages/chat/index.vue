<template>
  <v-container class="h-100 pa-0">
      <v-row class="h-100 ma-0">
          <ChatList
            id="chat-list"
            :ChatWith="ChatWith"
            :ChatIn="ChatIn"
            @updatechatwith="updatechatwith"
            @updatechatIn="updatechatIn" />
            <v-col cols="12" sm="12" md="9" class="h-100 bg-light-yellow pa-0" id="chat-area">
                <ChatArea  :chatto="ChatWith" :chatin="ChatIn" :messages="messages" :chatfrom="currentUser.id" />             
                <v-row class="bg-white ma-0 pa-0">
                    <v-col cols="12" class="d-flex align-center position-relative">
                        <div class="ch-icon-area d-flex align-center position-relative">
                            <v-speed-dial
                                v-model="fab"
                                direction="top"
                                transition="slide-y-reverse-transition"
                                >
                                <template v-slot:activator>
                                    <v-icon v-model="fab" size="30" v-if="fab" class="hover-cursor-point">
                                        mdi-close
                                    </v-icon>
                                    <v-progress-circular indeterminate color="primary" v-else-if="isUploadingFileInChat"></v-progress-circular>
                                    <v-icon v-model="fab" size="30" v-else class="hover-cursor-point">
                                        mdi-paperclip
                                    </v-icon>
                                </template>
                                <v-btn
                                    fab
                                    dark
                                    small
                                    color="green"
                                    @click="clickUploadImageBtn"
                                >
                                    <v-icon>mdi-file-image-outline</v-icon>
                                </v-btn>
                                <input
                                    ref="imageUploader"
                                    class="d-none"
                                    type="file"
                                    accept="image/*"
                                    @change="onImageFileChanged"
                                >
                                <v-btn
                                    fab
                                    dark
                                    small
                                    color="green"
                                    @click="clickUploadVideoBtn"
                                >
                                    <v-icon>mdi-video</v-icon>
                                </v-btn>
                                <input
                                    ref="videoUploader"
                                    class="d-none"
                                    type="file"
                                    accept="video/*"
                                    @change="onVideoFileChanged"
                                >
                                <v-btn
                                    fab
                                    dark
                                    small
                                    color="green"
                                    @click="clickUploadFileBtn"
                                >
                                    <v-icon>mdi-file-upload</v-icon>
                                </v-btn>
                                <input
                                    ref="fileUploader"
                                    class="d-none"
                                    type="file"
                                    accept="file/*"
                                    @change="onFileFileChanged"
                                >
                                <!-- <v-btn
                                    fab
                                    dark
                                    small
                                    color="green"
                                    @click="clickUploadMapBtn"
                                >
                                    <v-icon>mdi-map-marker-outline</v-icon>
                                </v-btn> -->
                            </v-speed-dial>
                            <v-icon @click="toggleEmo" size="30" class="hover-cursor-point mr-4">
                                mdi-emoticon-happy-outline
                            </v-icon>
                            <div class="emoji-area-popup position-absolute" style="bottom: 50px">
                                <Picker v-if="emoStatus" set="emojione" @select="onInput" title="选择你的表情符号..." v-click-outside="onClickOutsideEmoji" />
                            </div>
                        </div>
                        <v-text-field
                            v-model="text"
                            :append-outer-icon="'mdi-send'"
                            filled
                            clear-icon="mdi-close-circle"
                            clearable
                            label="输入内容"
                            type="text"
                            hide-details
                            @click:append-outer="submit"
                            @click:clear="clearMessage"

                            @keydown.enter.exact.prevent 
                            @keyup.enter.exact="newline" 
                            @keydown.enter.shift.exact="submit" 
                            @keydown.enter.shift.exact.prevent
                            @keydown="sendTypingEvent"
                        ></v-text-field>
                        <v-btn fab dark small color="primary" @click="goToContactList" class="position-absolute hidden-md-and-up" style="right: 30px; top: -50px;">
                            <v-icon dark>
                                mdi-backup-restore
                            </v-icon>
                        </v-btn>
                    </v-col>
                        <!-- <v-col cols="12" class="d-flex align-center ">
                            <v-btn color="blue accent-3" fab small dark class="ma-2"
                                :loading="isUploadingFileInChat"
                                @click="clickUploadImageBtn" > 
                                <v-icon>mdi-file-image-outline</v-icon>
                            </v-btn>
                            <input ref="imageUploader" class="d-none" type="file" accept="image/*" @change="onImageFileChanged" >
                            <v-btn color="blue accent-3" fab small dark class="ma-2"
                                :loading="isUploadingFileInChat"
                                @click="clickUploadVideoBtn" > 
                                <v-icon>mdi-video</v-icon>
                            </v-btn>
                            <input ref="videoUploader" class="d-none" type="file" accept="video/*" @change="onVideoFileChanged" >
                            <v-btn color="blue accent-3" fab small dark class="ma-2"
                                :loading="isUploadingFileInChat"
                                @click="clickUploadFileBtn" >
                                <v-icon>mdi-file-upload</v-icon>
                            </v-btn>
                            <input ref="fileUploader" class="d-none" type="file" accept="file/*" @change="onFileFileChanged" >
                            <v-btn v-if="emoji" color="blue accent-3" fab small dark class="ma-2"
                                @click="toggleEmo" >
                                <v-icon>mdi-emoticon-excited-outline</v-icon>
                            </v-btn>
                            <Picker v-if="emoStatus" set="emojione" @select="onInput" title="选择你的表情符号..." />
                        </v-col> -->
                </v-row>
          </v-col>
      </v-row>
  </v-container>
</template>

<script>
import * as easings from 'vuetify/es5/services/goto/easing-patterns'
import { mapGetters } from 'vuex';
import ChatList from './chatlist';
import ChatArea from './chatarea';
import { Picker } from 'emoji-mart-vue'
import { getMessage, postMessage, postMessageImage, postMessageVideo, postMessageFile, getGroupChatMessage } from '~/api/chat';
export default {
    components:{
        ChatList,
        ChatArea,
        Picker
    },
    data: ()=> ({
        fab: false,
        show: false,
        text:'',
        marker: true,
        iconIndex: 0,
        icons: [
            'mdi-emoticon',
            'mdi-emoticon-cool',
            'mdi-emoticon-dead',
            'mdi-emoticon-excited',
            'mdi-emoticon-happy',
            'mdi-emoticon-neutral',
            'mdi-emoticon-sad',
            'mdi-emoticon-tongue',
        ],
        ChatWith: null,
        ChatIn: null,
        contactNow: null,
        messages:[],
        //recording
        recording: {
            src:null,
        },
        recordingBlobData:null,
        //emoji
        emoStatus:false,


        warning: false,
        warningMessage: '',
        isFormValid: false,
        isUploadingFileInChat: false,
        selectedImageFile: null,
        selectedVideoFile: null,
        selectedFile: null,

        easings: Object.keys(easings),
        chatAreaOptions: {
            duration: 500,
            offset: -400,
            easing: 'easeInOutCubic',
            container: '#h-out-navbar'
        },
        chatListOptions: {
            duration: 500,
            offset: 0,
            easing: 'easeInOutCubic',
            container: '#h-out-navbar'
        }
    }),
    computed: {
        icon () {
            return this.icons[this.iconIndex]
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
    mounted(){
        
    },
    created(){
        this.listen();
    },
    methods: {

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
        onClickOutsideEmoji(){
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
        sendTypingEvent(){
        },

        //chat partner select
        updatechatwith(userInfo) {
            console.log("userInfo", userInfo);
            this.ChatWith = userInfo.user.id;
            this.contactNow = userInfo.user.name;
            this.ChatIn = null;
            // console.log(this.$refs('#h-out-navbar'))
            this.$vuetify.goTo('#chat-area', this.chatAreaOptions);
            this.getMessage();
        },
        
        //chat room select
        updatechatIn(group) {
            this.ChatIn = group.roomId;
            this.contactNow = group.room_id.roomName;
            this.ChatWith = null;
            this.$vuetify.goTo('#chat-area', this.chatAreaOptions);
            this.getMessageGroup();
        },

        goToContactList(){
            this.$vuetify.goTo('#chat-list', this.chatListOptions);
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

        //listen event
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
        Echo.private('newMessage.'+ this.currentUser.id)
            .listen('NewMessage', (message) => {
                console.log("---listenIndex________________", message)
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
                    this.isUploadingFileInChat = false
                    this.selectedImageFile = null
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
                    this.isUploadingFileInChat = false
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
                    this.isUploadingFileInChat = false
                }).catch((err) => {
                    //console.log(err);
                    this.isUploadingFileInChat = false
                });
            }
        },
        clickUploadMapBtn(){
            console.log("send map");
        }
    },
}
</script>

<style>

</style>