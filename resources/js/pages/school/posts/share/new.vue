<template>
    <v-container v-if="$isMobile()"  class="ma-0 pa-0 h-100">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.share}}</p>
                <v-btn @click="submit" :loading="isSubmit" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0 text-area-without-nav-bottom" @click="$refs.textarea.focus()" style="">
                <v-col cols="12">
                    <v-textarea
                        class="v-textarea-cus-border-0 mt-0 pt-0"
                        auto-grow
                        color="#7879ff"
                        clear-icon="mdi-close-circle"
                        label="輸入内容"
                        v-model="contentData.text"
                        hide-details
                        rows="5"
                        solo
                        ref="textarea"
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-gray-light-dark">
                <v-col cols="2" @click="clickUploadImageBtn" class="d-flex justify-center align-center py-1" v-ripple>
                    <v-icon size="30">mdi-file-image-outline</v-icon>
                </v-col>
                <input
                    ref="imageUploader"
                    class="d-none"
                    type="file"
                    accept="image/*"
                    @change="onImageFileChanged"
                >
                <v-col cols="2" class="d-flex justify-center align-center py-1" v-ripple>
                    <p class="mb-0 pb-1" style="font-size: 25px; color:#676767; font-weight: bold">@</p>
                </v-col>
                <v-col cols="2" class="d-flex justify-center align-center py-1" v-ripple>
                    <p class="mb-0" style="font-size: 25px; color:#676767; font-weight: bold">#</p>
                </v-col>
                <v-col @click="clickUploadVideoBtn" cols="2" class="d-flex justify-center align-center py-1" v-ripple>
                    <v-icon size="30">mdi-play-box-outline </v-icon>
                </v-col>
                <input
                    ref="videoUploader"
                    class="d-none"
                    type="file"
                    accept="video/*"
                    @change="onVideoFileChanged"
                >
                <v-col cols="2" class="d-flex justify-center align-center py-1" v-ripple>
                    <v-icon size="30">mdi-emoticon-excited-outline</v-icon>
                </v-col>
                <v-col @click="clickUploadFileBtn" cols="2" class="d-flex justify-center align-center py-1" v-ripple>
                    <v-icon size="30">mdi-folder-outline</v-icon>
                </v-col>
                <input
                    ref="fileUploader"
                    class="d-none"
                    type="file"
                    accept="file/*"
                    @change="onFileFileChanged"
                >
                <v-btn rounded color="#E0E0E0" small elevation="0" class="position-absolute font-color-gray-dark-btn" style="top: -45px; left: 12px;"> <v-icon left>mdi-buffer</v-icon>模板</v-btn>
                <v-btn rounded color="#E0E0E0" small elevation="0" class="position-absolute font-color-gray-dark-btn" style="top: -45px; right: 12px;"> <v-icon left>mdi-earth</v-icon>公开</v-btn>
            </v-row>

            <!--  IMAGE VIEWER  -->
            <v-row class="ma-0">
                <v-col v-for="(imgUrl, index) in contentData.imgUrl" :key="index" cols="12" sm="4" md="3" lg="2" class="position-relative py-1">
                    <v-btn
                        icon
                        class="position-absolute remove-uploaded-item-icon mr-2"
                        @click="removeUploadItem('image', index)"
                        :loading="imgUrl.isDeleting"
                        color="pink"
                        >
                        <v-icon size="25">mdi-trash-can-outline</v-icon>
                    </v-btn>
                    <v-img :src="`${baseUrl}${imgUrl.path}`" alt="upload image" class="uploaded-image" ></v-img>
                </v-col>
            </v-row>
            <!--  VIDEO VIEWER  -->
            <v-row class="ma-0">
                <v-col v-for="(video, index) in contentData.videoUrl" :key="index" cols="12" sm="4" md="4" lg="3" class="position-relative py-1">
                    <v-card
                        class="d-flex align-center mo-glow-bg"
                        flat
                        tile
                    >
                        <img :src="`${baseUrl}/asset/img/upload_video_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                        <div class="font-size-0-75">
                            <div><span><strong>{{video.fileOriName}}</strong></span></div>
                            <div>{{video.fileSize}}</div>
                        </div>
                        <v-btn
                            icon
                            class="ml-auto mo-glow mr-2"
                            @click="removeUploadItem('video', index)"
                            :loading="video.isDeleting"
                            style="color:#ff264c;"
                            >
                            <v-icon size="25">mdi-trash-can-outline</v-icon>
                        </v-btn>
                    </v-card>
                </v-col>
            </v-row>
            <!--  FILE VIEWER  -->
            <v-row class="ma-0">
                <v-col v-for="(other, index) in contentData.otherUrl" :key="index" cols="12" sm="4" md="4" lg="3" class="position-relative py-1 ">
                    <v-card
                        class="d-flex align-center mo-glow-bg"
                        flat
                        tile
                    >
                        <img :src="`${baseUrl}/asset/img/upload_file_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                        <div class="font-size-0-75">
                            <div><span><strong>{{other.fileOriName}}</strong></span></div>
                            <div>{{other.fileSize}}</div>
                        </div>
                        <v-btn
                            icon
                            style="color:#ff264c;"
                            class="ml-auto mo-glow mr-2"
                            @click="removeUploadItem('other', index)"
                            :loading="other.isDeleting"
                            >
                            <v-icon size="25">mdi-trash-can-outline</v-icon>
                        </v-btn>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
  </v-container>
    <v-container class="pa-0" v-else>
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class="left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.share}}</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <!-- <v-btn
                        text
                        color="primary"
                        @click="selContent('template')"
                    >
                        可用模板 0， 草稿 0
                    </v-btn> -->

                    <v-btn
                        dark
                        tile
                        color="#49d29e"
                        class="mx-2"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>

                    <!-- <v-btn
                        dark
                        tile
                        color="#F19861"
                        :loading="isDraft"
                        @click="saveDraft"
                    >
                        {{lang.saveDraft}}
                    </v-btn> -->
                </v-col>
            </v-row>
        </v-container>
        <v-container class="pa-10">
            <QuestionItem Label="分享内容" :emoji="true" :contact="true"  ref="child" @contentData="loadContentData"></QuestionItem>
        </v-container>
        <v-snackbar
            timeout="3000"
            v-model="requiredText"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
        <v-snackbar
        timeout="3000"
            v-model="isSuccessed"
            color="success"
            absolute
            top
            >
            {{lang.successText}}
        </v-snackbar>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {createShare} from '~/api/share'
