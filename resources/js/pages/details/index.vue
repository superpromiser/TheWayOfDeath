<template>
    <v-container>
        <v-container>
            text-sm-center
        </v-container>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    data:()=>({
        // contentData:null
    }),

    computed:{
        currentpath(){
            return this.$route;
        },
        ...mapGetters({
            contentData:'content/postDetail'
        })
    },

    mounted(){
        console.log(this.contentData)
    }
}
</script>

<style>

</style>