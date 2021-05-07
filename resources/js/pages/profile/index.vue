<template>
    <v-container v-if="$isMobile()" class="pa-0 h-100 bg-secondary" 
    v-touch="{
      left: () => swipe('Left'),
      right: () => swipe('Right'),
    }">
        <v-row class="ma-0">
            <router-view></router-view>
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

        

    },
}
</script>

<style>

</style>