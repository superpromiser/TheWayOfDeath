<template>
    <v-container class="pa-0">
        <v-row class="ma-0 bg-white justify-center position-relative" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold py-4">基本信息</p>
            <v-btn @click="updateProfile" :dark="isChanged" :disabled="!isChanged" :loading="isLoading" color="#7879ff" class="position-absolute put-align-center elevation-0" style="right: 12px; top:50%">
                保存
            </v-btn>
        </v-row>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="clickUploadImageBtn">
                <p class="mb-0 font-size-0-75">用户头像</p>
                <v-avatar color="#7879ff" size="60" class="rounded-lg"  >
                    <v-progress-circular v-if="isImageSelecting" indeterminate color="white" ></v-progress-circular>
                    <span v-else-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                    <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                </v-avatar>
                <input ref="imageUploader" class="d-none" type="file" accept="image/*" @change="onImageFileChanged">
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="$refs.userName.focus()">
                <p class="mb-0 font-size-0-75 w-100">用户名</p>
                <v-text-field v-model="user.name" ref="userName" hide-details dense color="#7879ff" class="mt-0 pt-0"></v-text-field>
            </v-col>
        </v-row>
        <v-divider></v-divider>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import {updateProfile} from '~/api/user'
import {uploadImage} from '~/api/upload'
import lang from '~/helper/lang.json'

export default {
    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        selectedImageFile: null,
        isImageSelecting: false,
        isLoading: false,
        oldName: '',
        oldAvatar: '',
        isChanged: false,
    }),
    computed:{
        ...mapGetters({
            user: 'auth/user',
        }),
    },
    watch:{
        user:{
            handler(val){
                if(val.avatar !== this.oldAvatar || val.name !== this.oldName){
                    this.isChanged = true;
                }
            },
            deep:true
        }
    },

    created(){
        this.oldName = this.user.name;
        this.oldAvatar = this.user.avatar;
    },

    methods:{
        clickUploadImageBtn() {
            window.addEventListener('focus', () => {
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
                }).catch((err) => {
                    //console.log(err);
                    this.isImageSelecting = false
                }); 
            }

            //reset image file input
            this.$refs.imageUploader.value = ''
            
        },

        async updateProfile(){
            if(this.user.name.trim() == ''){
                this.$snackbar.showMessage({content: '名称字段为空', color: 'error'});
            }
            let payload = {
                userName: this.user.name,
                avatar: this.user.avatar,
                userId: this.user.id
            }
            this.isLoading = true;
            await updateProfile(payload)
            .then((res) => {
                this.oldName = this.user.name;
                this.oldAvatar = this.user.avatar;
                this.isChanged = false;
                this.$snackbar.showMessage({content: '操作成功', color: 'success'})
            }).catch((err) => {
            });
            this.isLoading = false;
        }

    }
}
</script>

<style>

</style>