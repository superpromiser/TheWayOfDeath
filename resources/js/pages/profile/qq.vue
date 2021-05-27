<template>
    <v-container class="pa-0" v-if="$isMobile()">
        <v-row class="ma-0 bg-white justify-center position-relative" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold py-4">修改QQ号</p>
            <v-btn @click="updateProfile" :dark="isChanged" :disabled="!isChanged" :loading="isLoading" color="#7879ff" class="position-absolute put-align-center elevation-0" style="right: 12px; top:50%">
                保存
            </v-btn>
        </v-row>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="$refs.qq.focus()">
                <v-text-field v-model="user.qq" ref="qq" hint="请输入正确的QQ号" dense color="#7879ff" class="mt-0 pt-0"></v-text-field>
            </v-col>
        </v-row>
    </v-container>
    <v-container class="h-100" v-else>
        <v-row class="h-100">
            <v-col cols="12" class="d-flex justify-center align-center h-100">
                <div class="qq-content text-center">
                    <v-icon size="45" class="ma-3 mx-auto" color="#999999">
                        mdi-qqchat
                    </v-icon>
                    <p>QQ号: {{notSetQQ? '未绑定QQ号': user.qq}}</p>
                    <v-btn dark color="#7879ff" @click="openDialog">
                        {{notSetQQ? '绑定': '更新'}}
                    </v-btn>
                </div>
            </v-col>
        </v-row>
        <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'"  v-model="qqDialog" @click:outside="closeDialog" width="100%" max-width="500px">
            <v-card>
                <v-card-text class="pt-5">
                    <v-text-field solo hide-details v-model="qq"></v-text-field>
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
        notSetQQ: false,
        qqDialog: false,
        qq: '',
        isLoading: false,
        oldQQ: '',
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
                if(val.qq !== this.oldQQ){
                    this.isChanged = true;
                }
            },
            deep:true
        }
    },

    created(){
        if(this.user.qq == null){
            this.notSetQQ = true;
        }
        else{
            this.qq = this.user.qq;
        }
        this.oldQQ = this.user.qq;
    },

    methods:{
        openDialog(){
            this.qq = this.user.qq;
            this.qqDialog = true;
        },
        closeDialog(){
            
        },
        async submit(){
            this.isLoading = true;
            let payload = {
                userId: this.user.id,
                qq: this.qq
            }
            await updateProfile(payload)
            .then((res) => {
                this.user.qq = this.qq;
                this.notSetQQ = false
            }).catch((err) => {
                
            });
            this.qq = '';
            this.qqDialog = false;
            this.isLoading = false;
        },

        async updateProfile(){
            if(this.user.qq.trim() == ''){
                return this.$snackbar.showMessage({content: 'QQ号字段不能为空', color: 'error'});
            }
            this.isLoading = true;
            let payload = {
                userId: this.user.id,
                qq: this.user.qq
            }
            await updateProfile(payload)
            .then((res) => {
                this.$snackbar.showMessage({content: '操作成功', color: 'success'})
                this.isChanged = false;
                this.oldQQ = this.user.qq
            }).catch((err) => {
                
            });
            this.isLoading = false;
        }
    }
}
</script>

<style>

</style>