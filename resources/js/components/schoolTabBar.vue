<template>
    <v-container class="d-flex align-center pa-0 pt-5 school-tab-bar">
        <v-tabs>
            <v-tab to="/schoolspace/1/news">最新</v-tab>
            <v-tab to="/schoolspace/1/application">应用</v-tab>
            <v-tab to="/schoolspace/1/member">成员</v-tab>
        </v-tabs>
        <router-link to="/schoolspace/1/post">
            <v-btn
                tile
                color="success"
                class="mr-5"
                >
                <v-icon left>
                    mdi-book-plus 
                </v-icon>
                发布
            </v-btn>
        </router-link>
    </v-container>
</template>

<script>
export default {

}
</script>

<style>

</style>