import quickMenu from '~/components/quickMenu'

//mo
import {uploadImage, uploadVideo, uploadOther, deleteFile} from '~/api/upload'
import emojiData from "emoji-mart-vue-fast/data/all.json";
import "emoji-mart-vue-fast/css/emoji-mart.css";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast";
let emojiIndex = new EmojiIndex(emojiData);

export default {
    components:{
        QuestionItem,
        quickMenu,
        //mo
        Picker,
    },

    data: ()=> ({
        //mo
        emojiIndex: emojiIndex,
        emojisOutput: "",
        selectedImageFile: null,
        selectedVideoFile: null,
        selectedFile: null,
        isImageSelecting: false,
        isVideoSelecting: false,
        isFileSelecting: false,
        deleteItem : null,

        lang,
        baseUrl: window.Laravel.base_url,
        isSubmit:false,
        isDraft:false,
        requiredText:false,
        shareData:{
            schoolId:null,
            content:[]
        },
        isSuccessed:false,
        contentData:{
            text:'',
            imgUrl:[],
            otherUrl:[],
            videoUrl:[]
        }
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        this.shareData.schoolId = this.currentPath.params.schoolId
    },
    methods:{
        saveDraft(){

        },
        async submit(){
            this.$refs.child.emitData()
            if(this.shareData.content.length == 0){
                return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
            }
            console.log(this.shareData)
            this.isSubmit = true
            await createShare(this.shareData).then(res=>{
                console.log(res)
                this.isSubmit = false
                this.isSuccessed = true;
                if(this.$isMobile()){
                    this.$router.push({name:'home'})
                }
                else{
                    this.$router.push({name:'schoolSpace.news'})
                }
            }).catch(err=>{
                //console.log(err.response)
                this.isSubmit = false
            })
        },

        loadContentData(data){
            if(data.text === ''){
                this.shareData.content = [];
                return;
            }
            this.shareData.content.push(data)
        },
        something(){

        },

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
                    let imgObj = {
                        path : `/uploads/image/${res.data}`,
                        isDeleting : false,
                    }
                    this.contentData.imgUrl.push(imgObj);
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
        clickUploadVideoBtn() {
            window.addEventListener('focus', () => {
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
                    //console.log(err);
                    this.isVideoSelecting = false
                });
            }
            //reset video file input
            this.$refs.videoUploader.value = ''
        },
        clickUploadFileBtn() {
            window.addEventListener('focus', () => {
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
                    this.selectedFile = null;
                    let url = `/uploads/other/${res.data.fileName}`;
                    this.$set(res.data,'imgUrl',url)
                    this.$set(res.data,'isDeleting',false)
                    this.contentData.otherUrl.push(res.data);
                    this.isFileSelecting = false
                }).catch((err) => {
                    //console.log(err);
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
                this.deleteItem.isDeleting = false;
            }).catch((err) => {
                //console.log(err);
                this.deleteItem.isDeleting = false;
            });

        },
    }
}
</script>

<style>

</style>