<template>
    <v-col cols="12" sm="12" md="3" class="h-100 pa-0" >
        <div class="chat-search-user pa-5 d-flex align-center">
            <v-text-field label="按名称搜索" v-model="searchContact" filled rounded dense hide-details ></v-text-field>
            <v-btn class="ml-2" fab dark color="indigo" @click="addDialog = true" >
                <v-icon dark> mdi-plus </v-icon>
            </v-btn>
        </div>
        <div class="chat-contact-list">
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
                    color="indigo"
                >
                    <template>
                        <v-list v-for="(group, i) in chatGroupList" :key="'A'+ i" class="py-0 position-relative">
                            <v-list-item @click="updatechatIn(group, i)">
                                <v-avatar size="50" color="indigo" class="ma-3" tile>
                                    <span dark class="white--text headline"> {{group.room_id.roomName[0]}}</span>
                                </v-avatar>

                                <v-list-item-content>
                                    <v-list-item-title>{{group.room_id.roomName}}</v-list-item-title>
                                    <v-list-item-subtitle></v-list-item-subtitle>
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
                        <v-list v-if="bot !== null" class="py-0 position-relative">
                            <v-list-item @click="updatechatwith(bot)">
                                <v-avatar class="ma-3" v-if="bot.user.avatar == '/asset/img/bot/bot1.png'" size="50" color="indigo">
                                    <v-img :src="`${baseUrl}${bot.user.avatar}`" :alt="bot.user.name[0]" class="chat-user-avatar"></v-img>
                                </v-avatar>
                                <v-list-item-content>
                                    <v-list-item-title>{{bot.user.name}}</v-list-item-title>
                                    <v-list-item-subtitle></v-list-item-subtitle>
                                </v-list-item-content>
                                <div v-if="bot.new_msg_count !== 0" class="mr-8">
                                    <v-badge
                                        color="red"
                                        :content="bot.new_msg_count"
                                        >
                                    </v-badge>
                                </div>
                            </v-list-item>
                            <v-divider inset ></v-divider>
                        </v-list>
                        <v-list v-for="user in filteredContacts" :key="user.id" class="py-0 position-relative">
                            <v-list-item @click="updatechatwith(user)">
                                <v-badge bordered bottom v-if="checkOnline(user.user.id)"
                                    color="light-green accent-3" dot
                                    offset-x="10"
                                    offset-y="10" class="ma-3"
                                >
                                    <v-avatar size="50" color="indigo">
                                        <v-img v-if="user.user.avatar !== '/'" :src="`${baseUrl}${user.user.avatar}`" :alt="user.user.name[0]" class="chat-user-avatar"></v-img>
                                        <span dark v-else class="white--text headline"> {{user.user.name[0]}}</span>
                                    </v-avatar>
                                </v-badge>
                                <v-badge bordered bottom v-else
                                    color="blue-grey lighten-2" dot
                                    offset-x="10"
                                    offset-y="10" class="ma-3"
                                >
                                    <v-avatar size="50" color="indigo">
                                        <v-img v-if="user.user.avatar !== '/'" :src="`${baseUrl}${user.user.avatar}`" :alt="user.user.name[0]" class="chat-user-avatar"></v-img>
                                        <span dark v-else class="white--text headline"> {{user.user.name[0]}}</span>
                                    </v-avatar>
                                </v-badge>
                                
                                <v-list-item-content>
                                    <v-list-item-title>{{user.user.name}}</v-list-item-title>
                                    <v-list-item-subtitle></v-list-item-subtitle>
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
        <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
            v-model="addDialog"
            fullscreen
            hide-overlay
            persistent
            transition="dialog-bottom-transition" >   
            <v-card>
                <v-toolbar
                    dark
                    color="#7879ff"
                    >
                    <v-spacer></v-spacer>
                    <v-toolbar-title>选择一个用户</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn icon dark @click="closeAddDialog" >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <!-- <v-toolbar-items>
                        <v-btn dark text  @click="closeAddDialog" >
                        保存
                        </v-btn>
                    </v-toolbar-items> -->
                </v-toolbar>
                <v-container class="cus-container">
                    <v-row v-if="value == 0" class="ma-0">
                        <v-col cols="12">
                            <v-row class="ma-0 d-flex align-center px-3">
                                <v-text-field label="搜寻" filled rounded dense hide-details ></v-text-field>
                                <v-spacer></v-spacer>
                                <v-btn tile color="success" :disabled="willAddToContactUser.contactId == null" @click="addUserToContact" :loading="isAdding">
                                    <v-icon left> mdi-plus </v-icon>
                                    添加到地址簿
                                </v-btn>
                            </v-row>
                        </v-col>
                        <v-col cols="12">
                            <v-row class="ma-0 pb-16">
                                <v-col cols="6" sm="6" md="4" lg="3" xl="2" v-for="user in users" :key="user.id" class="hover-cursor-point" @click="pushUserToList(user.id)">
                                    <v-card color="#49d29e" dark tile>
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
                    </v-row>
                    <v-row v-else class="ma-0">
                         <v-col cols="12">
                            <v-row class="ma-0 d-flex align-center px-3">
                                <v-text-field label="搜寻" filled rounded dense hide-details ></v-text-field>
                                <v-spacer></v-spacer>
                                <v-btn tile color="success" :disabled="newGroup.length < 2" @click="openGroupNameDialog" :loading="isCreatingNewGroup">
                                    <v-icon left> mdi-plus </v-icon>
                                    建立群组
                                </v-btn>
                            </v-row>
                        </v-col>
                        <v-col cols="12">
                            <v-row class="ma-0 pb-16">
                                <v-col cols="6" sm="6" md="4" lg="3" xl="2" v-for="user in contactList" :key="user.user.id" class="hover-cursor-point" @click="pushUserToNewGroup(user.user.id)">
                                    <v-card color="#49d29e" dark tile>
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
                        <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'"  persistent v-model="groupNameDialog" transition="dialog-bottom-transition" max-width="500">   
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
                    <v-bottom-navigation
                        :value="value"
                        color="indigo"
                        grow
                        fixed
                        
                        horizontal
                        @change="onChangeBottomNavigation"
                    >
                        <v-btn>
                            <span>加入联络人</span>
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                        <!-- <v-btn>
                            <span>新组</span>
                            <v-icon>mdi-account-group</v-icon>
                        </v-btn> -->
                    </v-bottom-navigation>
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
    </v-col>
