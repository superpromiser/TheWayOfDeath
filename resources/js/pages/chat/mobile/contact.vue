<template>
    <v-card class="mx-auto position-relative" tile elevation="0"> 
     <v-list class="pa-0" id="UP-go">
        <div class="w-100">
            <v-list-item v-ripple @click="openAddUser">
                <v-list-item-icon class="my-2">
                    <v-avatar size="50" color="#49d29e" class="rounded-lg">
                        <v-icon dark> mdi-plus </v-icon>
                    </v-avatar>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>新的朋友</v-list-item-title>
                </v-list-item-content>
            </v-list-item>  
            <v-divider inset></v-divider>
            <v-list-item v-ripple @click="openAddGroup">
                <v-list-item-icon class="my-2">
                    <v-avatar size="50" color="#49d29e" class="rounded-lg">
                        <v-icon dark> mdi-account-group </v-icon>
                    </v-avatar>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>群聊</v-list-item-title>
                </v-list-item-content>
            </v-list-item>  
      </div>
     </v-list>
    <v-list class="pa-0 pb-16">
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
        <div class="w-100 bg-secondary pl-4 py-1" :id="userGroup.letter=='#'? 'hash-go' : `${userGroup.letter}-go`">
            <p class="mb-0 font-size-0-8 font-color-gray">{{userGroup.letter}}</p>
        </div>
        <div  v-for="(user, j) in userGroup.data" :key="j">
            <v-list-item v-ripple >   
                <v-list-item-icon class="my-2">
                    <v-avatar size="50" color="#49d29e" class="rounded-lg">
                        <v-img v-if="user.avatar !== '/'" :src="`${baseUrl}${user.avatar}`" :alt="user.name[0]" class="chat-user-avatar"></v-img>
                        <span dark v-else class="white--text headline"> {{user.name[0]}}</span>
                    </v-avatar>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>{{user.name}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider inset v-if="(userGroup.data.length-1)!==j"></v-divider>
        </div>
      </div>
    </v-list>
    <div class="position-fixed put-align-center text-center" style="right: 10px; top: 50%">
        <div @touchmove.passive="moveParentAlphabet" @touchstart="startTouchParent" @touchend="endTouchParent"
            class="" v-for="alphabet in alphabetList" :key="alphabet.alphabet" style="touch-action: none;">
            <p v-if="alphabet.alphabet == 'UP'" class="mb-0 font-size-0-70 contact-alphabet">&#8593;</p>
            <p v-else class="mb-0 font-size-0-70 contact-alphabet" >{{alphabet.alphabet}}</p>
        </div>
    </div>
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
    <v-dialog
        v-model="createNewGroupDialog"
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
                <v-btn icon dark @click="closeAddGroup" >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-toolbar-title class="pl-0">群聊</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn dark text color="success" :disabled="newGroup.length < 2" @click="openGroupNameDialog" :loading="isCreatingNewGroup">
                        <v-icon left> mdi-plus </v-icon>
                        新的群聊
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-container class="cus-container">
                <v-row class="ma-0">
                    <v-col cols="12">
                        <v-row class="ma-0 pb-16">
                            <v-col cols="12" sm="6" md="4" lg="3" xl="2" v-for="user in contactList" :key="user.user.id" class="hover-cursor-point" @click="pushUserToNewGroup(user.user.id)">
                                <v-card color="cyan lighten-2" dark tile>
                                    <div class="d-flex flex-no-wrap justify-space-between">
                                        <div>
                                            <v-card-title > {{user.user.name}}</v-card-title>
                                            <v-card-actions>
                                                <v-icon :color="newGroup.includes(user.user.id) ? 'success' : 'gray'" size="25">
                                                    mdi-check-circle
                                                </v-icon>
                                            </v-card-actions>
                                        </div>
                                        <v-avatar class="ma-3" size="50" color="indigo">
                                            <v-img v-if="user.user.avatar !== '/'" :src="`${baseUrl}${user.user.avatar}`" :alt="user.user.name[0]" class="chat-user-avatar"></v-img>
                                            <span dark v-else class="white--text headline"> {{user.user.name[0]}}</span>
                                        </v-avatar>
                                    </div>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-dialog v-model="groupNameDialog" transition="dialog-bottom-transition" max-width="500">   
                        <v-card>
                            <v-card-text class="pa-5">
                                <v-text-field
                                    v-model="groupName"
                                    label="请输入群组名称"
                                    hide-details
                                ></v-text-field>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                color="blue darken-1"
                                text
                                @click="close"
                                >
                                {{lang.cancel}}
                                </v-btn>
                                <v-btn
                                color="blue darken-1"
                                text
                                :loading="isCreatingNewGroup"
                                @click="createNewGroup"
                                >
                                {{lang.save}}
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
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
import lang from '~/helper/lang.json'
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
        lang,
        selectedUser: null,
        baseUrl: window.Laravel.base_url,
        addressedUsers: [],
        addUserDialog: false,
        createNewGroupDialog: false,
        groupNameDialog: false,
        groupName: '',
        contactList: [],
        chatGroupList: [],
        newGroup: [],
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
        isCreatingNewGroup: false,
        alphabetList: [
                {
                    alphabet:'UP', 
                    touched: false
                },
                {
                    alphabet:'A', 
                    touched: false
                },
                {
                    alphabet:'B', 
                    touched: false
                },
                {
                    alphabet:'C',
                    touched: false
                },
                {
                    alphabet:'D',
                    touched: false
                },
                {
                    alphabet:'E',
                    touched: false
                },
                {
                    alphabet:'F',
                    touched: false
                },
                {
                    alphabet:'G',
                    touched: false
                },
                {
                    alphabet:'H',
                    touched: false
                },
                {
                    alphabet:'I', 
                    touched: false
                },
                {
                    alphabet:'J', 
                    touched: false
                },
                {
                    alphabet:'K', 
                    touched: false
                },
                {
                    alphabet:'L', 
                    touched: false
                },
                {
                    alphabet:'M', 
                    touched: false
                },
                {
                    alphabet:'N', 
                    touched: false
                },
                {
                    alphabet:'O', 
                    touched: false
                },
                {
                    alphabet:'P', 
                    touched: false
                },
                {
                    alphabet:'Q', 
                    touched: false
                },
                {
                    alphabet:'R', 
                    touched: false
                },
                {
                    alphabet:'S', 
                    touched: false
                },
                {
                    alphabet:'T', 
                    touched: false
                },
                {
                    alphabet:'U', 
                    touched: false
                },
                {
                    alphabet:'V', 
                    touched: false
                },
                {
                    alphabet:'W', 
                    touched: false
                },
                {
                    alphabet:'X', 
                    touched: false
                },
                {
                    alphabet:'Y', 
                    touched: false
                },
                {
                    alphabet:'Z', 
                    touched: false
                },
                {
                    alphabet:'#', 
                    touched: false
                },
            ],
        isMovedParentAlphabet: false,
        character: null,
        contactListNavOptions: {
            duration: 500,
            offset: 48,
            easing: 'easeInOutCubic',
        }
    }),

    async created(){
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
            }).catch((err) => {
                console.log(err);
            });
            this.isGettingContactList = false;
        }
        this.model = this.chatGroupList.length;
        console.log("this.contactList", this.contactList);
    },

    watch:{
        character:{
            handler(val){
                if(val == "↑"){
                    this.$vuetify.goTo('#UP-go', this.contactListNavOptions);
                }
                else if(val == "#"){
                    let el = document.getElementById('hash-go');
                    if(el!==null){
                        this.$vuetify.goTo('#hash-go', this.contactListNavOptions);
                    }
                }
                else{
                    let el = document.getElementById(`${val}-go`);
                    if(val !== null && el!==null){
                        this.$vuetify.goTo(`#${val}-go`, this.contactListNavOptions);
                    }
                }
            },
            deep: true
        }
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
                return this.$snackbar.showMessage({content: '请选择将添加到联系人的用户', color: 'error'})
            }
            await addUserToContact(this.willAddToContactUser)
            .then((res) => {
                this.$snackbar.showMessage({content: '成功添加到地址簿。', color :'success'})
                let addedContact = res.data.addedToContactUser[0];
                this.contactList.unshift(addedContact);
                this.isNoContactList = false;
                this.isGettingContactList = false;
                this.addUserDialog = false;
            }).catch((err) => {
                if(err.response.status == 409){
                    this.$snackbar.showMessage({content: '您已经将该用户添加为联系人', color: 'error'})
                }
                else{
                    this.$snackbar.showMessage({content: '出问题了', color: 'error'})
                }
            });
            this.isAdding = false;
            this.willAddToContactUser.contactId = null;
        },

        openGroupNameDialog(){
            this.groupNameDialog = true;
        },

        close () {
            this.groupNameDialog = false
            this.$nextTick(() => {
                this.groupName = '';
                this.newGroup = [];
            })
        },

        async createNewGroup(){
            if(this.groupName.trim() == ''){
                return this.close();
            }
            let payload = {
                newgroup: this.newGroup,
                groupName: this.groupName
            }
            console.log("this.newGroup",payload);
            this.isCreatingNewGroup = true;
            await postNewGroup(payload)
            .then(res=>{
                console.log(res.data);
                this.chatGroupList.unshift(res.data.newGroup);
                this.isCreatingNewGroup = false;
                this.close();
                this.willAddToContactUser.contactId = null;
                this.createNewGroupDialog = false;
                this.isNoContactList = false;
            })
            .catch(err=>{
                this.isCreatingNewGroup = false;
                console.log(err.response);
            })
            this.createNewGroupDialog = false;
        },
        
        pushUserToNewGroup(userId){
            if(this.newGroup.includes(userId)){
                for( let i = 0; i < this.newGroup.length; i++){ 
                    if ( this.newGroup[i] == userId) { 
                        this.newGroup.splice(i, 1); 
                    }
                }
            }
            else{
                this.newGroup.push(userId);
            }
        },

        openAddGroup(){
            this.createNewGroupDialog = true;
        },

        closeAddGroup(){
            this.createNewGroupDialog = false;

        },
        startTouchAlphabet(alphabet){
            console.log("start child")
            alphabet.touched = true;
        },

        endTouchAlphabet(alphabet){
            console.log("end child")
            alphabet.touched = false;
        },

        moveChildAlphabet(alphabet){
            console.log("move child", alphabet.alphabet, alphabet.touched)
            if (this.isMovedParentAlphabet == true){
                alphabet.touched = true;
            }
        },

        startParentAlphabet(){
            console.log("start parent")
            this.isMovedParentAlphabet = true;
        },
        endParentAlphabet(){
            console.log("end parent")
            this.isMovedParentAlphabet = false;
        },
        startTouchParent(e){
            let p = e.touches[0];
            let el = document.elementFromPoint(p.clientX, p.clientY);
            let childList =$('.contact-alphabet');
            for(let i = 0; i < childList.length ; i++){
                $(childList[i]).removeClass('active');
            }
            this.character = el.childNodes[0].data;
            $(el).addClass('active');
            $(el).attr('data-before',this.character);
        },

        endTouchParent(e){
            let childList =$('.contact-alphabet');
            for(let i = 0; i < childList.length ; i++){
                $(childList[i]).removeClass('active');
            }
            this.character = null;
        },

        moveParentAlphabet(e){
            let p = e.touches[0];
            let el = document.elementFromPoint(p.clientX, p.clientY);
            let childList =$('.contact-alphabet');
            for(let i = 0; i < childList.length ; i++){
                $(childList[i]).removeClass('active');
            }
            this.character = el.childNodes[0].data;
            $(el).addClass('active');
            if(this.character == 'UP'){
                $(el).attr('data-before',`\\2191`);
            }
            else{
                $(el).attr('data-before',this.character);
            }
        }
    }
}
</script>

<style>

</style>