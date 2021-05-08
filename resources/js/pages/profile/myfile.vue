<template>
    <v-container v-if="$isMobile()" class="pa-0">
        <v-row class="ma-0 bg-white justify-center position-relative" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold py-4">我的文件</p>
        </v-row>
        <v-row class="ma-0 bg-white mb-3" >
            <v-tabs grow class="mo-chat-contact-tab" v-model="moMyFileTab" color="#666666" background-color="#fffff">
                <v-tab href="#all-type" :ripple="false" active-class="mo-chat-nav-active">最近</v-tab>
                <v-tab href="#other-file" :ripple="false" active-class="mo-chat-nav-active"> 文档</v-tab>
                <v-tab href="#video-file" :ripple="false" active-class="mo-chat-nav-active"> 视频</v-tab>
                <v-tab href="#image-file" :ripple="false" active-class="mo-chat-nav-active"> 图片</v-tab>
            </v-tabs>
        </v-row>
        <v-tabs-items v-model="moMyFileTab" class="height-out-114 pa-3 py-0">
            <v-tab-item value="all-type" class="container pa-0">
                <!--- my image file --->
                <v-row class="ma-0">
                    <v-col cols="12" class="d-flex justify-space-between align-center pa-0 py-3">
                        <p class="mb-0 font-size-0-75" style="margin-left: 5px;"> 图片 </p>
                        <div class="d-flex align-center">
                            <p class="mb-0 font-size-0-75">{{imageFileList.length!==0?imageFileList.length : 0}}项</p>
                            <v-icon size="22" color="#333333">mdi-chevron-right</v-icon>
                        </div> 
                    </v-col>
                    <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                        <v-progress-circular
                            indeterminate
                            color="#7879ff"
                        ></v-progress-circular>
                    </v-col>
                    <v-col v-else-if="noImageFile" cols="12" class="d-flex justify-center align-center">
                        <v-chip class="ma-2" color="#F19861" outlined pill >
                            没有图片
                            <v-icon right> mdi-cancel  </v-icon>
                        </v-chip>
                    </v-col>
                    <v-col cols="12" v-else v-viewer="optionsMo" class="images clearfix ma-0 pa-0">
                        <div v-for="img in imageFileList" class="image-con text-center">
                            <img :src="`${baseUrl}${img.path}`" :data-source="`${baseUrl}${img.path}`" :key="img.path" class="mo-image">
                            <p class="mb-0 font-size-2-8-vw mx-auto text-center">{{TimeViewYMDDot(img.fileCreatedAt)}}</p>
                        </div>
                    </v-col>
                </v-row>
                <v-divider light style="margin: 0 5px;"></v-divider>
                <!--- my video file --->
                <v-row class="ma-0">
                    <v-col cols="12" class="d-flex justify-space-between align-center pa-0 py-3">
                        <p class="mb-0 font-size-0-75" style="margin-left: 5px;"> 视频 </p>
                        <div class="d-flex align-center">
                            <p class="mb-0 font-size-0-75">{{videoFileList.length!==0?videoFileList.length : 0}}项</p>
                            <v-icon size="22" color="#333333">mdi-chevron-right</v-icon>
                        </div>
                    </v-col>

                    <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                        <v-progress-circular
                            indeterminate
                            color="#7879ff"
                        ></v-progress-circular>
                    </v-col>
                    <v-col v-else-if="noVideoFile" cols="12" class="d-flex justify-center align-center">
                        <v-chip class="ma-2" color="#F19861" outlined pill >
                            没有视频
                            <v-icon right> mdi-cancel  </v-icon>
                        </v-chip>
                    </v-col>

                    <v-col cols="12" v-else class="images clearfix ma-0 pa-0">
                        <div v-for="(video, index) in videoFileList" :key="index" class="video-con text-center" @click="openVideoViewDialog(index, video)">
                            <div class="position-relative mo-video d-flex align-center justify-center">
                                <div class="position-absolute position-absolute-center">
                                    <p class="mb-0 font-size-2-8-vw"><span><strong>{{video.fileOriName}}</strong></span></p>
                                    <p class="mb-0 font-size-2-8-vw">{{video.fileSize}}</p>
                                </div>
                                <v-overlay :absolute="true" >
                                    <v-btn color="#49d29e" icon @click="openVideoViewDialog(index, video)">
                                        <v-icon>mdi-play-circle-outline</v-icon>
                                    </v-btn>
                                </v-overlay>
                            </div>
                            <p class="mb-0 font-size-2-8-vw mx-auto text-center">{{TimeViewYMDDot(video.fileCreatedAt)}}</p>
                        </div>
                    </v-col>
                    <v-dialog v-model="videoViewDialog" width="100%" max-width="1000">
                        <v-card>
                            <v-card-title class="title">
                            {{selectedViedoName}}
                            </v-card-title>
                            <v-card-text class="px-0">
                                <video-player  
                                    class="video-player-box vjs-custom-skin w-100"
                                    ref="videoPlayer"
                                    :options="playerOptionsGroup[selectedVideoIndex]"
                                    :playsinline="true"
                                    >
                                </video-player>
                            </v-card-text>
                            
                            <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="#7879ff"
                                @click="videoViewDialog = false"
                            >
                                {{lang.ok}}
                            </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
                <v-divider light style="margin: 0 5px;"></v-divider>
                <!--- my other file --->
                <v-row class="ma-0 mb-16">
                    <v-col cols="12" class="d-flex justify-space-between align-center pa-0 py-3">
                        <p class="mb-0 font-size-0-75" style="margin-left: 5px;"> 文档 </p>
                        <div class="d-flex align-center">
                            <p class="mb-0 font-size-0-75">{{otherFileList.length!==0?otherFileList.length : 0}}项</p>
                            <v-icon size="22" color="#333333">mdi-chevron-right</v-icon>
                        </div> 
                    </v-col>
                    <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                        <v-progress-circular
                            indeterminate
                            color="#7879ff"
                        ></v-progress-circular>
                    </v-col>
                    <v-col v-else-if="noOtherFile" cols="12" class="d-flex justify-center align-center">
                        <v-chip class="ma-2" color="#F19861" outlined pill >
                            没有文档
                            <v-icon right> mdi-cancel  </v-icon>
                        </v-chip>
                    </v-col>
                    <v-col cols="12" v-else class="images clearfix ma-0 pa-0">
                        <div v-for="(other, index) in otherFileList" :key="index" class="video-con text-center">
                            <a class="position-relative mo-video" :href="other.imgUrl" :download="other.fileOriName">
                                <div class="position-absolute position-absolute-center">
                                    <p class="mb-0 font-size-2-8-vw"><span><strong>{{other.fileOriName}}</strong></span></p>
                                    <p class="mb-0 font-size-2-8-vw">{{other.fileSize}}</p>
                                </div>
                            </a>
                            <p class="mb-0 font-size-2-8-vw mx-auto text-center">{{TimeViewYMDDot(other.fileCreatedAt)}}</p>
                        </div>
                    </v-col>
                    <!-- <v-col v-else v-for="(other, index) in otherFileList" :key="index" cols="12" sm="6" md="4" lg="3" class="position-relative">
                        <v-card class="d-flex align-center " color="#F2F2F2" flat tile >
                            <img :src="`${baseUrl}/asset/img/upload_file_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                            <div class="font-size-0-75">
                                <div><span><strong>{{other.fileOriName}}</strong></span></div>
                                <div>{{other.fileSize}}</div>
                            </div>
                            <div class="ml-auto mr-2">
                                <a class="file-box" :href="other.imgUrl" :download="other.fileOriName">
                                    <v-btn icon color="blue darken-1" >
                                        <v-icon size="25" >mdi-download-circle-outline </v-icon>
                                    </v-btn>
                                </a>
                            </div>
                        </v-card>
                    </v-col> -->
                </v-row>
                <!-- <v-overlay :value="isLoading">
                    <v-progress-circular
                        indeterminate
                        size="64"
                    ></v-progress-circular>
                </v-overlay> -->
            </v-tab-item>
            <v-tab-item value="other-file">
                <v-container class="pa-0">
                     <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                        <v-progress-circular
                            indeterminate
                            color="#7879ff"
                        ></v-progress-circular>
                    </v-col>
                    <v-col v-else-if="noOtherFile" cols="12" class="d-flex justify-center align-center">
                        <v-chip class="ma-2" color="#F19861" outlined pill >
                            没有文档
                            <v-icon right> mdi-cancel  </v-icon>
                        </v-chip>
                    </v-col>
                    <v-container v-else class="pa-0" v-for="(otherFile, index) in otherFileList" :key="index">
                        <v-row class="ma-0">
                            <v-col cols="12" class="d-flex align-center">
                                <img v-if="otherFile.fileExtension == 'zip'" :src="`${baseUrl}/asset/img/fileIcon/zip.png`" style="width:39px; height:52px; " alt="">
                                <img v-else :src="`${baseUrl}/asset/img/fileIcon/file.png`" style="width:39px; height:52px; " alt="">
                                <div class="ml-3">
                                    <p class="mb-0 font-size-0-75"> <strong>{{otherFile.fileOriName}}</strong></p>
                                    <p class="mb-0 font-size-0-75">{{otherFile.fileSize}}</p>
                                </div>
                                <v-spacer></v-spacer>
                                <div class="d-flex align-start">
                                    <p class="mb-0 font-size-0-75">{{TimeViewYMDDot(otherFile.fileCreatedAt)}}</p>
                                </div>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                    </v-container>
                </v-container>
            </v-tab-item>
            <v-tab-item value="video-file">
                <!--- my video file --->
                <v-row class="ma-0">
                    <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                        <v-progress-circular
                            indeterminate
                            color="#7879ff"
                        ></v-progress-circular>
                    </v-col>
                    <v-col v-else-if="noVideoFile" cols="12" class="d-flex justify-center align-center">
                        <v-chip class="ma-2" color="#F19861" outlined pill >
                            没有视频
                            <v-icon right> mdi-cancel  </v-icon>
                        </v-chip>
                    </v-col>
                    <v-container v-else class="pa-0">
                        <v-row class="ma-0" v-for="(videoGroup, index) in groupedVideoFileList" :key="index">
                            <v-col cols="12" class="d-flex justify-space-between align-center pa-0 py-3">
                                <p class="mb-0 font-size-0-75" style="margin-left: 5px;"> {{Object.keys(videoGroup)[0]}} </p>
                                <div class="d-flex align-center">
                                    <p class="mb-0 font-size-0-75" style="margin-right: 5px;">{{videoGroup[`${Object.keys(videoGroup)[0]}`].length!==0 ? videoGroup[`${Object.keys(videoGroup)[0]}`].length : 0}}项</p>
                                </div> 
                            </v-col>
                            <v-col cols="12" class="images clearfix ma-0 pa-0">
                                <div v-for="(video,index) in videoGroup[`${Object.keys(videoGroup)[0]}`]" :key="index" class="video-con text-center ">
                                    <div class="position-relative mo-video d-flex align-center justify-center">
                                        <div class="position-absolute position-absolute-center">
                                            <p class="mb-0 font-size-2-8-vw"><span><strong>{{video.fileOriName}}</strong></span></p>
                                            <p class="mb-0 font-size-2-8-vw">{{video.fileSize}}</p>
                                        </div>
                                        <v-overlay :absolute="true" >
                                            <v-btn color="#49d29e" icon @click="openVideoViewDialog(index, video)">
                                                <v-icon>mdi-play-circle-outline</v-icon>
                                            </v-btn>
                                        </v-overlay>
                                    </div>
                                    <p class="mb-0 font-size-2-8-vw mx-auto text-center">{{TimeViewYMDDot(video.fileCreatedAt)}}</p>
                                </div>
                            </v-col>
                            <div class="cus-divider-light-gray-height"></div>
                        </v-row>
                    </v-container>
                </v-row>
            </v-tab-item>
            <v-tab-item value="image-file">
                <!--- my image file --->
                <v-row class="ma-0">
                    <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                        <v-progress-circular
                            indeterminate
                            color="#7879ff"
                        ></v-progress-circular>
                    </v-col>
                    <v-col v-else-if="noImageFile" cols="12" class="d-flex justify-center align-center">
                        <v-chip class="ma-2" color="#F19861" outlined pill >
                            没有图片
                            <v-icon right> mdi-cancel  </v-icon>
                        </v-chip>
                    </v-col>
                    <v-container v-else class="pa-0">
                        <v-row class="ma-0" v-for="(imageGroup, index) in groupedImageFileList" :key="index">
                            <v-col cols="12" class="d-flex justify-space-between align-center pa-0 py-3">
                                <p class="mb-0 font-size-0-75" style="margin-left: 5px;"> {{Object.keys(imageGroup)[0]}} </p>
                                <div class="d-flex align-center">
                                    <p class="mb-0 font-size-0-75" style="margin-right: 5px;">{{imageGroup[`${Object.keys(imageGroup)[0]}`].length!==0 ? imageGroup[`${Object.keys(imageGroup)[0]}`].length : 0}}项</p>
                                </div> 
                            </v-col>
                            <v-col cols="12"  v-viewer="optionsMo" class="images clearfix ma-0 pa-0">
                                <div v-for="img in imageGroup[`${Object.keys(imageGroup)[0]}`]" class="image-con text-center">
                                    <img :src="`${baseUrl}${img.path}`" :data-source="`${baseUrl}${img.path}`" :key="img.path" class="mo-image">
                                    <p class="mb-0 font-size-2-8-vw mx-auto text-center">{{TimeViewYMDDot(img.fileCreatedAt)}}</p>
                                </div>
                            </v-col>
                            <div class="cus-divider-light-gray-height"></div>
                        </v-row>
                    </v-container>
                </v-row>
            </v-tab-item>
        </v-tabs-items>
        
        
    </v-container>
    <v-container v-else>
        <!--- my image file --->
        <v-row>
            <v-col cols="12">
                <v-chip class="ma-2 px-5" color="primary" outlined >
                    我的图片文件
                    <v-icon right> mdi-file-image  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-col>
            <v-col v-else-if="noImageFile" cols="12" class="d-flex justify-center align-center">
                <v-chip class="ma-2" color="#F19861" outlined pill >
                    我的图片文件没有数据
                    <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-col>
            <v-col cols="12" v-else v-viewer="options" class="images clearfix ma-0">
                <template v-for="img in imageFileList">
                    <img :src="`${baseUrl}${img.path}`" :data-source="`${baseUrl}${img.path}`" class="image" :key="img.path" >
                </template>
            </v-col>
        </v-row>
        <!--- my video file --->
        <v-row>
            <v-col cols="12">
                <v-chip class="ma-2 px-5" color="primary" outlined >
                    我的视频文件数据
                    <v-icon right> mdi-file-video  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-col>
            <v-col v-else-if="noVideoFile" cols="12" class="d-flex justify-center align-center">
                <v-chip class="ma-2" color="#F19861" outlined pill >
                    我的视频文件没有数据
                    <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-else v-for="(video, index) in videoFileList" :key="index" cols="12" sm="6" md="4" lg="3" class="position-relative px-1">
                <v-card class="d-flex align-center " color="blue lighten-4" flat tile >
                    <img :src="`${baseUrl}/asset/img/upload_video_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="">
                        <div><span><strong>{{video.fileOriName}}</strong></span></div>
                        <div>{{video.fileSize}}</div>
                    </div>
                    <div class="ml-auto mr-2">
                        <v-btn icon color="blue darken-1" @click="openVideoViewDialog(index, video)" >
                            <v-icon size="30" >mdi-eye </v-icon>
                        </v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-dialog v-model="videoViewDialog" width="100%" max-width="1000">
                <v-card>
                    <v-card-title class="title">
                    {{selectedViedoName}}
                    </v-card-title>
                    <v-card-text class="px-0">
                        <video-player  
                            class="video-player-box vjs-custom-skin w-100"
                            ref="videoPlayer"
                            :options="playerOptionsGroup[selectedVideoIndex]"
                            :playsinline="true"
                            >
                        </video-player>
                    </v-card-text>
                    
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="primary"
                        @click="videoViewDialog = false"
                    >
                        {{lang.ok}}
                    </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <!--- my other file --->
        <v-row class="ma-0 mb-16">
            <v-col cols="12">
                <v-chip class="ma-2 px-5" color="primary" outlined >
                    我的文件
                    <v-icon right> mdi-file  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-if="isLoading" cols="12" class="d-flex justify-center align-center">
                <v-progress-circular
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-col>
            <v-col v-else-if="noOtherFile" cols="12" class="d-flex justify-center align-center">
                <v-chip class="ma-2" color="#F19861" outlined pill >
                    没有我的文件数据
                    <v-icon right> mdi-cancel  </v-icon>
                </v-chip>
            </v-col>
            <v-col v-else v-for="(other, index) in otherFileList" :key="index" cols="12" sm="6" md="4" lg="3" class="position-relative px-1">
                <v-card class="d-flex align-center " color="blue lighten-4" flat tile >
                    <img :src="`${baseUrl}/asset/img/upload_file_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="">
                        <div><span><strong>{{other.fileOriName}}</strong></span></div>
                        <div>{{other.fileSize}}</div>
                    </div>
                    <div class="ml-auto mr-2">
                        <a class="file-box" :href="other.imgUrl" :download="other.fileOriName">
                            <v-btn icon color="blue darken-1" >
                                <v-icon size="30" >mdi-download-circle-outline </v-icon>
                            </v-btn>
                        </a>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {getMyFile} from '~/api/user';
