<template>
    <v-col cols="12" sm="12" md="3" class="h-100 pa-0" >
        <div class="chat-search-user pa-5 d-flex align-center">
            <v-text-field label="按名称搜索" v-model="searchContact" filled rounded dense hide-details ></v-text-field>
            <v-btn class="ml-2" fab dark color="indigo" @click="addDialog = true" >
                <v-icon dark> mdi-plus </v-icon>
            </v-btn>
        </div>
        <div class="chat-contact-list">
            <v-list three-line class="py-0">
                <v-list-item-group
                    v-model="model"
                    mandatory
                    color="indigo"
                >   
                    <template>
                        <v-list v-for="user in filteredContacts" :key="user.id" class="py-0">
                            <v-list-item @click="updatechatwith(user)">
                                <v-avatar class="ma-3" size="50" color="indigo">
                                    <v-img v-if="user.user.avatar !== '/'" :src="`${baseUrl}${user.user.avatar}`" :alt="user.user.name[0]" class="chat-user-avatar"></v-img>
                                    <span dark v-else class="white--text headline"> {{user.user.name[0]}}</span>
                                </v-avatar>
                                <v-list-item-content>
                                    <v-list-item-title>{{user.user.name}}</v-list-item-title>
                                    <v-list-item-subtitle>asdf</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider inset ></v-divider>
                        </v-list>
                    </template>
                </v-list-item-group>
            </v-list>
        </div>
        <v-dialog
            v-model="addDialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition" >   
            <v-card>
                <v-toolbar
                    dark
                    color="indigo"
                    >
                    <v-btn icon dark @click="closeAddDialog" >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Settings</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark text  @click="closeAddDialog" >
                        Save
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <v-container class="cus-container">
                    <v-row v-if="value == 0" class="ma-0">
                        <v-col cols="12">
                            <v-row class="ma-0 d-flex align-center px-3">
                                <v-text-field label="Filled" filled rounded dense hide-details ></v-text-field>
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
                    </v-row>
                    <v-row v-else class="ma-0">
                        favourite
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
                        <v-btn>
                            <span>新组</span>
                            <v-icon>mdi-account-group</v-icon>
                        </v-btn>
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
import { mapGetters } from 'vuex';
import { getUserList, getContactList, addUserToContact, postNewMsgCount } from '~/api/chat'
export default {
    components:{
        
    },
    data: ()=> ({
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
    }),

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
                this.$store.dispatch('chat/storeContactList',this.contactList)
                this.$store.dispatch('chat/storeGroupList',this.chatGroupList)
                if(this.chatGroupList.length == 0 && this.contactList.length == 0){
                    this.isNoContactList = true;
                }
                // console.log("this.contactList", this.contactList);
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
        console.log("this.contactList", this.contactList);
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

        updatechatwith(userInfo) {
            for(let i = 0; i < this.contactList.length; i++){
                if( userInfo.user.id == this.contactList[i].contactUserId ){
                    this.totalNewMessageCount = this.totalNewMessageCount - this.contactList[i].new_msg_count;
                    this.$store.dispatch('chat/storeTotalNewMsgCount',this.totalNewMessageCount)
                    this.contactList[i].new_msg_count = 0;

                    postNewMsgCount({new_msg_count:this.contactList[i]})
                    .then((res) => {
                        console.log(res)
                    }).catch((err) => {
                        console.log(err)
                    });
                }
            }
            this.$emit("updatechatwith", userInfo);
        },
    }   
}
</script>

<style>

</style>