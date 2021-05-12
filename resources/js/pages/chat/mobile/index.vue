<template>
    <v-container class="pa-0 h-100"
        v-touch="{
            left: () => swipe('Left'),
            right: () => swipe('Right'),
        }"
    >   
        <v-row v-if="isDetailPage" class="ma-0 bg-white justify-center position-sticky-top-0" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{contactNow}}</p>
        </v-row>

        <v-col v-else cols="12" class="d-flex mo-chat-index-nav py-0 bg-white align-center">
          <transition name="page" mode="out-in">
            <v-text-field
              v-if="isSearching" key="1"
              solo
              class="mo-search-input-text-field-chat"
              v-model="searchKeyword"
              label="请输入您的搜索词"
              prepend-inner-icon="mdi-magnify"
              hide-details
              color="#7879ff"
              dense 
            >
              <v-icon
                  v-if="searchKeyword.trim() !== ''"
                  slot="append"
                  @click="searchKeyword = ''"
                  small
                >
                mdi-close-circle
              </v-icon>
            </v-text-field>
            <v-tabs class="mo-chat-contact-tab" v-model="moChatTab" color="#666666" v-else background-color="#fffff">
                <v-tab @click="navToChatNews" :ripple="false" active-class="mo-chat-nav-active">消息</v-tab>
                <v-tab @click="navToChatContact" :ripple="false" active-class="mo-chat-nav-active"> 联系人</v-tab>
            </v-tabs>
          </transition>
          <transition name="page" mode="out-in">
            <v-btn text small v-if="isSearching" key="3" class="ml-3 px-0 min-width-0" @click="onFalseSearching">
                取消
            </v-btn>
            <v-btn icon plain v-else key="4" class="" @click="isSearching = true">
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
        moChatTab: 0,
        isDetailPage: false,
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
                    this.moChatTab = 0
                }
                else if(val.name == "mochat.contact"){
                    this.isActiveNavNews = false;
                    this.isActiveNavContactList = true;
                    this.moChatTab = 1
                }
                else{
                    this.moChatTab = 0
                    this.isActiveNavNews = false;
                    this.isActiveNavContactList = false;
                }
                if(val.name == "mochat.detail"){
                    this.isDetailPage = true;
                }
                else{
                    this.isDetailPage = false
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
            if(this.isDetailPage == true){
                return
            }
            else{
                if(direction == "Left"){
                    if(this.currentPath.name == 'mochat.news'){
                        this.$router.push({name: 'mochat.contact'});
                    }
                    else if(this.currentPath.name == 'mochat.contact'){
                        this.$router.push({name: 'circle'});
                    }
                }
                if(direction == "Right"){
                    if(this.currentPath.name == 'mochat.news'){
                        this.$router.push({name: 'home'});
                    }
                    else if(this.currentPath.name == 'mochat.contact'){
                        this.$router.push({name: 'mochat.news'});
                    }
                }
            }
        },
    }
}
</script>

<style>

</style>