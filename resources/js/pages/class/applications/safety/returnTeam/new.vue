<template>
    <v-container class="pa-0">
        <v-banner>
            <v-row class="ma-0">
                <v-col>
                    <div class="text-center d-flex justify-space-between align-center">
                        <a @click="$router.go(-1)" class="float-left">
                            <v-icon size="70">
                                mdi-chevron-left
                            </v-icon>
                        </a>
                        <span style="font-size:30px;line-height:2">归程队管理</span> 
                        <div class="float-right">
                            <v-btn dark color="#7879ff" @click="submit">
                                新建归程队
                            </v-btn>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-banner>
        <v-container>
            <v-row class="ma-0 hover-cursor-point" v-ripple @click="clickUploadImageBtn">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0" >头像 </p>
                    <div class="d-flex align-center">
                        <v-avatar size="50" :color="returnTeamData.name == '' && returnTeamData.avatar == null ? '#999999': '#49d29e'">
                            <v-img v-if="returnTeamData.avatar !== null" :src="`${baseUrl}${returnTeamData.avatar}`"> </v-img>
                            <span v-else-if="returnTeamData.name !== ''" class="white--text headline">{{returnTeamData.name[0]}}</span>
                            <v-icon v-else dark >
                                mdi-account
                            </v-icon>
                        </v-avatar>
                        <v-icon class="ml-4" color="#999999" size="40">
                                mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <input
                ref="imageUploader"
                class="d-none"
                type="file"
                accept="image/*"
                @change="onImageFileChanged"
            >
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point" v-ripple @click="$refs.returnTeamName.focus()">
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0 w-100"  >归程队名称 </p>
                    <v-text-field
                        class="pt-0 mt-0"
                        color="#7879ff"
                        single-line
                        v-model="returnTeamData.name"
                        label="清输入归程队名称"
                        hide-details
                        ref="returnTeamName"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point" v-ripple>
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0 w-100"  >领队教师 </p>
                    <div class="d-flex align-center">
                        <p v-if="returnTeamData.teacher !== null" class="mb-0 secondary-text">ssss</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point" v-ripple>
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0 w-100"  >归程队成员</p>
                    <div class="d-flex align-center">
                        <p v-if="returnTeamData.member.length !== 0" class="mb-0 secondary-text">ssss</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <v-divider light></v-divider>
            <v-row class="ma-0 py-3 hover-cursor-point" v-ripple>
                <v-col cols="12" class="d-flex justify-space-between align-center">
                    <p class="mb-0 w-100"  >归程队组长 </p>
                    <div class="d-flex align-center">
                        <p v-if="returnTeamData.leader !== null" class="mb-0 secondary-text">ssss</p>
                        <v-icon class="ml-4" color="#999999" size="40">
                            mdi-chevron-right
                        </v-icon>
                    </div>
                </v-col>
            </v-row>
            <!-- <v-divider light></v-divider>
            <v-row class="ma-0 " >
                <v-expansion-panels>
                    <v-expansion-panel  class="box-shadow-none">
                        <v-expansion-panel-header v-ripple disable-icon-rotate>
                            归程队组长
                            <template v-slot:actions>
                                <p v-if="returnTeamData.leader !== null" class="mb-0 secondary-text">ssss</p>
                                <v-icon class="ml-4" color="#999999" size="40">
                                    mdi-chevron-right
                                </v-icon>
                            </template>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-row> -->
            <v-divider light></v-divider>
            <v-subheader>leader</v-subheader>
            <v-row class="ma-0 py-3">
                <v-col cols="12" sm="6" md="4" lg="3" xl="2">
                    <v-card>
                        <v-avatar>
                            <v-icon>
                                mdi-account
                            </v-icon>
                        </v-avatar>
                        <v-card-title>ddd</v-card-title>
                        <v-card-subtitle>ddd</v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>
            <v-subheader>member</v-subheader>
            <v-row class="ma-0 py-3">
                <v-col cols="12" sm="6" md="4" lg="3" xl="2">
                    <v-card>
                        <v-avatar>
                            <v-icon>
                                mdi-account
                            </v-icon>
                        </v-avatar>
                        <v-card-title>ddd</v-card-title>
                        <v-card-subtitle>ddd</v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
import {uploadImage} from '~/api/upload'

export default {

    data: ()=> ({
        baseUrl:window.Laravel.base_url,
        isImageSelecting: false,
        selectedImageFile: null,
        returnTeamData: {
            avatar: null,
            name: '',
            teacher: null,
            leader: null,
            member: [],
        }
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
                    this.returnTeamData.avatar = `/uploads/image/${res.data}`;
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

        submit(){
            console.log(this.returnTeamData)
        }
    }
}
</script>

<style>

</style>