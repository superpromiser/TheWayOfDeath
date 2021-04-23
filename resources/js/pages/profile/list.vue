<template>
    <v-container v-if="$isMobile()" class="pa-0 ma-0">
        <v-row class="ma-0 pt-10"  @click="navToProfileItem('name')">
            <v-col cols="12" class="d-flex justify-space-between align-center pb-0">
                <div class="d-flex align-center">
                    <v-avatar color="#49d29e" size="60" class="rounded-lg"  >
                        <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                        <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                    </v-avatar>
                    <div class="ml-3">
                        <h3>{{user.name}}</h3>
                        <p class="mb-0 font-size-0-75"> 学号:{{user.cardNum}}</p>
                    </div>
                </div>
                <div class="d-flex align-center">
                    <v-icon color="#F19861" small>
                        mdi-qrcode
                    </v-icon>
                    <v-icon class="">
                        mdi-chevron-right
                    </v-icon>
                </div>
            </v-col>
            <v-col cols="12" class="pt-2" style="padding-left: 84px;">
                <v-btn color="#3989fc" outlined rounded small>
                    <v-icon left> mdi-plus </v-icon>
                    状态
                </v-btn>
            </v-col>
        </v-row>
        <div class="cus-divider"></div>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="navToProfileItem('phoneNumber')">
                <div class="d-flex align-center">
                    <v-icon color="#3989fc">
                        mdi-cellphone
                    </v-icon>
                    <p class="mb-0 font-size-0-75 ml-3">手机号</p>
                </div>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <div class="cus-divider"></div>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="navToProfileItem('wechat')">
                <div class="d-flex align-center">
                    <v-icon color="#49d29e">
                        mdi-wechat 
                    </v-icon>
                    <p class="mb-0 font-size-0-75 ml-3">微信账号</p>
                </div>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light ></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="navToProfileItem('qq')">
                <div class="d-flex align-center">
                    <v-icon color="#3989fc">
                        mdi-qqchat
                    </v-icon>
                    <p class="mb-0 font-size-0-75 ml-3">QQ账号</p>
                </div>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light ></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="navToProfileItem('password')">
                <div class="d-flex align-center">
                    <v-icon color="#49d29e">
                        mdi-lock-outline
                    </v-icon>
                    <p class="mb-0 font-size-0-75 ml-3">修改密码</p>
                </div>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light ></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="navToProfileItem('myfile')">
                <div class="d-flex align-center">
                    <v-icon color="#feb31a">
                        mdi-folder-outline
                    </v-icon>
                    <p class="mb-0 font-size-0-75 ml-3">我的文件</p>
                </div>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <div class="cus-divider"></div>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="navToProfileItem('schoolshare')">
                <div class="d-flex align-center">
                    <v-icon color="#7879ff">
                        mdi-book-outline
                    </v-icon>
                    <p class="mb-0 font-size-0-75 ml-3">教师发展档案</p>
                </div>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light ></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="navToProfileItem('myshare')">
                <div class="d-flex align-center">
                    <v-icon color="#F19861">
                        mdi-share-variant-outline
                    </v-icon>
                    <p class="mb-0 font-size-0-75 ml-3">个人分享</p>
                </div>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <div class="cus-divider"></div>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
                <div class="d-flex align-center">
                    <v-icon color="#7879ff">
                        mdi-cog-outline
                    </v-icon>
                    <p class="mb-0 font-size-0-75 ml-3">设置</p>
                </div>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light ></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="openLogoutDialog">
                <div class="d-flex align-center">
                    <v-icon color="#eb5846">
                        mdi-logout
                    </v-icon>
                    <p class="mb-0 font-size-0-75 ml-3">退出</p>
                </div>
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-dialog v-model="logoutDialog"  width="100%" max-width="500" >
            <v-card>
                <v-card-title class="title"> <v-icon color="#F19861" class="mr-2">mdi-alert-circle</v-icon> 您确定要注销吗？ </v-card-title>
                 <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn outlined rounded plain color="#feb31a" @click="closeLogoutDialog " >
                        {{lang.cancel}}
                    </v-btn>
                    <v-btn outlined rounded plain color="#eb5846" @click="logout " :loading="isLogout" >
                        {{lang.ok}}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>     
    </v-container>
    <v-container class="ma-0 pa-0" v-else>
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex justify-space-between align-center py-10 px-md-10" >
                <div class="pro-user-avatar d-flex align-center">
                    <v-avatar size="100" color="#49d29e" class="hover-cursor-point" @click="clickUploadImageBtn">
                        <v-img v-if="user.avatar !== '/'" :src="`${baseUrl}${user.avatar}`" :alt="user.name[0]"></v-img>
                        <span dark v-else class="white--text headline"> {{user.name[0]}}</span>
                    </v-avatar>
                    <input
                        ref="imageUploader"
                        class="d-none"
                        type="file"
                        accept="image/*"
                        @change="onImageFileChanged"
                    >
                    <div class="pro-user-name-phone ml-5">
                        <h2 class="hover-cursor-point" @click="onClickUpdateInfo('name')">{{user.name}}</h2>
                        <h3 class="hover-cursor-point mt-3" @click="onClickUpdateInfo('phoneNumber')">{{user.phoneNumber}}</h3>
                    </div>
                </div>
                <div class="pro-qr-code d-flex align-center">
                    <v-icon size="30">
                        mdi-qrcode
                    </v-icon>
                    <v-icon size="30" class="ml-5">
                        mdi-chevron-right
                    </v-icon>
                </div>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <!--   status  -->
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex align-center px-md-10" >
                <p class="mb-0 w-100">人员状态</p>
                <v-select
                    solo
                    :items="userStatusItem"
                    :menu-props="{ top: false, offsetY: true }"
                    item-text="label"
                    label="人员状态"
                    hide-details
                    v-model="currentStatus"
                    @change="onSelectStatus"
                    class="w-50"
                ></v-select>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <!--   password  -->
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex justify-space-between align-center py-5 px-md-10 hover-cursor-point" v-ripple @click="navToChangePassword" >
                <p class="mb-0">修改密码</p>
                <v-icon size="30" class="ml-5">
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <!--   wechat  -->
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex justify-space-between align-center py-5 px-md-10 hover-cursor-point" v-ripple @click="navToChangeWechat">
                <p class="mb-0">微信号</p>
                <v-icon size="30" class="ml-5">
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <!--   QQ  -->
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex justify-space-between align-center py-5 px-md-10 hover-cursor-point" v-ripple @click="navToChangeQQ">
                <p class="mb-0">QQ号</p>
                <v-icon size="30" class="ml-5">
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <!--   my file  -->
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex justify-space-between align-center py-5 px-md-10 hover-cursor-point" v-ripple @click="navToMyFile">
                <p class="mb-0">我的文件</p>
                <v-icon size="30" class="ml-5">
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light class="thick-border"></v-divider>
        <!--   teacher development file  -->
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex justify-space-between align-center py-5 px-md-10 hover-cursor-point" v-ripple @click="navToSchoolShare">
                <p class="mb-0">教师发展档案</p>
                <v-icon size="30" class="ml-5">
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <!--   sharing  -->
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex justify-space-between align-center py-5 px-md-10 hover-cursor-point" v-ripple @click="navToMyShare">
                <p class="mb-0">个人分享</p>
                <v-icon size="30" class="ml-5">
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light class="thick-border"></v-divider>
        <!--   group sorting  -->
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex justify-space-between align-center py-5 px-md-10 hover-cursor-point" v-ripple >
                <p class="mb-0">群组排序</p>
                <v-icon size="30" class="ml-5">
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <!--   help center -->
        <v-row class="ma-0 ">
            <v-col cols="12" class="d-flex justify-space-between align-center py-5 px-md-10 hover-cursor-point" v-ripple >
                <p class="mb-0">帮助中心</p>
                <v-icon size="30" class="ml-5">
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-dialog v-model="updateDialog" width="100%" max-width="500" scrollable>
            <v-card>
                <v-card-title class="title">
                    {{isName ? "更新名称" : "更新电话号码"}}
                </v-card-title>
            
                <v-card-text class="pt-5" >
                    <v-text-field
                        solo
                        v-model="temp"
                        :label="isName? '名称': '电话号码'"
                        :prepend-inner-icon="isName? 'mdi-account' :'mdi-phone'"
                        :counter="!isName ? 11 : null"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="#49d29e"
                        @click="closeUpdateDialog "
                    >
                        {{lang.cancel}}
                    </v-btn>
                    <v-btn
                        text
                        color="#49d29e"
                        @click="updateUserInfo "
                        :loading="isUpdating"
                    >
                        {{lang.ok}}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import {uploadImage} from '~/api/upload'
