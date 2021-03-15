<template>
    <v-container>
        <!--  IMAGE VIEWER  -->
        <v-row>
            <v-col v-for="(imgUrl, index) in items.imgUrl" :key="index" cols="6" sm="4" md="3" lg="2" class="position-relative">
                <v-img :src="`${baseUrl}${imgUrl.path}`" alt="upload image" class="uploaded-image" ></v-img>
            </v-col>
        </v-row>
        <!--  VIDEO VIEWER  -->
        <v-row>
            <v-col v-for="(video, index) in items.videoUrl" :key="index" cols="6" sm="4" md="4" lg="3" class="position-relative">
                <v-card
                    class="d-flex align-center "
                    color="grey lighten-2"
                    flat
                    tile
                >
                    <img :src="`${baseUrl}/asset/img/upload_video_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="">
                        <div><span><strong>{{video.fileOriName}}</strong></span></div>
                        <div>{{video.fileSize}}</div>
                    </div>
                </v-card>
            </v-col>
        </v-row>
        <!--  FILE VIEWER  -->
        <v-row>
            <v-col v-for="(other, index) in items.otherUrl" :key="index" cols="6" sm="4" md="4" lg="3" class="position-relative">
                <v-card
                    class="d-flex align-center "
                    color="grey lighten-2"
                    flat
                    tile
                >
                    <img :src="`${baseUrl}/asset/img/upload_file_img.png`" alt="upload-video-icon" class="uploaded-video-icon ma-2" />
                    <div class="">
                        <div><span><strong>{{other.fileOriName}}</strong></span></div>
                        <div>{{other.fileSize}}</div>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    props:{
        items:{
            type: Object,
            required: false,
        },
    },

    data: () => ({
        baseUrl:window.Laravel.base_url,
    })
}
</script>

<style>

</style>