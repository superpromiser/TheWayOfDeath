<template>
    <v-container class="pa-0">
        <schoolTabBar></schoolTabBar>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-container>
</template>

<script>
import schoolTabBar from '~/components/schoolTabBar';
import {getAllPost,} from '~/api/post';
export default {
    components:{
        schoolTabBar,
    },
    created(){
        getAllPost().then(res=>{
            console.log('success',res)
        }).catch(err=>{
            console.log('failed',err.response)
        })
    }

}
</script>

<style>

</style>