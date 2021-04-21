<template>
    <v-container class="h-100">
        <v-row class="h-100">
            <v-col cols="12" class="d-flex justify-center align-center h-100">
                <div class="wechat-content text-center">
                    <v-icon size="45" class="ma-3 mx-auto" color="#999999">
                        mdi-wechat
                    </v-icon>
                    <p>微信号: {{notSetWechat? '未设置微信号': user.wechat}}</p>
                    <v-btn dark color="#49d29e" @click="openDialog">
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
                    <v-btn text color="#49d29e" dark @click="submit" :loading="isLoading"> 
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
    }),

    computed:{
        ...mapGetters({
            user: 'auth/user',
        }),
    },

    created(){
        if(this.user.wechat == null){
            this.notSetWechat = true;
        }
        else{
            this.wechat = this.user.wechat
        }
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
            }).catch((err) => {
                
            });
            this.wechat = '';
            this.wechatDialog = false;
            this.isLoading = false;
        }
    }
}
</script>

<style>

</style>