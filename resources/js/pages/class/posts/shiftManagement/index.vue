<template>
    <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <v-row>
                <v-col cols="12" class="justify-space-between d-flex ma-0 align-center">
                    <a @click="$router.go(-1)">
                        <v-icon size="70">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                <!-- </v-col>
                <v-col> -->
                    <!-- <v-avatar
                        class="ma-3 ml-3"
                        size="50"
                        tile
                    >
                        <v-img :src="`${baseUrl}/asset/img/newIcon/问卷.png`" alt="postItem" ></v-img>
                    </v-avatar> -->
                    <h2>接班管理</h2>
                <!-- </v-col>
                <v-col> -->
                    <v-btn
                        tile
                        class="mr-5"
                        @click="post"
                        >
                        <v-icon left>
                            mdi-book-plus 
                        </v-icon>
                        发布
                    </v-btn>
                    <v-btn
                        tile
                        color="success"
                        class="mr-5"
                        @click="post"
                        >
                        <v-icon left>
                            mdi-book-plus 
                        </v-icon>
                        发布
                    </v-btn>
                </v-col>
            </v-row>
        </v-banner>
</template>

<script>
export default {

}
</script>

<style>

</style>