<template>
    <v-container>
        <PostItem/>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-container>
</template>

<script>
import PostItem from '~/components/postItem'
export default {
    components:{
        PostItem,
    }
}
</script>

<style>

</style>