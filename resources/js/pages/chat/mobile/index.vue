<template>
    <v-container class="pa-0">
        <v-col cols="12" class="mo-glow-small-shadow d-flex mo-chat-index-nav" >
          <transition name="page" mode="out-in">
            <v-text-field
                v-if="isSearching" key="1"
                class="mo-glow-v-text"
                solo
                clearable
                v-model="searchKeyword"
                label="请输入您的搜索词"
                append-icon="mdi-check"
                @click:append="onSearch"
                prepend-inner-icon="mdi-magnify"
                hide-details
            ></v-text-field>
            <div v-else class="d-flex w-100 justify-space-between">
                <div @click="navToChatNews" class="mo-chat-cus-nav-w d-flex justify-center align-center" v-bind:class="{ 'mo-glow-inverse': isActiveNavNews, 'mo-glow': !isActiveNavNews }">
                    <v-icon color="#7879ff" class="mr-2">mdi-email-newsletter</v-icon>消息
                </div>
                <div @click="navToChatContact" class="mo-chat-cus-nav-w d-flex justify-center align-center" v-bind:class="{ 'mo-glow-inverse': isActiveNavContactList, 'mo-glow': !isActiveNavContactList }">
                    <v-icon color="#7879ff" class="mr-2">mdi-contacts</v-icon> 联系人
                </div>
            </div>
          </transition>
          <transition name="page" mode="out-in">
          <v-avatar v-if="isSearching" key="3" class="mo-glow-small-shadow ml-3" @click="onFalseSearching">
            <v-icon color="#7879ff">
              mdi-close
            </v-icon>
          </v-avatar>
          <v-avatar v-else key="4" class="mo-glow-small-shadow ml-3" @click="isSearching = true">
            <v-icon color="#7879ff">
              mdi-magnify
            </v-icon>
          </v-avatar>
          </transition>
        </v-col>
        <v-col cols="12" class="pa-0 mt-5"> 
            <router-view @updatechatwith="updatechatwith" @updatechatIn="updatechatIn" :chatto="ChatWith" :chatin="ChatIn" :messages="messages" :chatfrom="currentUser.id" ></router-view>
        </v-col>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import { getMessage, postMessage, postMessageImage, postMessageVideo, postMessageFile, getGroupChatMessage } from '~/api/chat';

export default {
    data: ()=> ({
        isSearching:  false,
        searchKeyword: '',
        isActiveNavContactList: false,
        isActiveNavNews: false,
        ChatWith: null,
        ChatIn: null,
        contactNow: null,
        messages: [],
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            currentUser: 'auth/user',
        }),
    },
    created(){
        if(this.currentPath.name == "mochat.news" || this.currentPath.name == "mochat.detail"){
            this.isActiveNavNews = true;
            this.isActiveNavContactList = false;
        }
        else if(this.currentPath.name == "mochat.contact"){
            this.isActiveNavNews = false;
            this.isActiveNavContactList = true;
        }
        else{
            this.isActiveNavNews = false;
            this.isActiveNavContactList = false;
        }
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name == "mochat.news"){
                    this.isActiveNavNews = true;
                    this.isActiveNavContactList = false;
                }
                else if(val.name == "mochat.contact"){
                    this.isActiveNavNews = false;
                    this.isActiveNavContactList = true;
                }
                else{
                    this.isActiveNavNews = false;
                    this.isActiveNavContactList = false;
                }
            },
            deep: true
        }
    },
    methods: {
        onFalseSearching(){
            this.isSearching = false;
            this.searchKeyword = '';
        },
        onSearch(){
            console.log(this.searchKeyword);
        },
        navToChatNews(){
            this.isActiveNavNews = true;
            this.isActiveNavContactList = false;
            this.$router.push({name: "mochat.news"})
        },
        navToChatContact(){
            this.isActiveNavNews = false;
            this.isActiveNavContactList = true;
            this.$router.push({name: "mochat.contact"})
        },
        updatechatwith(userInfo) {
            this.ChatWith = userInfo.user.id;
            this.contactNow = userInfo.user.name;
            this.ChatIn = null;
            // console.log(this.$refs('#h-out-navbar'))
            this.getMessage();
        },

        updatechatIn(group, index) {
            this.ChatIn = group.roomId;
            this.contactNow = group.room_id.roomName;
            this.ChatWith = null;
            this.getMessageGroup();
        },

        getMessage() {
            let payload = {
                to: this.ChatWith,
                from: this.currentUser.id,
            }
            getMessage(payload)
            .then((res) => {
                console.log("res", res)
                for(let i = 0; i < res.data.messages.length ; i++){
                    if(res.data.messages[i].file){
                        res.data.messages[i].file = JSON.parse(res.data.messages[i].file);
                    }
                    if(res.data.messages[i].map){
                        res.data.messages[i].map = JSON.parse(res.data.messages[i].map);
                    }
                }
                this.messages = res.data.messages;
                this.$router.push({name: "mochat.detail"})
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
    }
}
</script>

<style>

</style>