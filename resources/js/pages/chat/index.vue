<template>
  <v-container class="h-100 pa-0">
      <v-row class="h-100 ma-0">
          <ChatList />
          <v-col cols="12" sm="12" md="9" class="h-100 bg-light-yellow pa-0" >
                <ChatArea />                
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
                                @click:append-outer="sendMessage"
                                @click:prepend="changeIcon"
                                @click:clear="clearMessage"

                                @keydown.enter.exact.prevent 
                                @keyup.enter.exact="newline" 
                                @keydown.enter.shift.exact="sendMessage" 
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
import ChatList from './chatlist'
import ChatArea from './chatarea'
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
    }),
    computed: {
        icon () {
            return this.icons[this.iconIndex]
        },
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
            axios
                .get(`/api/messages`, {
                params: {
                    to: this.ChatWith,
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
    },
}
</script>

<style>

</style>