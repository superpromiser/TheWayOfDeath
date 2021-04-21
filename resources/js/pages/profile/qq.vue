<template>
    <v-container class="h-100">
        <v-row class="h-100">
            <v-col cols="12" class="d-flex justify-center align-center h-100">
                <div class="qq-content text-center">
                    <v-icon size="45" class="ma-3 mx-auto" color="#999999">
                        mdi-qqchat
                    </v-icon>
                    <p>WechatId: {{notSetQQ? 'asdf': 'asdf'}}</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae dolor quod autem ab ipsa ratione cumque perspiciatis praesentium quaerat natus.</p>
                    <v-btn dark color="#49d29e">
                        {{notSetQQ? 'asdf': 'asdf'}}
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
        notSetQQ: false
    }),

    computed:{
        ...mapGetters({
            user: 'auth/user',
        }),
    },

    created(){
        if(this.user.qq == null){
            this.notSetQQ = true;
        }
    },
}
</script>

<style>

</style>