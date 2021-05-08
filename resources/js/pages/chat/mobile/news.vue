<template>
    <div class="">
        <div v-if="isGettingContactList" class="justify-center align-center d-flex pt-3 m-0" >
            <v-progress-circular
            indeterminate
            color="#7879ff"
            ></v-progress-circular>
        </div>
        <div v-else-if="isNoContactList" class="pa-3 text-center ">
            请添加新朋友
        </div>
        <v-list three-line class="py-0">
            <v-list-item-group
                v-model="model"
                mandatory
                color="#7879ff"
            >
                <template>
                    <v-list v-for="(group, i) in chatGroupList" :key="'A'+ i" class="py-0 position-relative">
                        <v-list-item @click="updatechatIn(group, i)">
                            <v-avatar size="50" color="#7879ff" class="ma-3" tile>
                                <span dark class="white--text headline"> {{group.room_id.roomName[0]}}</span>
                            </v-avatar>

                            <v-list-item-content>
                                <v-list-item-title>{{group.room_id.roomName}}</v-list-item-title>
                                <v-list-item-subtitle>asdf</v-list-item-subtitle>
                            </v-list-item-content>
                            <div v-if="group.new_msg_count !== 0" class="mr-8">
                                <v-badge
                                    color="red"
                                    :content="group.new_msg_count"
                                    >
                                </v-badge>
                            </div>
                        </v-list-item>
                        <v-menu rounded offset-y bottom left min-width="200" origin="top right" transition="scale-transition">
                            <template v-slot:activator="{ attrs, on }">
                                <v-icon class="position-absolute" v-bind="attrs" v-on="on" color="indigo" style="top: 10px; right: 10px;">
                                    mdi-dots-horizontal-circle-outline
                                </v-icon>
                            </template>

                            <v-list>
                                <v-list-item @click="leaveGroup(group)"><v-list-item-icon> <v-icon>mdi-arrow-right-bold-box-outline</v-icon> </v-list-item-icon> <v-list-item-title > 离开团体</v-list-item-title> </v-list-item>
                                <v-list-item v-if="group.room_id.userId == currentUser.id" @click="removeGroup(group)"><v-list-item-icon> <v-icon>mdi-trash-can-outline</v-icon> </v-list-item-icon>  <v-list-item-title > 删除群组</v-list-item-title> </v-list-item>
                            </v-list>
                        </v-menu>
                        
                        <v-divider inset ></v-divider>
                    </v-list>
                    <v-list v-for="user in filteredContacts" :key="user.id" class="py-0 position-relative">
                        <v-list-item @click="updatechatwith(user)">
                            <v-badge bordered bottom v-if="checkOnline(user.user.id)"
                                color="light-green accent-3" dot
                                offset-x="10"
                                offset-y="10" class="ma-3"
                            >
                                <v-avatar size="50" color="#7879ff">
                                    <v-img v-if="user.user.avatar !== '/'" :src="`${baseUrl}${user.user.avatar}`" :alt="user.user.name[0]" class="chat-user-avatar"></v-img>
                                    <span dark v-else class="white--text headline"> {{user.user.name[0]}}</span>
                                </v-avatar>
                            </v-badge>
                            <v-badge bordered bottom v-else
                                color="blue-grey lighten-2" dot
                                offset-x="10"
                                offset-y="10" class="ma-3"
                            >
                                <v-avatar size="50" color="#7879ff">
                                    <v-img v-if="user.user.avatar !== '/'" :src="`${baseUrl}${user.user.avatar}`" :alt="user.user.name[0]" class="chat-user-avatar"></v-img>
                                    <span dark v-else class="white--text headline"> {{user.user.name[0]}}</span>
                                </v-avatar>
                            </v-badge>
                            
                            <v-list-item-content>
                                <v-list-item-title>{{user.user.name}}</v-list-item-title>
                                <v-list-item-subtitle>asdf</v-list-item-subtitle>
                            </v-list-item-content>
                            <div v-if="user.new_msg_count !== 0" class="mr-8">
                                <v-badge
                                    color="red"
                                    :content="user.new_msg_count"
                                    >
                                </v-badge>
                            </div>
                        </v-list-item>
                        <v-menu rounded offset-y bottom left min-width="200" origin="top right" transition="scale-transition">
                            <template v-slot:activator="{ attrs, on }">
                                <v-icon class="position-absolute" v-bind="attrs" v-on="on" color="indigo" style="top: 10px; right: 10px;">
                                    mdi-dots-horizontal-circle-outline
                                </v-icon>
                            </template>

                            <v-list>
                                <v-list-item @click="removeUserFromContactList(user.user)"><v-list-item-icon> <v-icon>mdi-trash-can-outline</v-icon> </v-list-item-icon> <v-list-item-title > 删除</v-list-item-title> </v-list-item>
                            </v-list>
                        </v-menu>
                        <v-divider inset ></v-divider>
                    </v-list>
                </template>
            </v-list-item-group>
        </v-list>
    </div>
