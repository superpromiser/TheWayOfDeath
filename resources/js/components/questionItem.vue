<template>
    <v-container v-if="$isMobile()" class="bg-white pa-0">
        <v-container v-if="isShareView" class="pa-0">
            <v-row :class="isAnnouncement? 'ma-0 text-area-without-nav-bottom-announcement': 'ma-0 text-area-without-nav-bottom'" @click="$refs.textarea.focus()" style="">
                <v-col cols="12">
                    <v-textarea
                        class="v-textarea-cus-border-0 v-textarea-px-0 mt-0 pt-0"
                        auto-grow
                        color="#7879ff"
                        clear-icon="mdi-close-circle"
                        label="输入内容"
                        v-model="contentData.text"
                        hide-details
                        rows="5"
                        solo
                        ref="textarea"
                    ></v-textarea>
                </v-col>
                <v-col cols="12" class="pa-0 pb-16">
                    <v-container class="pa-0 pb-16">
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
                </v-col>
            </v-row>
            <v-row class="ma-0 position-fixed-bottom-0 w-100" style="background: #F2F2F2;">
                <v-col cols="3" @click="clickUploadImageBtn" class="d-flex justify-center align-center py-1" v-ripple>
                    <v-progress-circular v-if="isImageSelecting" indeterminate color="#676767" :width="3" size="30"></v-progress-circular>
                    <v-icon v-else size="30">mdi-file-image-outline</v-icon>
                </v-col>
                <input
                    ref="imageUploader"
                    class="d-none"
                    type="file"
                    accept="image/*"
                    @change="onImageFileChanged"
                >
                <!-- <v-col cols="2" class="d-flex justify-center align-center py-1" v-ripple>
                    <p class="mb-0 pb-1" style="font-size: 25px; color:#676767; font-weight: bold">@</p>
                </v-col>
                <v-col cols="2" class="d-flex justify-center align-center py-1" v-ripple>
                    <p class="mb-0" style="font-size: 25px; color:#676767; font-weight: bold">#</p>
                </v-col> -->
                <v-col @click="clickUploadVideoBtn" cols="3" class="d-flex justify-center align-center py-1" v-ripple>
                    <v-progress-circular v-if="isVideoSelecting" indeterminate color="#676767" :width="3" size="30"></v-progress-circular>
                    <v-icon v-else size="30">mdi-play-box-outline </v-icon>
                </v-col>
                <input
                    ref="videoUploader"
                    class="d-none"
                    type="file"
                    accept="video/*"
                    @change="onVideoFileChanged"
                >
                <v-col cols="3" class="d-flex justify-center align-center py-1" v-ripple @click="toggleEmo">
                    <v-icon size="30">mdi-emoticon-excited-outline</v-icon>
                </v-col>
                <Picker 
                    class="position-absolute" 
                    style="bottom:50px; left:50%; transform:translateX(-50%)" 
                    v-click-outside="outSidePicker" 
                    v-if="emoStatus" 
                    :data="emojiIndex" 
                    title="选择你的表情符号..." 
                    set="twitter" 
                    @select="onInput" 
                    :showPreview="false"
                    :showSearch="false"
                    :i18n="emojiI18n"
                />
                <v-col @click="clickUploadFileBtn" cols="3" class="d-flex justify-center align-center py-1" v-ripple>
                    <v-progress-circular v-if="isFileSelecting" indeterminate color="#676767" :width="3" size="30"></v-progress-circular>
                    <v-icon v-else size="30">mdi-folder-outline</v-icon>
                </v-col>
                <input
                    ref="fileUploader"
                    class="d-none"
                    type="file"
                    accept=".doc, .docx, .zip, .pdf, .xls, .xlsx, .rp, .mp3, .rp, .ppt, .pptx, .pptm, .apk, .rar"
                    @change="onFileFileChanged"
                >
            </v-row>
        </v-container>
        <v-container v-else class="pa-0 ma-0">
            <v-row class="ma-0 px-3 pt-2">
                <!-- {{index}} -->
                <v-col cols="12" class="pa-0">
                    <p class="mb-0 font-size-0-8 font-color-gray-dark">{{Label}}</p> 
                </v-col>
                <v-col cols="12" class="pa-0">
                    <v-textarea
                        class="v-textarea-cus-border mt-0 pt-0"
                        clearable
                        auto-grow
                        color="#7879ff"
                        clear-icon="mdi-close-circle"
                        value=""
                        v-model="contentData.text"
                        hide-details
                        rows="4"
                        solo
                        
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-row class="ma-0 mt-1">
                <v-btn
                    fab
                    x-small
                    class="bg-white mx-1"
                    :loading="isImageSelecting"
                    @click="clickUploadImageBtn"
                    style="color:#7879ff;"
                    elevation="0"
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
                    fab
                    x-small
                    class="bg-white mx-1"
                    :loading="isVideoSelecting"
                    @click="clickUploadVideoBtn"
                    style="color:#7879ff;"
                    elevation="0"
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
                    fab
                    x-small
                    class="bg-white mx-1"
                    :loading="isFileSelecting"
                    @click="clickUploadFileBtn"
                    style="color:#7879ff;"
                    elevation="0"
                >
                <v-icon>mdi-file-upload</v-icon>
                </v-btn>
                <input
                    ref="fileUploader"
                    class="d-none"
                    type="file"
                    accept=".doc, .docx, .zip, .pdf, .xls, .xlsx, .rp, .mp3, .rp, .ppt, .pptx, .pptm, .apk, .rar"
                    @change="onFileFileChanged"
                >
                <v-btn
                    v-if="contact"
                    fab
                    x-small
                    class="bg-white mx-1"
                    :loading="isUserSeleciting"
                    @click="selectUser"
                    style="color:#7879ff;"
                    elevation="0"
                >
                    <v-icon>mdi-id-card</v-icon>
                </v-btn>
                <v-btn
                    v-if="emoji"
                    fab
                    x-small
                    class="bg-white mx-1"
                    @click="toggleEmo"
                    style="color:#7879ff;"
                    elevation="0"
                >
                    <v-icon>mdi-emoticon-excited-outline</v-icon>
                </v-btn>
                <Picker 
                    v-click-outside="outSidePicker"
                    class="w-90-i" 
                    v-if="emoStatus" 
                    :data="emojiIndex" 
                    title="选择你的表情符号..." 
                    set="twitter" 
                    @select="onInput" 
                    :showPreview="false"
                    :showSearch="false"
                    :i18n="emojiI18n"
                />
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
    <v-container v-else>
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
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="blue accent-3"
                        fab
                        small
                        dark
                        class="ma-2"
                        :loading="isImageSelecting"
                        @click="clickUploadImageBtn"
                        v-bind="attrs"
                        v-on="on"
                    >
                    <v-icon>mdi-file-image-outline</v-icon>
                    </v-btn>
                </template>
                <span>图片</span>
            </v-tooltip>
            <input
                ref="imageUploader"
                class="d-none"
                type="file"
                accept="image/*"
                @change="onImageFileChanged"
            >
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="blue accent-3"
                        fab
                        small
                        dark
                        class="ma-2"
                        :loading="isVideoSelecting"
                        @click="clickUploadVideoBtn"
                        v-bind="attrs"
                        v-on="on"
                    >
                    <v-icon>mdi-video</v-icon>
                    </v-btn>
                </template>
                <span>视频</span>
            </v-tooltip>
            <input
                ref="videoUploader"
                class="d-none"
                type="file"
                accept="video/*"
                @change="onVideoFileChanged"
            >
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="blue accent-3"
                        fab
                        small
                        dark
                        class="ma-2"
                        :loading="isFileSelecting"
                        @click="clickUploadFileBtn"
                        v-bind="attrs"
                        v-on="on"
                    >
                    <v-icon>mdi-file-upload</v-icon>
                    </v-btn>
                </template>
                <span>文件</span>
            </v-tooltip>
            <input
                ref="fileUploader"
                class="d-none"
                type="file"
                accept=".doc, .docx, .zip, .pdf, .xls, .xlsx, .rp, .mp3, .rp, .ppt, .pptx, .pptm, .apk, .rar"
                @change="onFileFileChanged"
            >
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="blue accent-3"
                        v-if="contact"
                        fab
                        small
                        dark
                        class="ma-2"
                        :loading="isUserSeleciting"
                        @click="selectUser"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-id-card</v-icon>
                    </v-btn>
                </template>
                <span>通讯录</span>
            </v-tooltip>
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        v-if="emoji"
                        color="blue accent-3"
                        fab
                        small
                        dark
                        class="ma-2"
                        @click="toggleEmo"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-emoticon-excited-outline</v-icon>
                    </v-btn>
                </template>
                <span>表情</span>
            </v-tooltip>
            <Picker 
                v-click-outside="outSidePicker" 
                v-if="emoStatus" 
                :data="emojiIndex" 
                title="选择你的表情符号..." 
                set="twitter" 
                @select="onInput"
                :showPreview="false"
                :showSearch="false"
                :i18n="emojiI18n" />
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
// import { Picker } from 'emoji-mart-vue'

