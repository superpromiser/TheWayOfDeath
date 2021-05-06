<template>
    <v-container class="pa-0">
        <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="primary"
            ></v-progress-circular>
        </div>
        <div v-else class="">
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
                        <h2><span v-if="user.roleId == 3 || user.roleId == 7">老师</span>
                            <span v-if="user.roleId == 4">家长</span>
                            <span v-if="user.roleId == 5">学生</span>资料</h2>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex align-center justify-end">
                        <v-btn
                            tile
                            dark
                            color="#7879ff"
                            :loading="isSubmit"
                            @click="submit"
                        >
                            {{ lang.submit }}
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        
            <div class="px-10 mt-5">
            <v-row justify-space-between class="py-2">
                <v-col cols="6" class="d-flex align-center">
                    <span>头像</span>
                </v-col>
                <v-col cols="6"  class="py-2"  @click="clickUploadImageBtn">
                    <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="primary" size="40" class="float-right">
                        <span class="white--text headline">{{user.name[0]}}</span>
                    </v-avatar>
                    <v-avatar v-else
                        size="40"
                        class="float-right"
                    >
                        <v-img :src="user.avatar"></v-img>
                    </v-avatar>
                    <input
                        ref="imageUploader"
                        class="d-none"
                        type="file"
                        accept="image/*"
                        @change="onImageFileChanged"
                    >
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row justify-space-between  class="py-2">
                <v-col cols="6" class="d-flex align-center">
                    <span>昵称</span>
                </v-col>
                <v-col cols="6" class="text-right">
                    <v-text-field
                        solo
                        v-model="user.name"
                        hide-details
                        dense
                        class=""
                    ></v-text-field>
                </v-col>
                
            </v-row>
            <v-divider light></v-divider>
            <v-row justify-space-between  class="py-2">
                <v-col cols="6" class="d-flex align-center">
                    <span>二维码</span>
                </v-col>
                <v-col  class="float-right">
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                    <v-icon class="float-right">
                        mdi-qrcode-scan
                    </v-icon>
                </v-col>
                
            </v-row>
            <v-divider light></v-divider>
            <v-row  class="py-2">
                <v-col cols="6" class="d-flex align-center">
                    手机号
                </v-col>
                <v-col cols="6" class="text-right">
                    <v-text-field
                        solo
                        v-model="user.phoneNumber"
                        hide-details
                        dense
                        class=""
                    ></v-text-field>
                </v-col>
                
            </v-row>
            <v-divider light></v-divider>
            <v-row class="py-2">
                <v-col cols="6" class="d-flex align-center">
                    人员状态
                </v-col>
                <v-col  cols="6" class="text-right">
                     <v-select
                        solo
                        :items="userStatusItem"
                        :menu-props="{ top: false, offsetY: true }"
                        item-text="label"
                        label="人员状态"
                        hide-details
                        dense
                        v-model="user.status"
                        class="w-50 ml-auto"
                    ></v-select>
                </v-col>
                
            </v-row>
            <v-divider light></v-divider>
            <v-row class="py-2" v-if="this.user.roleId == 3 || this.user.roleId == 7" >
                <v-col cols="6" class="d-flex align-center">
                    职位
                </v-col>
                <v-col  cols="6" class="text-right">
                     <v-select
                        solo
                        :items="scheduleItem"
                        :menu-props="{ top: false, offsetY: true }"
                        item-text="subjectName"
                        label="职位"
                        value="subjectName"
                        hide-details
                        dense
                        v-model="user.subjectName"
                        class="w-50 ml-auto"
                    ></v-select>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <div class="divider"></div>
            <v-row class="py-2">
                <v-col cols="6">
                    教师发展档案
                </v-col>
                <v-col cols="6" class="text-right">
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row  class="py-2">
                <v-col cols="6">
                    个人分享
                </v-col>
                <v-col cols="6" class="text-right">
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            </div>
        </div>
    </v-container>
</template>

<script>
import {getSelUser} from '~/api/user'
import {uploadImage} from '~/api/upload'
import {getScheduleData} from '~/api/application'
import {updateProfile} from '~/api/user'
import lang from '~/helper/lang.json'
export default {
    data:()=>({
        user:null,
        isLoading:false,
        isImageSelecting:false,
        selectedImageFile:null,
        lang,
        userStatusItem: [
            {
                label: "在办公室",
                value: "在办公室"
            },
            {
                label: "上课中",
                value: "上课中"
            },
            {
                label: "会议中",
                value: "会议中"
            },
            {
                label: "待客中",
                value: "待客中"
            },
            {
                label: "忙碌中",
                value: "忙碌中"
            },
            {
                label: "外出中",
                value: "外出中"
            },
        ],
        scheduleItem:[],
        isSubmit:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        this.isLoading = true
        await getSelUser({userId:this.currentPath.params.userId}).then(res=>{
            console.log(res.data)
            this.user = res.data
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
        })
        getScheduleData().then(res=>{
            console.log('this.scheduleItem',res.data)
            this.scheduleItem = res.data
        }).catch(err=>{
            console.log(err.response)               
        })
    },
    methods:{
        clickUploadImageBtn(){
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
                    let path = `/uploads/image/${res.data}`;
                    this.user.avatar = path
                    this.isImageSelecting = false
                    this.selectedImageFile = null
                    this.updateAvatar(path)
                }).catch((err) => {
                    //console.log(err);
                    this.isImageSelecting = false
                }); 
            }

            //reset image file input
            this.$refs.imageUploader.value = ''
            
        },
        updateAvatar(path){
            let payload = {
                userId : this.user.id,
                avatar : path
            }
            updateProfile(payload)
            .then((res) => {
                console.log(res);
            }).catch((err) => {
                
            });
        },
        async submit(){
            this.isSubmit = true;
            await updateProfile({
                application:true,
                userId:this.user.id,
                avatar:this.user.avatar,
                name:this.user.name,
                phoneNumber:this.user.phoneNumber,
                status:this.user.status,
                subjectName:this.user.subjectName
            }).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                this.$router.push({name:'classSpace.member'})
            }).catch(err=>{
                console.log(err.response)
            })
        }
    }
}
</script>

<style>

</style>