</template>

<script>
import lang from '~/helper/lang.json'
import { mapGetters } from 'vuex';
import { getUserList, getContactList, addUserToContact, postNewMsgCount, postNewGroup, removeContactUser, leaveGroup, removeGroup } from '~/api/chat'
export default {
    props:{
        ChatWith: {
            type: Number,
            required: false,
        },
        ChatIn: {
            type: Number,
            required: false,
        },
    },
    watch: {
        groupNameDialog (val) {
            val || this.close()
        },
    },
    components:{
        
    },
    data: ()=> ({
        lang,
        model: -1,
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

        bot: null,
    }),

    mounted(){
        
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
                this.users = this.users.filter((user) => user.avatar !== '/asset/img/bot/bot1.png');
                this.users.map( user => {
                    user['isSelected'] = false;
                    
                })


                this.$store.dispatch('chat/storeUsers',this.users)
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
                console.log("this.contactList",this.contactList);
                this.contactList.map(contact => {
                    if(contact.user.avatar == '/asset/img/bot/bot1.png'){
                        this.bot = contact;
                        console.log("this.bot",this.bot);
                    }
                })
                this.contactList = this.contactList.filter((user) => user.user.avatar !== '/asset/img/bot/bot1.png');

                this.$store.dispatch('chat/storeContactList',this.contactList)
                this.$store.dispatch('chat/storeGroupList',this.chatGroupList)
                if(this.chatGroupList.length == 0 && this.contactList.length == 0){
                    this.isNoContactList = true;
                }
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
    },

    methods: {
        onChangeBottomNavigation(val){
            this.value = val;
            this.willAddToContactUser.contactId = null;
        },
        pushUserToList(id){
            this.willAddToContactUser.contactId = id;
        },
        closeAddDialog(){
            this.addDialog = false;
            this.willAddToContactUser.contactId = null;
        },
        async addUserToContact(){
            this.isAdding = true;
            if(this.willAddToContactUser.contactId == null){
                this.$snackbar.showMessage({content: '请选择将添加到联系人的用户', color:'error'})
            }
            await addUserToContact(this.willAddToContactUser)
            .then((res) => {
                this.$snackbar.showMessage({content: "成功添加到地址簿", color: 'success'});
                let addedContact = res.data.addedToContactUser[0];
                this.contactList.unshift(addedContact);
                this.isNoContactList = false;
                this.isGettingContactList = false;
            }).catch((err) => {
                if(err.response.status == 409){
                    this.$snackbar.showMessage({content: '您已经将该用户添加为联系人', color:'error'})
                }
                else{
                    this.$snackbar.showMessage({content: '出问题了', color:'error'})
                }
            });
            this.isAdding = false;
            this.willAddToContactUser.contactId = null;
            this.addDialog = false;
        },

        updatechatwith(userInfo) {
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
            Echo.private('newMessage.'+ this.currentUser.id)
                .listen('NewMessage', (message) => {
                    if ( message.message.to == this.currentUser.id ) {
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
                    else if(message.message.roomId !== null){
                        if ( (((message.message.roomId.invited)).includes(this.currentUser.id) || message.message.roomId.userId == this.currentUser.id ) && message.message.from.id !== this.currentUser.id  ) {
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

        createNewGroup(){
            if(this.groupName.trim() == ''){
                return this.close();
            }
            let payload = {
                newgroup: this.newGroup,
                groupName: this.groupName
            }
            this.isCreatingNewGroup = true;
            postNewGroup(payload)
            .then(res=>{
                this.chatGroupList.unshift(res.data.newGroup);
                this.isCreatingNewGroup = false;
                this.close();
                this.willAddToContactUser.contactId = null;
                this.value = 0
                this.addDialog = false;
                this.isNoContactList = false;
            })
            .catch(err=>{
                this.isCreatingNewGroup = false;
                console.log(err.response);
            })
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
            removeContactUser(payload)
            .then(res=>{
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
    }   
}
</script>

<style>

</style>