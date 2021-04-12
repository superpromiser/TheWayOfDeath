<template>
    <v-container v-if="$isMobile()" class="pa-0 h-100" 
    v-touch="{
      left: () => swipe('Left'),
      right: () => swipe('Right'),
    }">
        <v-row class="ma-0 pt-10">
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
        <v-divider light class="thick-border"></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
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
        <v-divider light class="thick-border"></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
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
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
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
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
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
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
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
        <v-divider light class=" thick-border"></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
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
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
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
        <v-divider light class=" thick-border"></v-divider>
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
                    <p class="mb-0 font-size-0-75 ml-3">登出</p>
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
    <v-container v-else class="pa-0">
        <RouterBack title="我的"></RouterBack>
        <v-row class="ma-0">
            <router-view></router-view>
        </v-row>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import { mapGetters } from 'vuex';
import {uploadImage} from '~/api/upload'
import {updateProfile} from '~/api/user'
import RouterBack from '~/components/routerBack'
export default {
    components:{
        RouterBack
    },
    computed:{
        ...mapGetters({
            user: 'auth/user',

        }),
    },
    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        isActiveStatus: false,
        isActivePhone: false,
        isActivePassword: false,
        isActiveDoc: false,
        isActiveSchoolFile: false,
        isActiveShare: false,
        isActiveSetting: false,

        selectedImageFile: null,
        isImageSelecting: false,
        logoutDialog: false,
        isLogout: false,
    }),
    methods:{
        onClickStatus(){
            console.log("status")
        },
        onClickPhone(){
            console.log("phone")
        },
        onClickPassword(){
            console.log("password")
        },
        onClickDoc(){
            console.log("doc")
        },
        onClickSchoolFile(){
            console.log("schoolFile")
        },
        onClickShare(){
            console.log("share")
        },
        onClickSetting(){
            console.log("setting")
        },


        checkUserStatus(){
            switch (this.user.status) {
                case 0:
                    return "happpy"
                case 1:
                    return "sad"    
            
            }
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
                    this.user.avatar = path;
                    this.isImageSelecting = false
                    this.selectedImageFile = null
                    this.updateUserAvatar();
                }).catch((err) => {
                    //console.log(err);
                    this.isImageSelecting = false
                }); 
            }

            //reset image file input
            this.$refs.imageUploader.value = ''
            
        },

        clickUploadImageBtn() {
            this.isImageSelecting = true
            window.addEventListener('focus', () => {
                this.isImageSelecting = false
            }, { once: true })
            this.$refs.imageUploader.click()
        },

        async updateUserAvatar(){
            await updateProfile()
            .then((res) => {
                
            }).catch((err) => {
                
            });
        },

        swipe (direction) {
            console.log("direction", direction)
            if(direction == "Right"){
                this.$router.push({name: 'circle'});
            }
        },

        openLogoutDialog(){
            this.logoutDialog = true;
        },

        closeLogoutDialog(){
            this.logoutDialog = false;
        },

        async logout(){
            this.isLogout = true;
            // Log out the user.
            await this.$store.dispatch('auth/logout')
            this.isLogout = false;
            // Redirect to login.
            this.$router.push({ name: 'login' })
        },

    },
}
</script>

<style>

</style>