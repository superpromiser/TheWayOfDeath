<template>
    <v-container class="mx-auto position-relative pa-0">
        <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
            <v-icon @click="backWithOutSelect" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >选择联系人</p>
            <v-btn @click="emitSelUsers" :disabled="selectedUserList.length == 0" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                完成 <span v-if="selectedUserList.length > 0">({{selectedUserList.length}})</span>
            </v-btn>
        </v-row>
        <v-list class="pa-0 pb-16">
            <div class="w-100 pa-5 d-flex justify-center" v-if="isGettingUserList">  
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
                    <v-list-item v-ripple @click="pushUserToList(user.id)">   
                        <v-icon v-if="selectedUserList.includes(user.id)" color="#49d29e" class="mr-3">mdi-check-circle</v-icon>
                        <v-icon v-else class="mr-3">mdi-checkbox-blank-circle-outline</v-icon>
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
                    <v-divider class="" v-if="(userGroup.data.length-1)!==j"></v-divider>
                </div>
            </div>
        </v-list>
        <div class="position-fixed put-align-center text-center pa-1" style="right: 10px; top: 50%">
            <div @touchmove.passive="moveParentAlphabet" @touchstart="startTouchParent" @touchend="endTouchParent"
                class="" v-for="alphabet in alphabetList" :key="alphabet.alphabet" style="touch-action: none;">
                <p class="mb-0 font-size-0-70 contact-alphabet" >{{alphabet.alphabet}}</p>
            </div>
        </div>
    </v-container>
</template>

<script>
import pinyin from 'js-pinyin'
import { mapGetters } from 'vuex';
import lang from '~/helper/lang.json'
import { getUserList,   } from '~/api/chat'

export default {
    computed:{
        ...mapGetters({
            currentUser: 'auth/user',
            usersStore: 'chat/usersStore',
            addressedUsersStore: 'chat/addressedUsersStore',
            publishSpecUserList: 'mo/publishSpecUserList',
            clickedChange: 'mo/clickedChange'
        }),
    },

    data: ()=> ({
        lang,
        users: [],
        selectedUserList: [],
        isGettingUserList: false,
        isSearching: false,
        searchKeyword: '',
        alphabetList: [
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
            this.isGettingUserList = true;
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
            this.isGettingUserList = false;
        }
        if(this.publishSpecUserList !== null){
            this.selectedUserList = this.publishSpecUserList
        }
    },

    watch:{
        character:{
            handler(val){
                if(val == "#"){
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
            $(el).attr('data-before',this.character);
            
        },
        onSearch(){
        },
        onFalseSearching(){
            this.isSearching = false;
            this.searchKeyword = '';
        },

        emitSelUsers(){
            console.log("this.selectedUserList", this.selectedUserList);
            this.$store.dispatch('mo/onBackWithoutSelect', false);
            this.$store.dispatch('mo/onPublishSpecUserList', this.selectedUserList);
            this.$router.go(-1);
        },

        pushUserToList( userId ){
            if(this.selectedUserList.includes(userId)){
                for( let i = 0; i < this.selectedUserList.length; i++){ 
                    if ( this.selectedUserList[i] == userId) { 
                        this.selectedUserList.splice(i, 1); 
                    }
                }
            }
            else{
                this.selectedUserList.push(userId);
            }
        },
        backWithOutSelect(){
            console.log("!!!!!!!!!!!!!!!", this.clickedChange);
            if(this.clickedChange==true){
                this.$store.dispatch('mo/onBackWithChange', true);
            }
            else{
                this.$store.dispatch('mo/onBackWithoutSelect', true);
            }
            this.$router.go(-1);
        }
    },
}
</script>

<style>

</style>