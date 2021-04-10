<template>
    <v-img
        height="100%"
        :src="`${baseUrl}/asset/img/WEB.png`"
            
    >
            <RouterBack title='新増访客'></RouterBack>
        <v-container>
            <vue-web-cam 
                v-if="isStart"
                ref="webcam" 
                @started="onStarted"
                @stopped="onStopped"
                @error="onError"
                @cameras="onCameras"
                :selectFirstDevice="true"/>
            <v-row class="ma-0 d-flex align-center justify-center mt-5">
                <v-btn color="#3989fc" dark @click="onCapture">
                    <v-icon left> mdi-camera </v-icon>
                    拍摄照片
                </v-btn>
                <v-btn color="#eb5846" dark @click="onStop" class="mx-5">
                    <v-icon left> mdi-stop </v-icon>
                    停止相机
                </v-btn>
                <v-btn color="#49d29e" dark @click="onStart">
                    <v-icon left> mdi-play </v-icon>
                    启动相机
                </v-btn>
            </v-row>
            <v-card class="pa-5 guest-welcome-bg" tile >
                <v-row class="ma-0">
                    <v-col cols="12" md="6" class="d-flex justify-center align-center" >
                        <v-avatar
                            class="profile"
                            color="#7879ff"
                            size="100%"
                            max-width="500px"
                            min-width="250px"
                            max-height="500px"
                            min-height="250px"
                        >   
                            <v-icon v-if="guestData.avatar == null" size="500" color="white">
                                mdi-account
                            </v-icon>
                            <!-- <v-img v-if="guestData.avatar == null" src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img> -->
                            <v-img v-else :src="guestData.avatar"></v-img>
                        </v-avatar>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-row class=" align-center ma-0">
                            <v-col cols="6">
                                <p class="mb-0">姓名</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.name"
                                    solo
                                    label="姓名"
                                    clearable
                                    hide-details
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class=" align-center ma-0">
                            <v-col cols="6">
                                <p class="mb-0">身份证件号</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.cardNum"
                                    solo
                                    label="身份证件号"
                                    clearable
                                    hide-details
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class=" align-center ma-0">
                            <v-col cols="6">
                                <p class="mb-0">电话号码</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.phoneNumber"
                                    solo
                                    label="电话号码"
                                    clearable
                                    hide-details
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class=" align-center ma-0">
                            <v-col cols="6">
                                <p class="mb-0">被访问者的姓名</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.memberName"
                                    solo
                                    label="被访问者的姓名"
                                    clearable
                                    hide-details
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class=" align-center ma-0">
                            <v-col cols="6">
                                <p class="mb-0">被访问者的电话号码</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.memberPhone"
                                    solo
                                    label="被访问者的电话号码"
                                    clearable
                                    hide-details
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class=" align-center ma-0">
                            <v-col cols="6">
                                <p class="mb-0">拜访时间</p>
                            </v-col>
                            <v-col cols="6">
                                <v-datetime-picker 
                                    label="拜访时间" 
                                    v-model="guestData.meetingDate"
                                    :okText='lang.ok'
                                    :clearText='lang.cancel'
                                > </v-datetime-picker>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class=" align-center ma-0">
                            <v-col cols="6">
                                <p class="mb-0">拜访事件</p>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="guestData.meetingReason"
                                    solo
                                    label="拜访事件"
                                    clearable
                                    hide-details
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider light></v-divider>
                        <v-row class=" align-center ma-0">
                            <v-col cols="12">
                                <v-btn
                                    depressed
                                    color="primary"
                                    class="float-right"
                                    @click="submit"
                                    :loading="isSubmit"
                                    >
                                    确定
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card>
        </v-container>
    </v-img>
</template>

<script>
import RouterBack from '~/components/routerBack'
import {createGuestRequest} from '~/api/guestMng'
import lang from '~/helper/lang.json'
export default {
    layout: 'basic',
    components:{
        RouterBack,
    },
    data:()=>({
        guestData:{
            name:'',
            avatar: null,
            cardNum:'',
            phoneNumber:'',
            memberName:'',
            memberPhone:'',
            meetingDate:'',
            meetingReason:''
        },
        baseUrl: window.Laravel.base_url,
        lang,
        menu:false,
        isSubmit:false,
        date: new Date().toISOString().substr(0, 10),
        deviceId: null,
        isStart: true,
    }),
    methods:{
        async submit(){
            console.log();
            let dateNow = new Date();
            if(this.guestData.avatar == null){
                return this.$snackbar.showMessage({content: "请拍照。", color: "error"})
            }
            if(this.guestData.name.trim() == ''){
                return this.$snackbar.showMessage({content: "请输入您的名字。", color: "error"})
            }
            if(this.guestData.cardNum.trim() == ''){
                return this.$snackbar.showMessage({content: "请输入您的卡号。", color: "error"})
            }
            if(this.guestData.phoneNumber.trim() == ''){
                return this.$snackbar.showMessage({content: "请输入您的电话号码。", color: "error"})
            }
            if(this.guestData.memberName.trim() == ''){
                return this.$snackbar.showMessage({content: "输入要拜访的人的姓名。", color: "error"})
            }
            if(this.guestData.memberPhone.trim() == ''){
                return this.$snackbar.showMessage({content: "输入要拜访人员的电话号码。", color: "error"})
            }
            if(this.guestData.meetingDate == ""){
                return this.$snackbar.showMessage({content: "记录您访问的日期和时间。", color: "error"})
            }
            if( dateNow > this.guestData.meetingDate){
                return this.$snackbar.showMessage({content: "访问时间不能早于当前时间。", color: "error"})
            }
            if(this.guestData.meetingReason.trim() == ''){
                return this.$snackbar.showMessage({content: "解释您访问的原因。", color: "error"})
            }

            this.guestData.meetingDate = this.TimeView(this.guestData.meetingDate)
            console.log(this.guestData)
            this.isSubmit = true;
            await createGuestRequest(this.guestData)
            .then((res) => {
                console.log(res);
                if (res.data.msg == 0){
                    return this.$snackbar.showMessage({content: "没有人与您输入的信息相匹配。", color: "error"})
                }
                else if (res.data.msg == 1){
                    this.guestData = {
                        name:'',
                        avatar: null,
                        cardNum:'',
                        memberName:'',
                        memberPhone:'',
                        meetingDate:'',
                        meetingReason:''
                    };
                    return this.$snackbar.showMessage({content: "已成功收到。 请稍等片刻。", color: "success"})
                }
            }).catch((err) => {
                console.log(err)
            });
            this.isSubmit = false;
        },
        notsupported(){

        },
        onCapture() {
            this.guestData.avatar = this.$refs.webcam.capture();
        },
        onStarted(stream) {
            console.log("On Started Event", stream);
        },
        onStopped(stream) {
            console.log("On Stopped Event", stream);
        },
        onStop() {
            this.isStart = false;
            this.$refs.webcam.stop();
        },
        onStart() {
            this.isStart = true;
            this.$refs.webcam.start();
        },
        onError(error) {
            console.log("On Error Event", error);
        },
        onCameras(cameras) {
            this.devices = cameras;
            console.log("On Cameras Event", cameras);
        },
    }

}
</script>

<style>

</style>