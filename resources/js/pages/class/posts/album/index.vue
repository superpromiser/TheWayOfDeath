<template>
    <v-container class="pa-0"> 
        <v-row class="d-flex justify-center pt-10  ma-0">
            <v-col cols="12 d-flex justify-center position-relative">
                <h2 class="red--text text--lighten-1 position-absolute" style="top:0; font-size: 3rem;">相册</h2>
                <img :src="`${baseUrl}/asset/img/icon/header-red-ribbon.png`" alt="ribbon" class="class-ribbon-img" />
                <h2 class="position-absolute white--text" style="bottom:55px">classname</h2>
            </v-col>
        </v-row>
        <v-row class="d-flex justify-center ma-0">
            <v-col cols="12" class="d-flex justify-center">
                <img :src="`${baseUrl}/asset/img/class/3.png`" alt="classImage" class="class-img" />
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="6" md="3" lg="4">
                <img src="" alt="">
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data: ()=> ({
        baseUrl: window.Laravel.base_url,
    })
}
</script>

<style>

</style>