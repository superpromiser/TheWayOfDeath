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
export default {
    components:{
        schoolTabBar,
    }
}
</script>

<style>

</style>