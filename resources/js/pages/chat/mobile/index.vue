<template>
    <v-container class="pa-0 h-100"
        v-touch="{
            left: () => swipe('Left'),
            right: () => swipe('Right'),
        }"
    >
        <v-col cols="12" class=" d-flex mo-chat-index-nav pa-0 bg-white align-center" >
          <transition name="page" mode="out-in">
            <v-text-field
                v-if="isSearching" key="1"
                solo
                clearable
                color="#7879ff"
                v-model="searchKeyword"
                label="请输入您的搜索词"
                append-icon="mdi-check"
                @click:append="onSearch"
                class="mo-select-white-bg"
                prepend-inner-icon="mdi-magnify"
                hide-details
            ></v-text-field>
            <v-tabs class="mo-chat-contact-tab" v-model="moChatTab" color="#666666" v-else background-color="#fffff">
                <v-tab @click="navToChatNews" :ripple="false" active-class="mo-chat-nav-active">消息</v-tab>
                <v-tab @click="navToChatContact" :ripple="false" active-class="mo-chat-nav-active"> 联系人</v-tab>
            </v-tabs>
          </transition>
          <transition name="page" mode="out-in">
            <v-btn icon v-if="isSearching" key="3" class="ml-3 mr-2" @click="onFalseSearching">
                <v-icon>
                mdi-close
                </v-icon>
            </v-btn>
            <v-btn icon plain v-else key="4" class="ml-3 mr-4" @click="isSearching = true">
                <v-icon size="30">
                mdi-magnify
                </v-icon>
            </v-btn>
          </transition>
        </v-col>
        <v-col cols="12" class="pa-0"> 
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
        moChatTab: 0
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
            this.moChatTab = 0
        }
        else if(this.currentPath.name == "mochat.contact"){
            this.moChatTab = 1
        }
        else{
            this.moChatTab = -1
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
                this.$router.push({name: "mochat.detail"})
            });
        },

        swipe (direction) {
            if(direction == "Left"){
                this.$router.push({name: 'circle'});
            }
            if(direction == "Right"){
                this.$router.push({name: 'home'});
            }
        },
    }
}
</script>

<style>

</style>