import emojiData from "emoji-mart-vue-fast/data/all.json";
import "emoji-mart-vue-fast/css/emoji-mart.css";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast";
let emojiIndex = new EmojiIndex(emojiData);

export default {
    props: {
        Label : {
            type: String,
            required: true
        },
        index :{
            type:Number,
            required: false
        },
        emoji : {
            type:Boolean,
            required:false,
        },
        contact : {
            type:Boolean,
            required:false,
        },
        item : {
            type : Object,
            required: false
        },
        isShareView : {
            type : Boolean,
            required: false,
            default: false
        },
        isAnnouncement: {
            type : Boolean,
            required: false,
            default: false
        }
        // contentItem:{
        //     type:Object,
        //     required:false
        // }
    },
    components: {
        Picker,
    },
    data: () =>({
        emojiIndex: emojiIndex,
        emojisOutput: "",

        include:["people", "nature"],
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
        isUserSeleciting:false,
        emoStatus:false,

        emojiI18n: { 
            search: 'Recherche', 
            categories: { 
                search: '//Search Results',
                recent: '最近常用',
                smileys: '黄脸',
                people: '人和手势',
                nature: '动物和植物',
                foods: '食物',
                activity: '活动',
                places: '交通 ',
                objects: '物品',
                symbols: '标志',
                flags: '国旗',
                custom: '其他',
            } 
        },
    }),

    created(){
        if(this.item){
            this.contentData = this.item;
        }
    },

    mounted(){

    },

    methods:{
        showEmoji(emoji) {
            this.emojisOutput = this.emojisOutput + emoji.native;
        },

        outSidePicker(){
            this.emoStatus = false;
        },
        clickUploadImageBtn() {
            window.addEventListener('focus', () => {
            }, { once: true })
            this.$refs.imageUploader.click()
        },

        onInput(e){
            if(!e){
                return false;
            }
            if(!this.contentData.text){
                this.contentData.text = e.native
            }else{
                this.contentData.text = this.contentData.text + e.native
            }
        },

        toggleEmo(){
            this.emoStatus = ! this.emoStatus
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

        emitData(){
            if (this.contentData.text == ''){
                
            }
            this.$emit('contentData',this.contentData);
        },
        selectUser(){
            // this.isUserSeleciting = true
        }
    }
}
</script>

<style>

</style>