<template>
    <v-container class="pa-0">
        <v-row class="ma-0 bg-secondary justify-center position-relative" >
            <v-icon size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold py-4">基本信息</p>
            <v-btn rounded dark color="#49d29e" class="position-absolute put-align-center" style="right: 12px; top:50%">
                保存
            </v-btn>
        </v-row>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
                <p class="mb-0 font-size-0-75">用户头像</p>
                <v-avatar color="#49d29e" size="60" class="rounded-lg"  >
                    <span v-if="user.avatar == '/'" class="white--text headline">{{user.name[0]}}</span>
                    <v-img v-else :src="`${baseUrl}${user.avatar}`"></v-img>
                </v-avatar>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-row class="ma-0">
            <v-col class="d-flex align-center justify-space-between" cols="12" v-ripple>
                <p class="mb-0 font-size-0-75 w-100">用户名</p>
                <v-text-field v-model="user.name" hide-details dense color="#7879ff" class="mt-0 pt-0"></v-text-field>
            </v-col>
        </v-row>
        <v-divider></v-divider>
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
        
    }),
    computed:{
        ...mapGetters({
            user: 'auth/user',
        }),
    },

    methods:{

    }
}
</script>

<style>

</style>