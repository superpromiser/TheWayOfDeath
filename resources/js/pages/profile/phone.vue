<template>
    <v-container class="pa-0">
        <v-row class="ma-0 bg-white justify-center position-relative" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold py-4">修改电话号码</p>
            <v-btn @click="updateProfile" :dark="isChanged" :disabled="!isChanged" :loading="isLoading" color="#7879ff" class="position-absolute put-align-center elevation-0" style="right: 12px; top:50%">
                保存
            </v-btn>
        </v-row>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple @click="$refs.phoneNumber.focus()">
                <v-text-field 
                    v-model="user.phoneNumber" 
                    ref="phoneNumber" 
                    hint="请正确输入您的电话号码" 
                    dense 
                    color="#7879ff" 
                    class="mt-0 pt-0 max-length-11-staff-input"
                    :counter="11"
                ></v-text-field>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
import {updateProfile} from '~/api/user'
import lang from '~/helper/lang.json'

export default {
    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        isLoading: false,
        oldPhoneNumber: '',
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
                if(val.phoneNumber !== this.oldPhoneNumber){
                    this.isChanged = true;
                }
            },
            deep:true
        }
    },

    mounted(){
        var ele_11 = $('.max-length-11-staff-input');
        ele_11.find('input').attr("maxlength","11")
    },

    created(){
        this.oldPhoneNumber = this.user.phoneNumber;
    },

    methods:{
        async updateProfile(){
            if(this.user.phoneNumber.trim() == ''){
                return this.$snackbar.showMessage({content: '电话号码字段为空', color: 'error'});
            }
            if(/^\d*$/.test(this.user.phoneNumber) == false){
                return this.$snackbar.showMessage({content: '请输入正确的电话号码', color: 'error'});
            }
            let payload = {
                phoneNumber: this.user.phoneNumber,
                userId: this.user.id
            }
            this.isLoading = true;
            await updateProfile(payload)
            .then((res) => {
                this.oldPhoneNumber = this.user.phoneNumber;
                this.isChanged = false;
                this.$snackbar.showMessage({content: '操作成功', color: 'success'})
            }).catch((err) => {
            });
            this.isLoading = false;
        }

    }
}
</script>

<style>

</style>