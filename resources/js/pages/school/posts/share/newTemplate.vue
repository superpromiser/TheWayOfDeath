<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-container class="pa-0 h-100 bg-white mb-16 pb-3" >
            <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
                <v-icon @click="navToBackCustom" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                    mdi-chevron-left
                </v-icon>
                <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.share}}模板清单</p>
                <v-btn @click="submit" :loading="isSubmit" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                    {{lang.submit}}
                </v-btn>
            </v-row>
            <div class="cus-divider-light-gray-height"></div>
            <v-row class="ma-0 mo-glow bg-white">
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        color="#7879ff"
                        v-model="templateData.title"
                        label="模板名称"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        color="#7879ff"
                        v-model="templateData.description"
                        label="说明"
                        hide-details
                        class="mt-0 pt-0"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="ma-0 text-area-without-nav-bottom" @click="$refs.textarea.focus()" style="">
                <v-col cols="12">
                    <v-textarea
                        class="v-textarea-cus-border-0 v-textarea-px-0 mt-0 pt-0"
                        auto-grow
                        color="#7879ff"
                        clear-icon="mdi-close-circle"
                        label="输入内容"
                        v-model="moContentData.text"
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
                            <v-col v-for="(imgUrl, index) in moContentData.imgUrl" :key="index" cols="12" sm="4" md="3" lg="2" class="position-relative py-1">
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
                            <v-col v-for="(video, index) in moContentData.videoUrl" :key="index" cols="12" sm="4" md="4" lg="3" class="position-relative py-1">
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
                            <v-col v-for="(other, index) in moContentData.otherUrl" :key="index" cols="12" sm="4" md="4" lg="3" class="position-relative py-1 ">
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
            <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-secondary">
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
    </v-container>
    <v-container class="pa-0" v-else>
        <v-container class="z-index-2 mb-15 banner-custom px-10">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class=" left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>{{lang.share}}模板清单</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        tile
                        dark
                        color="#7879ff"
                        class="mx-2"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        {{lang.submit}}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-row class="px-10">
            <v-col cols="12" sm="6" md="4">
                <v-text-field
                solo
                v-model="templateData.title"
                label="模板名称"
                hide-details
                ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-text-field
                solo
                v-model="templateData.description"
                label="说明"
                hide-details
                ></v-text-field>
            </v-col>
        </v-row>
        <v-container class="pa-10">
            <QuestionItem Label="分享内容" :emoji="true" ref="child" @contentData="loadContentData"></QuestionItem>
        </v-container>
    </v-container>
</template>

<script>
import {createTemp} from '~/api/share'
import QuestionItem from '~/components/questionItem'
import lang from '~/helper/lang.json'
export default {
    components:{
        QuestionItem
    },
    data:()=>({
        templateData:{
            title:"",
            description:"",
            tempType:1,
            content:[],
            schoolId:null,
            lessonId:null
        },
        isSubmit:false,
        lang,
        moContentData: {
            text: '',
            imgUrl: [],
            videoUrl: [],
            otherUrl: [],
        }
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        this.templateData.schoolId = this.currentPath.params.schoolId
    },
    methods:{
        loadContentData(data){
            console.log(data)
            if(data.text === ''){
                this.templateData.content = [];
                return;
            }
            this.templateData.content.push(data)
        },
        async submit(){
            this.$refs.child.emitData()
            console.log(this.templateData)
            if(this.templateData.title.trim() == ''){
                return this.$snackbar.showMessage({content: this.lang.share + this.lang.requireTitle, color: 'error'})
            }
            if(this.templateData.description.trim() == ''){
                return this.$snackbar.showMessage({content: this.lang.share + this.lang.requireDescription, color: 'error'})
            }
            if(this.templateData.content.length == 0){
                return this.$snackbar.showMessage({content: this.lang.share + this.lang.requireContent, color: 'error'})
            }
            this.isSubmit = true
            await createTemp(this.templateData).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                this.$router.push({name:'share.templateList'})
            }).catch(err=>{
                console.log(err.response)
                this.isSubmit = false
            })
        },

        navToBackCustom(){
            this.$router.go(-1);
        }
    }
}
</script>

<style>

</style>