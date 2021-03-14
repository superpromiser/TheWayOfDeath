<template>
    <v-container>
        <v-row>
            <!-- {{index}} -->
            <v-textarea
                clearable
                solo
                clear-icon="mdi-close-circle"
                :label="Label"
                value=""
                v-model="contentData.text"
                hide-details
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
        <!--  IMAGE VIEWER  -->
        <v-row>
            <v-col v-for="(imgUrl, index) in contentData.imgUrl" :key="index" cols="6" sm="4" md="3" lg="2" class="position-relative">
                <v-btn
                    icon
                    color="pink"
                    class="position-absolute remove-uploaded-item-icon"
                    @click="removeUploadItem('image', index)"
                    :loading="imgUrl.isDeleting"
                    >
                    <v-icon size="25">mdi-trash-can-outline</v-icon>
                </v-btn>
                <v-img :src="`${baseUrl}${imgUrl.path}`" alt="upload image" class="uploaded-image" ></v-img>
            </v-col>
        </v-row>
        <!--  VIDEO VIEWER  -->
        <v-row>
            <v-col v-for="(video, index) in contentData.videoUrl" :key="index" cols="6" sm="4" md="4" lg="3" class="position-relative">
                <v-card
                    class="d-flex align-center "
                    color="grey lighten-2"
                    flat
                    tile
                >
                    <img :src="`${baseUrl}/asset/img/upload_video_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="">
                        <div><span><strong>{{video.fileOriName}}</strong></span></div>
                        <div>{{video.fileSize}}</div>
                    </div>
                    <v-btn
                        icon
                        color="pink"
                        class="ml-auto"
                        @click="removeUploadItem('video', index)"
                        :loading="video.isDeleting"
                        >
                        <v-icon size="25">mdi-trash-can-outline</v-icon>
                    </v-btn>
                </v-card>
            </v-col>
        </v-row>
        <!--  FILE VIEWER  -->
        <v-row>
            <v-col v-for="(other, index) in contentData.otherUrl" :key="index" cols="6" sm="4" md="4" lg="3" class="position-relative">
                <v-card
                    class="d-flex align-center "
                    color="grey lighten-2"
                    flat
                    tile
                >
                    <img :src="`${baseUrl}/asset/img/upload_file_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="">
                        <div><span><strong>{{other.fileOriName}}</strong></span></div>
                        <div>{{other.fileSize}}</div>
                    </div>
                    <v-btn
                        icon
                        color="pink"
                        class="ml-auto"
                        @click="removeUploadItem('other', index)"
                        :loading="other.isDeleting"
                        >
                        <v-icon size="25">mdi-trash-can-outline</v-icon>
                    </v-btn>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {uploadImage, uploadVideo, uploadOther, deleteFile} from '~/api/upload'
export default {
    props: {
        Label : {
            type: String,
            required: true
        },
        index :{
            type:Number,
            required: false
        }
    },
    data: () =>({
        baseUrl:window.Laravel.base_url,
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
        isFileSelecting: false,
        deleteItem : null,
    }),

    mounted(){
        console.log(this.index)
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
                    let imgObj = {
                        path : `/uploads/image/${res.data}`,
                        isDeleting : false,
                    }
                    this.contentData.imgUrl.push(imgObj);
                    this.isImageSelecting = false
                    this.selectedImageFile = null
                }).catch((err) => {
                    console.log(err);
                    this.isImageSelecting = false
                }); 
            }

            //reset image file input
            this.$refs.imageUploader.value = ''
            
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
                    this.selectedVideoFile = null;
                    let url = `/uploads/video/${res.data.fileName}`
                    this.$set(res.data,'imgUrl',url)
                    this.$set(res.data,'isDeleting',false)
                    this.contentData.videoUrl.push(res.data);
                    this.isVideoSelecting = false
                }).catch((err) => {
                    console.log(err);
                    this.isVideoSelecting = false
                });
            }
            //reset video file input
            this.$refs.videoUploader.value = ''
        },
        clickUploadFileBtn() {
            this.isFileSelecting = true
            window.addEventListener('focus', () => {
                this.isFileSelecting = false
            }, { once: true })
            this.$refs.fileUploader.click()
        },
        async onFileFileChanged(e) {
            console.log("123");
            this.selectedFile = e.target.files[0];
            if(this.selectedFile !== undefined && this.selectedFile !== null) {
                this.isFileSelecting = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedFile);
                await uploadOther(fileData)
                .then((res) => {
                    this.selectedFile = null;
                    let url = `/uploads/other/${res.data.fileName}`;
                    this.$set(res.data,'imgUrl',url)
                    this.$set(res.data,'isDeleting',false)
                    this.contentData.otherUrl.push(res.data);
                    this.isFileSelecting = false
                }).catch((err) => {
                    console.log(err);
                    this.isFileSelecting = false
                });
            }
            //reset file input
            this.$refs.fileUploader.value = ''
        },

        async removeUploadItem(type, index){
            switch (type) {
                case "image":
                    this.deleteItem = this.contentData.imgUrl[index];
                    await this.deleteFileFromServer('image');
                    this.contentData.imgUrl.splice(index, 1)
                    break;
                case "video":
                    this.deleteItem = this.contentData.videoUrl[index];
                    await this.deleteFileFromServer('video');
                    this.contentData.videoUrl.splice(index, 1)
                    break;
                case "other":
                    this.deleteItem = this.contentData.otherUrl[index];
                    await this.deleteFileFromServer('other');
                    this.contentData.otherUrl.splice(index, 1)
                    break;
            }
            // this.deleteItem = null;
        },

        async deleteFileFromServer(type){
            this.deleteItem.isDeleting = true;
            let filePath = '';
            if (type == 'image'){
                filePath = this.deleteItem.path;
            }
            else{
                filePath = this.deleteItem.imgUrl
            }
            await deleteFile(filePath)
            .then((res) => {
                console.log(res)
                this.deleteItem.isDeleting = false;
            }).catch((err) => {
                console.log(err);
                this.deleteItem.isDeleting = false;
            });

        },

        emitData(){
            if (this.contentData.text == ''){
                
            }
            this.$emit('contentData',this.contentData);
        }
    }
}
</script>

<style>

</style>