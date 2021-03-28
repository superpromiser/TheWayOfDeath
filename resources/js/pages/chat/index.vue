<template>
  <v-container class="h-100 pa-0">
      <v-row class="h-100 ma-0">
          <ChatList
            :ChatWith="ChatWith"
            :ChatIn="ChatIn"
            @updatechatwith="updatechatwith"
            @updatechatIn="updatechatIn" />
          <v-col cols="12" sm="12" md="9" class="h-100 bg-light-yellow pa-0" >
                <ChatArea :chatto="ChatWith" :chatin="ChatIn" :messages="messages" :chatfrom="currentUser.id" />             
                <v-row class="bg-white h-25 ma-0 pa-0">
                    <v-col cols="12">
                        
                            <v-text-field
                                v-model="text"
                                :append-icon="marker ? 'mdi-map-marker' : 'mdi-map-marker-off'"
                                :append-outer-icon="text ? 'mdi-send' : 'mdi-microphone'"
                                :prepend-icon="icon"
                                filled
                                clear-icon="mdi-close-circle"
                                clearable
                                label="输入内容"
                                type="text"
                                @click:append="toggleMarker"
                                @click:append-outer="submit"
                                @click:prepend="changeIcon"
                                @click:clear="clearMessage"

                                @keydown.enter.exact.prevent 
                                @keyup.enter.exact="newline" 
                                @keydown.enter.shift.exact="submit" 
                                @keydown.enter.shift.exact.prevent
                                @keydown="sendTypingEvent"
                            ></v-text-field>
                        
                    </v-col>
                        <!-- <v-col cols="12" class="d-flex align-center ">
                            <v-btn color="blue accent-3" fab small dark class="ma-2"
                                :loading="isImageSelecting"
                                @click="clickUploadImageBtn" > 
                                <v-icon>mdi-file-image-outline</v-icon>
                            </v-btn>
                            <input ref="imageUploader" class="d-none" type="file" accept="image/*" @change="onImageFileChanged" >
                            <v-btn color="blue accent-3" fab small dark class="ma-2"
                                :loading="isVideoSelecting"
                                @click="clickUploadVideoBtn" > 
                                <v-icon>mdi-video</v-icon>
                            </v-btn>
                            <input ref="videoUploader" class="d-none" type="file" accept="video/*" @change="onVideoFileChanged" >
                            <v-btn color="blue accent-3" fab small dark class="ma-2"
                                :loading="isFileSelecting"
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
import { mapGetters } from 'vuex';
import ChatList from './chatlist';
import ChatArea from './chatarea';
import { getMessage, postMessage } from '~/api/chat';
export default {
    components:{
        ChatList,
        ChatArea
    },
    data: ()=> ({
        password: 'Password',
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
        isFormValid: false
    }),
    computed: {
        icon () {
            return this.icons[this.iconIndex]
        },
        ...mapGetters({
            currentUser: 'auth/user',
        })
    },
    mounted(){
        this.listen();
    },
    methods: {
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
            this.getMessage();
        },
        
        //chat room select
        updatechatIn(group) {
            this.ChatIn = group.roomId;
            this.contactNow = group.room_id.roomName;
            this.ChatWith = null;
            this.getMessageGroup();
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
            axios
                .get(`/api/messages/group`, {
                params: {
                    to: this.ChatIn,
                    from: this.currentUser.id,
                },
                })
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
            .listen('NewMessage', (message) => {
                console.log("@@@@@@@@@message", message)
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
                else if(message.message.roomId == this.ChatIn){
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
        
                axios
                    .post(`/api/messages`, {
                    text: messageText,
                    to: this.ChatWith,
                    roomId: this.ChatIn,
                    from: this.currentUser.id,
                    })
                    .then((res) => {
                    // this.messages.push(res.data.message);
                    // this.text = "";
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
    },
}
</script>

<style>

</style>