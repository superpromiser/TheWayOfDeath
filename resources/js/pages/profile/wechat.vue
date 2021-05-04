<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-row class="ma-0 bg-secondary justify-center position-relative" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold py-4">修改微信号</p>
            <v-btn @click="updateProfile" rounded :dark="isChanged" :disabled="!isChanged" :loading="isLoading" color="#7879ff" class="position-absolute put-align-center" style="right: 12px; top:50%">
                保存
            </v-btn>
        </v-row>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="$refs.wechat.focus()">
                <v-text-field v-model="user.wechat" ref="wechat" hint="请输入正确的微信号" dense color="#7879ff" class="mt-0 pt-0"></v-text-field>
            </v-col>
        </v-row>
    </v-container>
    <v-container class="h-100" v-else>
        <v-row class="h-100">
            <v-col cols="12" class="d-flex justify-center align-center h-100">
                <div class="wechat-content text-center">
                    <v-icon size="45" class="ma-3 mx-auto" color="#999999">
                        mdi-wechat
                    </v-icon>
                    <p>微信号: {{notSetWechat? '未设置微信号': user.wechat}}</p>
                    <v-btn dark color="#7879ff" @click="openDialog">
                        {{notSetWechat? '新注册': '更新'}}
                    </v-btn>
                </div>
            </v-col>
        </v-row>
        <v-dialog v-model="wechatDialog" @click:outside="closeDialog" width="100%" max-width="500px">
            <v-card>
                <v-card-text class="pt-5">
                    <v-text-field solo hide-details v-model="wechat"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text color="#7879ff" dark @click="submit" :loading="isLoading"> 
                        保存
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import {updateProfile} from '~/api/user'
import lang from '~/helper/lang.json'
export default {    
    data: ()=> ({
        lang,
        notSetWechat: false,
        wechatDialog: false,
        wechat: '',
        isLoading: false,
        oldWechat: '',
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
                if(val.wechat !== this.oldWechat){
                    this.isChanged = true;
                }
            },
            deep:true
        }
    },

    created(){
        if(this.user.wechat == null){
            this.notSetWechat = true;
        }
        else{
            this.wechat = this.user.wechat
        }
        this.oldWechat = this.user.wechat;
    },

    methods:{
        openDialog(){
            this.wechat = this.user.wechat;
            this.wechatDialog = true;
        },
        closeDialog(){
            
        },
        async submit(){
            this.isLoading = true;
            let payload = {
                userId: this.user.id,
                wechat: this.wechat
            }
            await updateProfile(payload)
            .then((res) => {
                this.user.wechat = this.wechat;
                this.notSetWechat = false;
                this.oldWechat = this.user.wechat
                this.isChanged = false;
            }).catch((err) => {
                
            });
            this.wechat = '';
            this.wechatDialog = false;
            this.isLoading = false;
        },

        async updateProfile(){
            if(this.user.wechat.trim() == ''){
                return this.$snackbar.showMessage({content: '微信号字段不能为空', color: 'error'});
            }
            this.isLoading = true;
            let payload = {
                userId: this.user.id,
                wechat: this.user.wechat
            }
            await updateProfile(payload)
            .then((res) => {
                this.$snackbar.showMessage({content: '操作成功', color: 'success'})
                this.isChanged = false;
                this.oldWechat = this.user.wechat
            }).catch((err) => {
                
            });
            this.isLoading = false;
        }
    }
}
</script>

<style>

</style>