import {updateProfile} from '~/api/user'
import lang from '~/helper/lang.json'

export default {
    computed:{
        ...mapGetters({
            user: 'auth/user',
        }),
    },

    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        selectedImageFile: null,
        isImageSelecting: false,
        isName: false,
        isPhone: false,    
        updateDialog: false,
        isUpdating: false,
        temp: "",
        currentStatus: "",
        userStatusItem: [
            {
                label: "在办公室",
                value: "在办公室"
            },
            {
                label: "上课中",
                value: "上课中"
            },
            {
                label: "会议中",
                value: "会议中"
            },
            {
                label: "待客中",
                value: "待客中"
            },
            {
                label: "忙碌中",
                value: "忙碌中"
            },
            {
                label: "外出中",
                value: "外出中"
            },
        ],
        logoutDialog: false,
        isLogout: false,
    }),

    created(){
        console.log(this.user);
        switch (this.user.status) {
            case 1:
                this.currentStatus = "在办公室";
                break;
            case 2:
                this.currentStatus = "上课中";
                break;
            case 3:
                this.currentStatus = "会议中";
                break;
            case 4:
                this.currentStatus = "待客中";
                break;
            case 5:
                this.currentStatus = "忙碌中";
                break;
            case 6:
                this.currentStatus = "外出中";
                break;
        }
    },

    methods:{
        clickUploadImageBtn() {
            this.isImageSelecting = true
            window.addEventListener('focus', () => {
                this.isImageSelecting = false
            }, { once: true })
            this.$refs.imageUploader.click()
        },

        async onImageFileChanged(e) {
            this.selectedImageFile = e.target.files[0];
            if(this.selectedImageFile !== undefined && this.selectedImageFile !== null) {
                this.isImageSelecting = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedImageFile);
                await uploadImage(fileData)
                .then((res) => {
                    let path = `/uploads/image/${res.data}`;
                    this.user.avatar = path
                    this.isImageSelecting = false
                    this.selectedImageFile = null
                    this.updateAvatar(path)
                }).catch((err) => {
                    //console.log(err);
                    this.isImageSelecting = false
                }); 
            }

            //reset image file input
            this.$refs.imageUploader.value = ''
            
        },

        updateAvatar(path){
            let payload = {
                userId : this.user.id,
                avatar : path
            }
            updateProfile(payload)
            .then((res) => {
                console.log(res);
            }).catch((err) => {
                
            });
        },

        closeUpdateDialog(){
            this.updateDialog = false;
            this.isName = false;
            this.isPhone = false;
            this.temp = "";
        },

        onClickUpdateInfo(key){
            if(key == "name"){
                this.isName = true;
                this.temp = this.user.name
            }
            else if(key == "phoneNumber"){
                this.isName = false;
                this.temp = this.user.phoneNumber;
            }
            this.updateDialog = true;
        },

        async updateUserInfo(){
            let payload = {};
            if(this.isName == true){
                payload = {
                    userId: this.user.id,
                    userName: this.temp
                }
            }
            else{
                payload = {
                    userId: this.user.id,
                    phoneNumber: this.temp
                }
            }
            this.isUpdating = true;
            await updateProfile(payload)
            .then((res) => {
                console.log(res)
                if(this.isName == true){
                    this.user.name = this.temp;
                }
                else{
                    this.user.phoneNumber = this.temp;
                }

            }).catch((err) => {
                
            });
            this.isName = false;
            this.temp = ""
            this.updateDialog = false;
            this.isUpdating = false;
        },

        convertStatus(){
            switch (this.user.status) {
                case 1:
                    this.currentStatus = "在办公室";
                case 2:
                    this.currentStatus = "上课中";
                case 3:
                    this.currentStatus = "会议中";
                case 4:
                    this.currentStatus = "待客中";
                case 5:
                    this.currentStatus = "忙碌中";
                case 6:
                    this.currentStatus = "外出中";
            }
        },

        onSelectStatus(val){
            let payload = {
                userId: this.user.id,
                status : null,
            }
            switch (val) {
                case '在办公室':
                    payload.status = 1;
                    break;
                case '上课中':
                    payload.status = 2;
                    break;
                case '会议中':
                    payload.status = 3;
                    break;
                case '待客中':
                    payload.status = 4;
                    break;
                case '忙碌中':
                    payload.status = 5;
                    break;
                case '外出中':
                    payload.status = 6;
                    break;
            }
            updateProfile(payload)
            .then((res) => {
                console.log(res)
            }).catch((err) => {
                
            });
        },

        navToChangePassword(){
            this.$router.push({name: "profile.password"})
        },
        navToChangeWechat(){
            this.$router.push({name: "profile.wechat"})
        },
        navToChangeQQ(){
            this.$router.push({name: "profile.qq"})
        },
        navToMyFile(){
            this.$router.push({name: "profile.myfile"})
        },
        navToMyShare(){
            this.$router.push({name: "profile.myshare"})
        },
        navToSchoolShare(){
            this.$router.push({name: "profile.schoolshare"})
        },

        async logout(){
            this.isLogout = true;
            // Log out the user.
            await this.$store.dispatch('auth/logout')
            this.isLogout = false;
            // Redirect to login.
            this.$router.push({ name: 'login' })
        },

        navToProfileItem(item){
            console.log(item);
            switch (item) {
                case 'password':
                    this.$router.push({name: 'profile.passwordMo'});
                    break;
                case 'name':
                    this.$router.push({name: 'profile.name'});
                    break;
                case 'phoneNumber':
                    this.$router.push({name: 'profile.phone'});
                    break;
                case 'wechat':
                    this.$router.push({name: 'profile.wechat'});
                    break;
                case 'qq':
                    this.$router.push({name: 'profile.qq'});
                    break;
                case 'myfile':
                    this.$router.push({name: 'profile.myfile'});
                    break;
                case 'myshare':
                    this.$router.push({name: 'profile.myshare'});
                    break;
                case 'schoolshare':
                    this.$router.push({name: 'profile.schoolshare'});
                    break;
            }
        },
        openLogoutDialog(){
            this.logoutDialog = true;
        },

        closeLogoutDialog(){
            this.logoutDialog = false;
        },
    }
}
</script>

<style>

</style>