import lang from '~/helper/lang.json'
export default {
    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        videoViewDialog: false,
        imageFileList: [],
        videoFileList: [],
        otherFileList: [],
        groupedImageFileList: [],
        groupedVideoFileList: [],
        groupedOtherFileList: [],
        isLoading: false,
        noImageFile: false,
        noVideoFile: false,
        noOtherFile: false,
        options: {
            toolbar: true,
            url: 'data-source'
        },
        optionsMo: {
            toolbar: false,
            url: 'data-source'
        },
        playerOptionsGroup:[],
        playerOptions: {
            // videojs options
            height: '650',
            muted: true,
            language: 'en',
            playbackRates: [0.7, 1.0, 1.5, 2.0],
            sources: [{
                type: "video/mp4",
                src: "https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm"
            }],
        },
        selectedVideoIndex: -1,
        selectedViedoName: "",
        moMyFileTab: 0,
    }),

    async created(){
        this.isLoading = true;
        await getMyFile()
        .then((res) => {
            this.imageFileList = res.data.imageFileList
            this.videoFileList = res.data.videoFileList
            this.otherFileList = res.data.otherFileList
            console.log(this.imageFileList, this.videoFileList, this.otherFileList);

            //manipulate image file 
            if(this.imageFileList.length == 0){
                this.noImageFile = true;
            }
            else{
                let newImgArr = [];
                for(let i = 0; i < this.imageFileList.length ; i++){
                    let imgObj = {};
                    imgObj['path'] = this.imageFileList[i];
                    imgObj['fileCreatedAt'] = this.imageFileList[i].split('_')[0].split('/')[3];
                    newImgArr.push(imgObj);
                }
                this.imageFileList = newImgArr;

                this.imageFileList.sort(function(a,b){
                    return new Date(b.fileCreatedAt) - new Date(a.fileCreatedAt)
                })
                console.log("this.imageFileList", this.imageFileList);

                let result = this.imageFileList.reduce(function (r, a) {
                    r[a.fileCreatedAt] = r[a.fileCreatedAt] || [];
                    r[a.fileCreatedAt].push(a);
                    return r;
                }, Object.create(null));

                let arrayOfObj = Object.entries(result).map((e) => ( { [e[0]]: e[1] } ));
                console.log("arrayOfObj", arrayOfObj);
                this.groupedImageFileList = arrayOfObj;
            }

            //manipulate other file 
            if(this.otherFileList.length == 0){
                this.noOtherFile = true;
            }
            else{
                for(let i = 0; i < this.otherFileList.length; i++){
                    this.otherFileList[i].fileCreatedAt = this.otherFileList[i].fileCreatedAt.split('T')[0]
                }
                this.otherFileList.sort(function(a,b){
                    return new Date(b.fileCreatedAt) - new Date(a.fileCreatedAt)
                })

                let result = this.otherFileList.reduce(function (r, a) {
                    r[a.fileCreatedAt] = r[a.fileCreatedAt] || [];
                    r[a.fileCreatedAt].push(a);
                    return r;
                }, Object.create(null));

                let arrayOfObj = Object.entries(result).map((e) => ( { [e[0]]: e[1] } ));
                this.groupedOtherFileList = arrayOfObj;
            }
            
            //manipulate video file \
            if(this.videoFileList.length == 0){
                this.noVideoFile = true;
            }
            
            else if(this.videoFileList.length > 0){
                for(let i = 0; i < this.videoFileList.length ; i++){
                    let clonedOption = JSON.parse(JSON.stringify(this.playerOptions));
                    clonedOption.sources[0].src = this.baseUrl + '/uploads/video/'+this.videoFileList[i].fileName;
                    if(this.$isMobile()){
                        clonedOption.height = '300'
                    }
                    this.playerOptionsGroup.push(clonedOption);
                    this.videoFileList[i].fileCreatedAt = this.videoFileList[i].fileCreatedAt.split('T')[0];
                }

                this.videoFileList.sort(function(a,b){
                    return new Date(b.fileCreatedAt) - new Date(a.fileCreatedAt)
                })

                let result = this.videoFileList.reduce(function (r, a) {
                    r[a.fileCreatedAt] = r[a.fileCreatedAt] || [];
                    r[a.fileCreatedAt].push(a);
                    return r;
                }, Object.create(null));

                let arrayOfObj = Object.entries(result).map((e) => ( { [e[0]]: e[1] } ));
                this.groupedVideoFileList = arrayOfObj;
            }

            console.log("1", this.groupedImageFileList);
            console.log("2", this.groupedVideoFileList);
            console.log("3", this.groupedOtherFileList);


        }).catch((err) => {
            
        });
        this.isLoading = false;
    },

    methods:{
        openVideoViewDialog(index, video){
            this.selectedVideoIndex = index;
            this.selectedViedoName = video.fileOriName
            this.videoViewDialog = true;
        }
    }
}
</script>

<style lang="scss" rel="stylesheet/scss" scoped>
    .image-con{
        width: calc(20% - 10px);
        cursor: pointer;
        margin: 5px;
        display: inline-block;
        max-height: 280px;
    }
    .video-con{
        width: calc(20% - 10px);
        cursor: pointer;
        margin: 5px;
        display: inline-block;
    }
    .image {
        width: calc(20% - 10px);
        cursor: pointer;
        margin: 5px;
        display: inline-block;
        max-height: 280px;
        height: calc(20vw - 10px);
        border-radius: 10px;
    }
    .mo-image{
        width: 100%;
        cursor: pointer;
        display: inline-block;
        max-height: 280px;
        height: calc(20vw - 10px);
        border-radius: 10px;
    }
    .mo-video{
        width: 100%;
        cursor: pointer;
        display: inline-block;
        max-height: 280px;
        height: calc(20vw - 10px);
        border-radius: 10px;
        background: #49d29e;
        overflow: hidden;
        color: white!important;;
    }
</style>