<template>
    <v-container>
        <v-row>
            <v-textarea
                clearable
                solo
                clear-icon="mdi-close-circle"
                :label="Label"
                value=""
                v-model="contentData.text"
            ></v-textarea>
        </v-row>
        <v-row>
            <v-btn
                color="blue accent-3"
                fab
                small
                dark
                class="ma-2"
                :loading="isImageSelecting"
                @click="clickUploadImageBtn"
            >
              <v-icon>mdi-file-image-outline</v-icon>
            </v-btn>
            <input
                ref="imageUploader"
                class="d-none"
                type="file"
                accept="image/*"
                @change="onImageFileChanged"
            >
            <v-btn
                color="blue accent-3"
                fab
                small
                dark
                class="ma-2"
                :loading="isVideoSelecting"
                @click="clickUploadVideoBtn"
            >
              <v-icon>mdi-video</v-icon>
            </v-btn>
            <input
                ref="videoUploader"
                class="d-none"
                type="file"
                accept="video/*"
                @change="onVideoFileChanged"
            >
            <v-btn
                color="blue accent-3"
                fab
                small
                dark
                class="ma-2"
                :loading="isFileSelecting"
                @click="clickUploadFileBtn"
            >
              <v-icon>mdi-file-upload</v-icon>
            </v-btn>
            <input
                ref="fileUploader"
                class="d-none"
                type="file"
                accept="file/*"
                @change="onFileFileChanged"
            >
        </v-row>
    </v-container>
</template>

<script>
import {uploadImage, uploadVideo, uploadOther} from '~/api/upload'
export default {
    props: {
        Label : {
            type: String,
            required: true
        }
    },
    data: () =>({
        contentData:{
            text:'',
            imgUrl:[],
            otherUrl:[],
            videoUrl:[]
        },
        selectedImageFile: null,
        selectedVideoFile: null,
        selectedFile: null,
        isImageSelecting: false,
        isVideoSelecting: false,
        isFileSelecting: false
    }),
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
                    console.log(res);
                    res = `/uploads/image/${res.data}`
                    this.contentData.imgUrl.push(res);
                    this.isImageSelecting = false
                    this.selectedImageFile = null
                }).catch((err) => {
                    console.log(err);
                    this.isImageSelecting = false
                });
            }
            console.log("^^^^^^^^^^^^^^^^", this.contentData.imgUrl);
        },
        clickUploadVideoBtn() {
            this.isVideoSelecting = true
            window.addEventListener('focus', () => {
                this.isVideoSelecting = false
            }, { once: true })
            this.$refs.videoUploader.click()
        },
        async onVideoFileChanged(e) {
            this.selectedVideoFile = e.target.files[0];
            if(this.selectedVideoFile !== undefined && this.selectedVideoFile !== null) {
                this.isVideoSelecting = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedVideoFile);
                await uploadVideo(fileData)
                .then((res) => {
                    console.log("video", res);
                    this.selectedVideoFile = null;
                    let url = `/uploads/video/${res.fileName}`
                    this.$set(res,'imgUrl',url)
                    this.contentData.videoUrl.push(res);
                    this.isVideoSelecting = false
                }).catch((err) => {
                    console.log(err);
                    this.isVideoSelecting = false
                });
            }
        },
        clickUploadFileBtn() {
            this.isFileSelecting = true
            window.addEventListener('focus', () => {
                this.isFileSelecting = false
            }, { once: true })
            this.$refs.fileUploader.click()
        },
        async onFileFileChanged(e) {
            this.selectedFile = e.target.files[0];
            if(this.selectedFile !== undefined && this.selectedFile !== null) {
                this.isFileSelecting = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedFile);
                await uploadOther(fileData)
                .then((res) => {
                    console.log("file", res);
                    this.selectedFile = null;
                    let url = `/uploads/other/${res.fileName}`;
                    this.$set(res,'imgUrl',url)
                    this.contentData.otherUrl.push(res);
                    this.isFileSelecting = false
                }).catch((err) => {
                    console.log(err);
                    this.isFileSelecting = false
                });
            }
        }
    }
}
</script>

<style>

</style>