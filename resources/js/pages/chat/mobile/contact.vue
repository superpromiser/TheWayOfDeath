<template>
    <v-card
    class="mx-auto"
    tile
  > 
     <v-list class="pa-0">
      <v-subheader>操作</v-subheader>
      <div class="w-100">
            <v-list-item v-ripple @click="openAddUser">
                <v-list-item-icon class="my-2">
                    <v-avatar size="50" color="#49d29e" tile>
                        <v-icon dark> mdi-plus </v-icon>
                    </v-avatar>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>新的朋友</v-list-item-title>
                </v-list-item-content>
            </v-list-item>  
            <v-list-item v-ripple>
                <v-list-item-icon class="my-2">
                    <v-avatar size="50" color="#49d29e" tile>
                        <v-icon dark> mdi-account-group </v-icon>
                    </v-avatar>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>群聊</v-list-item-title>
                </v-list-item-content>
            </v-list-item>  
      </div>
     </v-list>
    <v-list class="pa-0">
      <v-subheader>联系人</v-subheader>
      <div class="w-100 pa-5 d-flex justify-center" v-if="isGettingContactList">  
          <v-progress-circular
            indeterminate
            color="#7879ff"
            ></v-progress-circular>
      </div>
      <div class="w-100"
        v-for="(userGroup, i) in addressedUsers"
        :key="i"
        v-else
      >
        <div class="w-100 text-center mo-glow-bg">
            {{userGroup.letter}}
        </div>
        <v-list-item
            v-for="(user, j) in userGroup.data" :key="j" v-ripple
        >   
            <v-list-item-icon class="my-2">
                <v-avatar size="50" color="#49d29e" >
                    <v-img v-if="user.avatar !== '/'" :src="`${baseUrl}${user.avatar}`" :alt="user.name[0]" class="chat-user-avatar"></v-img>
                    <span dark v-else class="white--text headline"> {{user.name[0]}}</span>
                </v-avatar>
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title>{{user.name}}</v-list-item-title>
            </v-list-item-content>
            <!-- <v-divider light></v-divider> -->
        </v-list-item>
      </div>
    </v-list>
    <v-dialog
        v-model="addUserDialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition" >   
        <v-card>
            <v-toolbar
                dark
                color="indigo"
                tile
                class="mo-chat-index-nav"
                >
                <v-btn icon dark @click="closeAddDialog" >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-toolbar-title class="pl-0">新的朋友</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn dark text color="success" :disabled="willAddToContactUser.contactId == null" @click="addUserToContact" :loading="isAdding">
                        <v-icon left> mdi-plus </v-icon>
                        添加到地址簿
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-container class="cus-container">
                <v-col cols="12">
                    <v-row class="ma-0 pb-16">
                        <v-col cols="12" sm="6" md="4" lg="3" xl="2" v-for="user in users" :key="user.id" class="hover-cursor-point" @click="pushUserToList(user.id)">
                            <v-card color="cyan lighten-2" dark tile>
                                <div class="d-flex flex-no-wrap justify-space-between">
                                    <div>
                                        <v-card-title > {{user.name}}</v-card-title>
                                        <v-card-actions>
                                            <v-icon :color="willAddToContactUser.contactId == user.id ? 'success' : 'gray'" size="25">
                                                mdi-check-circle
                                            </v-icon>
                                        </v-card-actions>
                                    </div>
                                    <v-avatar class="ma-3" size="50" color="indigo">
                                        <v-img v-if="user.avatar !== '/'" :src="`${baseUrl}${user.avatar}`" :alt="user.name[0]" class="chat-user-avatar"></v-img>
                                        <span dark v-else class="white--text headline"> {{user.name[0]}}</span>
                                    </v-avatar>
                                </div>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
            </v-container>
        </v-card>
    </v-dialog>
    <v-snackbar
        timeout="3000"
        v-model="postFailed"
        color="error"
        absolute
        top
        >
        {{errorMessage}}
    </v-snackbar>
    <v-snackbar
        timeout="3000"
        v-model="postSuccess"
        color="success"
        absolute
        top
        >
        {{successMessage}}
    </v-snackbar>
  </v-card>
</template>

<script>
import pinyin from 'js-pinyin'
import { mapGetters } from 'vuex';
import { getUserList, getContactList, addUserToContact, postNewMsgCount, postNewGroup, removeContactUser, leaveGroup, removeGroup } from '~/api/chat'
export default {
    computed:{
        ...mapGetters({
            currentUser: 'auth/user',
            usersStore: 'chat/usersStore',
            contactListStore: 'chat/contactListStore',
            chatGroupListStore: 'chat/chatGroupListStore',
            addressedUsersStore: 'chat/addressedUsersStore',
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

    data: ()=> ({
        selectedUser: null,
        baseUrl: window.Laravel.base_url,
        addressedUsers: [],
        addUserDialog: false,
        contactList: [],
        chatGroupList: [],
        isNoContactList: false,
        isGettingContactList: false,
        willAddToContactUser : {
            contactId:null,
        },
        isAdding: false,
        errorMessage: '',
        successMessage: '', 
        postFailed : false,
        postSuccess : false,
        users: [],
    }),

    async created(){
        console.log(pinyin.getFullChars('管理员'));
        if(this.usersStore !== null){
            this.users = this.usersStore;
            this.addressedUsers = this.addressedUsersStore;
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
                this.$emit("updatechatwith", this.contactList[0]);
            }).catch((err) => {
                console.log(err);
            });
            this.isGettingContactList = false;
        }
        this.model = this.chatGroupList.length;
        console.log("this.contactList", this.contactList);
    },

    

    methods:{
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
        openAddUser(){
            this.addUserDialog = true;
        },

        closeAddDialog(){
            this.addUserDialog = false;
        },

        pushUserToList(id){
            this.willAddToContactUser.contactId = id;
        },

        async addUserToContact(){
            this.isAdding = true;
            if(this.willAddToContactUser.contactId == null){
                this.errorMessage = "请选择将添加到联系人的用户";
                this.postFailed = true;
            }
            await addUserToContact(this.willAddToContactUser)
            .then((res) => {
                this.successMessage = "成功添加到地址簿。"
                this.postSuccess = true;
                let addedContact = res.data.addedToContactUser[0];
                this.contactList.unshift(addedContact);
                this.isNoContactList = false;
                this.isGettingContactList = false;
                this.addUserDialog = false;
            }).catch((err) => {
                if(err.response.status == 409){
                    this.errorMessage = "您已经将该用户添加为联系人";
                    this.postFailed = true;
                }
                else{
                    this.errorMessage = "出问题了";
                    this.postFailed = true;
                }
            });
            this.isAdding = false;
            this.willAddToContactUser.contactId = null;
            this.addDialog = false;
        },
    }
}
</script>

<style>

</style>