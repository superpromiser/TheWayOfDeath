<template>
    <v-container class="h-100">
        <v-row class="h-100">
            <v-col cols="12" class="d-flex justify-center align-center h-100">
                <div class="wechat-content text-center">
                    <v-icon size="45" class="ma-3 mx-auto" color="#999999">
                        mdi-wechat
                    </v-icon>
                    <p>WechatId: {{notSetWechat? 'asdf': 'asdf'}}</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae dolor quod autem ab ipsa ratione cumque perspiciatis praesentium quaerat natus.</p>
                    <v-btn dark color="#49d29e">
                        {{notSetWechat? 'asdf': 'asdf'}}
                    </v-btn>
                </div>
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
        notSetWechat: false
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
    },
}
</script>

<style>

</style>