</template>

<script>
import lang from '~/helper/lang.json'
import { mapGetters } from 'vuex';
import pinyin from 'js-pinyin'
import { getUserList, getContactList, addUserToContact, postNewMsgCount, postNewGroup, removeContactUser, leaveGroup, removeGroup } from '~/api/chat'
export default {
    props:{
        chatto: {
            type: Number,
            required: false,
        },
        chatin: {
            type: Number,
            required: false,
        },
    },

    data: ()=> ({
        lang,
        model: null,
        value: 0,
        addDialog: false,
        baseUrl: window.Laravel.base_url,
        isGettingContactList: false,
        isNoContactList: false,
        postFailed : false,
        postSuccess : false,
        isAdding: false,
        willAddToContactUser : {
            contactId:null,
        },
        errorMessage: '',
        successMessage: '',
        searchContact:'',
        users:[],
        contactList:[],
        chatGroupList:[],
        addContactUserList:[],
        totalNewMessageCount:0,
        activeUserList: [],

        newGroup: [],
        isCreatingNewGroup: false,
        groupNameDialog: false,
        groupName: '',
    }),

    async created(){
        this.listen();
        if(this.usersStore !== null){
            this.users = this.usersStore;
        }
        else{
            this.isGettingContactList = true;
            await getUserList()
            .then((res) => {
                this.users = res.data;
                this.users = this.users.users.filter((user) => user.id !== this.currentUser.id);
                this.users.map( user => {
                    user['isSelected'] = false;
                })
                this.addressedUsers = this.pySort(this.users, 'name')
                this.$store.dispatch('chat/storeUsers',this.users)
                this.$store.dispatch('chat/storeAddressedUsers',this.addressedUsers)
            }).catch((err) => {
                console.log(err);
            });
            this.isGettingContactList = false;
        }
        if(this.contactListStore !== null){
            this.contactList = this.contactListStore;
            this.chatGroupList = this.chatGroupListStore;
            this.totalNewMessageCount = this.totalNewMessageCountStore;
        }
        else{
            this.isGettingContactList = true;
            await getContactList()
            .then((res) => {
                this.chatGroupList = res.data.chatGroups;
                this.contactList = res.data.contactUsers;
                this.$store.dispatch('chat/storeContactList',this.contactList)
                this.$store.dispatch('chat/storeGroupList',this.chatGroupList)
                if(this.chatGroupList.length == 0 && this.contactList.length == 0){
                    this.isNoContactList = true;
                }
                console.log("this.contactList", res.data);
                for(let i = 0; i < this.contactList.length ; i++){
                    this.totalNewMessageCount = this.totalNewMessageCount + this.contactList[i].new_msg_count;
                }
                for(let i = 0; i < this.chatGroupList.length ; i++){
                    this.totalNewMessageCount = this.totalNewMessageCount + this.chatGroupList[i].new_msg_count;
                }
                this.$store.dispatch('chat/storeTotalNewMsgCount',this.totalNewMessageCount)
                // this.$emit("updatechatwith", this.contactList[0]);
            }).catch((err) => {
                console.log(err);
            });
            this.isGettingContactList = false;
        }
        this.model = this.chatGroupList.length;
        console.log("this.contactList", this.contactList);
    },

    computed:{
        ...mapGetters({
            currentUser: 'auth/user',
            usersStore: 'chat/usersStore',
            contactListStore: 'chat/contactListStore',
            chatGroupListStore: 'chat/chatGroupListStore',
            totalNewMessageCountStore: 'chat/totalNewMessageCountStore',
        }),

        filteredContacts(){
            if(this.searchContact){
                return this.contactList.filter((item) => {
                    return (item.user.name.toUpperCase().startsWith(this.searchContact.toUpperCase()))
                        // ||(item.subject.toUpperCase().startsWith(this.searchContact.toUpperCase()))
                        // ||(item.description.toUpperCase().startsWith(this.searchContact.toUpperCase()))
                        // ||(item.created_at.toUpperCase().startsWith(this.searchContact.toUpperCase()))
                        
                });
            } else{
                return this.contactList;
            }
        },
    },
    methods:{
        listen(){
            Echo.private('group')
                .listen('NewGroup', (e) => {
                    if(e.group.room_id.invited !== null){
                        let invitedArr = e.group.room_id.invited;
                        if(invitedArr.includes(this.currentUser.id)){
                            this.isNoContactList = false;
                            this.chatGroupList.unshift(e.group);
                        }
                    }
                    else if(e.group.room_id.invited == null){
                        let removedGroupId = e.group.roomId;
                        for (let i = 0; i < this.chatGroupList.length ; i++){
                            if( this.chatGroupList[i].roomId == removedGroupId){
                                this.chatGroupList.splice(i, 1);
                            }
                        }
                        if(this.chatGroupList.length == 0 && this.contactList.length == 0){
                            this.isNoContactList = true;
                        }
                    }
                });
            Echo.join('chats')
                .here(user=>{
                    this.activeUserList = user;
                })
                .joining(user=>{
                    this.activeUserList.push(user);
                })
                .leaving(user=>{
                    this.activeUserList = this.activeUserList.filter(u => u.id != user.id);
                })
                .listen('NewMessage', (message) => {
                    console.log("---listenList", message);
                    if ( message.message.to == this.currentUser.id ) {
                        console.log("Badge", message.message.from.id);
                        for(let i = 0; i < this.contactList.length; i++){
                            if( message.message.from.id == this.contactList[i].contactUserId ){
                                this.totalNewMessageCount = this.totalNewMessageCount + 1;
                                // this.$store.state.totalNewMsgCnt = this.totalNewMessageCount;
                                this.$store.dispatch('chat/storeTotalNewMsgCount',this.totalNewMessageCount)
                                this.contactList[i].new_msg_count = this.contactList[i].new_msg_count + 1;
                                postNewMsgCount({new_msg_count:this.contactList[i]})
                            }
                        }
                    }
                    else if ( (((message.message.room_id.invited)).includes(this.currentUser.id) || message.message.room_id.userId == this.currentUser.id ) && message.message.from.id !== this.currentUser.id  ) {
                        console.log("Badge", message.message.from.id);
                        for(let i = 0; i < this.chatGroupList.length; i++){
                            if( message.message.roomId == this.chatGroupList[i].roomId ){
                                this.totalNewMessageCount = this.totalNewMessageCount + 1;
                                // this.$store.state.totalNewMsgCnt = this.totalNewMessageCount;
                                this.$store.dispatch('chat/storeTotalNewMsgCount',this.totalNewMessageCount)
                                this.chatGroupList[i].new_msg_count = this.chatGroupList[i].new_msg_count + 1;
                                postNewMsgCount({new_msg_count:this.chatGroupList[i]})
                            }
                        }
                    }
                })
                
        },

        checkOnline(userId){
            for(let i = 0; i < this.activeUserList.length; i++){
                if(this.activeUserList[i].id == userId){
                    return true;
                }
            }
            return false;
        },

        updatechatwith(userInfo) {
            console.log("userInfo_news", userInfo)
            for(let i = 0; i < this.contactList.length; i++){
                if( userInfo.user.id == this.contactList[i].contactUserId ){
                    this.totalNewMessageCount = this.totalNewMessageCount - this.contactList[i].new_msg_count;
                    this.$store.dispatch('chat/storeTotalNewMsgCount',this.totalNewMessageCount)
                    this.contactList[i].new_msg_count = 0;

                    postNewMsgCount({new_msg_count:this.contactList[i]})
                }
            }
            this.$emit("updatechatwith", userInfo);
        },

        updatechatIn(group, index) {
            this.$emit("updatechatIn", group);
            for(let i = 0; i < this.chatGroupList.length; i++){
                if( group.roomId == this.chatGroupList[i].roomId ){
                    this.totalNewMessageCount = this.totalNewMessageCount - this.chatGroupList[i].new_msg_count;
                    this.$store.dispatch('chat/storeTotalNewMsgCount',this.totalNewMessageCount)
                    this.chatGroupList[i].new_msg_count = 0;
                    postNewMsgCount({new_msg_count:this.chatGroupList[i]})
                }
            }
        },

        removeUserFromContactList(user){
            let payload = {
                userId : user.id
            }
            console.log(user);
            console.log(payload);
            console.log(this.contactList);
            removeContactUser(payload)
            .then(res=>{
                console.log(res);
                if(res.data.msg == 1){
                    let removedUserId = user.id;
                    for (let i = 0; i < this.contactList.length ; i++){
                        if( this.contactList[i].user.id == removedUserId){
                            this.contactList.splice(i, 1);
                        }
                    }
                }
                if(this.chatGroupList.length == 0 && this.contactList.length == 0){
                    this.isNoContactList = true;
                }
            })
            .catch(err=>{
                console.log(err.response);
            })
        },

        leaveGroup(group){
            let payload = {
                roomId : group.roomId
            }
            leaveGroup(payload)
            .then(res=>{
                console.log(res);
                if(res.data.msg == 1){
                    let removedGroupId = res.data.roomId;
                    for (let i = 0; i < this.chatGroupList.length ; i++){
                        if( this.chatGroupList[i].roomId == removedGroupId){
                            this.chatGroupList.splice(i, 1);
                        }
                    }
                }
                if(this.chatGroupList.length == 0 && this.contactList.length == 0){
                    this.isNoContactList = true;
                }
            })
            .catch(err=>{
                console.log(err.response);
            })
        },

        removeGroup(group){
            let payload = {
                roomId : group.roomId
            }
            removeGroup(payload)
            .then(res=>{
                console.log(res);
                if(res.data.msg == 1){
                    let removedGroupId = group.roomId;
                    for (let i = 0; i < this.chatGroupList.length ; i++){
                        if( this.chatGroupList[i].roomId == removedGroupId){
                            this.chatGroupList.splice(i, 1);
                        }
                    }
                }
                if(this.chatGroupList.length == 0 && this.contactList.length == 0){
                    this.isNoContactList = true;
                }
            })
            .catch(err=>{
                console.log(err.response);
            })
        },
        isChinese (temp) {
            let re = /[^\u4E00-\u9FA5$]/
            if (re.test(temp)) { return false }
            return true
        },
        isChar (char) {
            let reg = /[A-Za-z]/
            if (!reg.test(char)) { return false }
            return true
        },
        pySort (arr, attrName, empty) {
            if (!attrName) {
                    console.error ( 'pass in the sorting property')
                return null
            }
            if (!String.prototype.localeCompare) { return null }
            let letters = 'ABCDEFGHJKLMNOPQRSTWXYZ#'.split('')
            let zh = '  It '.split('')
            let arrList = []
            for (let m = 0; m < arr.length; m++) {
                arrList.push(arr[m])
            }
            let result = []
            let curr = {}
            for (let i = 0; i < letters.length; i++) {
                curr = {letter: letters[i], data: []}
                if (i !== 23) {
                    for (let j = 0; j < arrList.length; j++) {
                                let initial = arrList[j][attrName].charAt(0)// intercept the first character
                                if (arrList[j][attrName].charAt(0) === letters[i] || arrList[j][attrName].charAt(0) === letters[i].toLowerCase()) { // the first character is in English
                                    curr.data.push(arrList[j]) // English alphabet
                                } else if (zh[i] !== '*' && this.isChinese(initial)) { // Determine if there is no Chinese character, is it Chinese?
                            if (pinyin.getCamelChars(initial).charAt(0) === letters[i]) {
                                curr.data.push(arrList[j])
                            }
                        }
                    }
                } else {
                    for (let k = 0; k < arrList.length; k++) {
                                let ini = arrList[k][attrName].charAt(0) // intercept the first character
                                if (!this.isChar(ini) && !this.isChinese(ini)) { // The first character is not a Chinese character (such as numbers, special characters, etc.)
                        curr.data.push(arrList[k])
                        }
                    }
                }
                if (empty || curr.data.length) {
                    result.push(curr)
                }
            }
            return result
        },
    }
}
</script>

<style>

</style>