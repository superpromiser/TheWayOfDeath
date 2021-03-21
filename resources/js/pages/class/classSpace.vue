<template>
    <v-container class="pa-0">
        <ClassTabBar :path="currentPath"></ClassTabBar>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-container>
</template>

<script>
import ClassTabBar from '~/components/classTabBar';
export default {
    components:{
        ClassTabBar,
    },
    computed:{
        currentPath(){
            return this.$route;
        },
    },

}
</script>

<style>

</style>