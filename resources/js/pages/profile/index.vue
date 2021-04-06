<template>
    <v-container v-if="$isMobile()">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <div class="text-center mo-glow-inverse pa-4">
                    <v-avatar class="mo-glow-small-shadow" size="164" tile>
                        <v-img :src="`${baseUrl}${user.avatar}`" alt="postItem" width="164" height="164" ></v-img>
                    </v-avatar>
                    <h2 class="mt-3">{{user.name}}</h2>
                    <h3 v-if="user.roleId == 5" class="mt-3">学号: {{user.cardNum}}</h3>
                </div>
            </v-col>
        </v-row>
        <v-row class="ma-0 mt-5 justify-space-between">
            <v-col cols="5" class="mo-glow d-flex align-center justify-center">
                <div class="text-center pa-4"
                    v-touch="{
                        start: () => { isActiveStatus = true },
                        end: () => { isActiveStatus = false },
                        }"
                    v-bind:class="{ 'mo-glow-inverse': isActiveStatus, 'mo-glow': !isActiveStatus }"
                    @click="onClickStatus">
                    <v-icon size="65" color="#7879ff">mdi-plus</v-icon>
                    <h3>状态</h3>
                </div>
            </v-col>
            <v-col cols="5" class="mo-glow d-flex align-center justify-center">
                <div class="text-center pa-4"
                    v-touch="{
                        start: () => { isActivePhone = true },
                        end: () => { isActivePhone = false },
                        }"
                    v-bind:class="{ 'mo-glow-inverse': isActivePhone, 'mo-glow': !isActivePhone }"
                    @click="onClickPhone">
                    <v-icon size="65" color="#7879ff">mdi-phone</v-icon>
                    <h3>手机号</h3>
                </div>
            </v-col>
        </v-row>
        <v-row class="ma-0 mt-5 justify-space-between">
            <v-col cols="5" class="mo-glow d-flex align-center justify-center">
                <div class="text-center pa-4"
                    v-touch="{
                        start: () => { isActivePassword = true },
                        end: () => { isActivePassword = false },
                        }"
                    v-bind:class="{ 'mo-glow-inverse': isActivePassword, 'mo-glow': !isActivePassword }"
                    @click="onClickPassword">
                    <v-icon size="65" color="#7879ff">mdi-lock</v-icon>
                    <h3>修改密码</h3>
                </div>
            </v-col>
            <v-col cols="5" class="mo-glow d-flex align-center justify-center">
                <div class="text-center pa-4"
                    v-touch="{
                        start: () => { isActiveDoc = true },
                        end: () => { isActiveDoc = false },
                        }"
                    v-bind:class="{ 'mo-glow-inverse': isActiveDoc, 'mo-glow': !isActiveDoc }"
                    @click="onClickDoc">
                    <v-icon size="65" color="#7879ff">mdi-file-account</v-icon>
                    <h3>我的文件</h3>
                </div>
            </v-col>
        </v-row>
        <v-row class="ma-0 mt-5 justify-space-between">
            <v-col cols="5" class="mo-glow d-flex align-center justify-center">
                <div class="text-center pa-4"
                    v-touch="{
                        start: () => { isActiveSchoolFile = true },
                        end: () => { isActiveSchoolFile = false },
                        }"
                    v-bind:class="{ 'mo-glow-inverse': isActiveSchoolFile, 'mo-glow': !isActiveSchoolFile }"
                    @click="onClickSchoolFile">
                    <v-icon size="65" color="#7879ff">mdi-school</v-icon>
                    <h3>教师发展档案</h3>
                </div>
            </v-col>
            <v-col cols="5" class="mo-glow d-flex align-center justify-center">
                <div class="text-center pa-4"
                    v-touch="{
                        start: () => { isActiveShare = true },
                        end: () => { isActiveShare = false },
                        }"
                    v-bind:class="{ 'mo-glow-inverse': isActiveShare, 'mo-glow': !isActiveShare }"
                    @click="onClickShare">
                    <v-icon size="65" color="#7879ff">mdi-share-variant</v-icon>
                    <h3>个人分享</h3>
                </div>
            </v-col>
        </v-row>
        <v-row class="ma-0 mt-5 justify-center">
            <v-col cols="5" class="mo-glow d-flex align-center justify-center">
                <div class="text-center pa-4"
                    v-touch="{
                        start: () => { isActiveSetting = true },
                        end: () => { isActiveSetting = false },
                        }"
                    v-bind:class="{ 'mo-glow-inverse': isActiveSetting, 'mo-glow': !isActiveSetting }"
                    @click="onClickSetting">
                    <v-icon size="65" color="#7879ff">mdi-cog</v-icon>
                    <h3>设置</h3>
                </div>
            </v-col>
        </v-row>
    </v-container>
    <v-container v-else class="pa-0">
        <RouterBack title="我的"></RouterBack>
        <v-row class="ma-0">
            <router-view></router-view>
        </v-row>
    </v-container>
</template>

<script>
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
        }
    },
}
</script>

<style>

</style>