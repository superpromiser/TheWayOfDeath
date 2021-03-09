<template>
    <v-container class="d-flex align-center">
        <v-tabs>
            <v-tab to="/schoolspace/1/news">最新</v-tab>
            <v-tab to="/schoolspace/1/application">应用</v-tab>
            <v-tab to="/schoolspace/1/member">成员</v-tab>
            <!-- <v-tab to="/schoolspace/1/post">发布</v-tab> -->
        </v-tabs>
        <router-link to="/schoolspace/1/post">
            <v-btn>发布</v-btn>
        </router-link>
    </v-container>
</template>

<script>
export default {

}
</script>

<style>

</style>