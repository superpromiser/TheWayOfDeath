<template>
    <v-container>
        <!--  IMAGE VIEWER  -->
        <!-- <v-row>
            <v-col v-for="(imgUrl, index) in items.imgUrl" :key="index" cols="6" sm="4" md="3" lg="2" class="position-relative images" v-viewer>
                <v-img :src="`${baseUrl}${imgUrl.path}`" alt="upload image" class="uploaded-image" ></v-img>
            </v-col>
        </v-row> -->
        <v-row v-viewer="options" class="images clearfix">
            <template v-for="img in items.imgUrl">
                <img :src="`${baseUrl}${img.path}`" :data-source="`${baseUrl}${img.path}`" class="image" :key="img.path" >
            </template>
        </v-row>
        <!--  VIDEO VIEWER  -->
        <v-row>
            <v-col v-for="(video, index) in items.videoUrl" :key="index" cols="6" sm="4" md="4" lg="3" class="position-relative px-1">
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
            <v-col v-for="(other, index) in items.otherUrl" :key="index" cols="6" sm="4" md="4" lg="3" class="position-relative px-1">
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
import Viewer from 'v-viewer'
export default {
    components: {
        Viewer,
    },
    props:{
        items:{
            type: Object,
            required: false,
        },
    },

    data: () => ({
        baseUrl:window.Laravel.base_url,
        options: {
            toolbar: true,
            url: 'data-source'
        },
    }),

    mounted(){
        console.log("123123123", this.items);
    },

    methods: {
        show () {
            const viewer = this.$el.querySelector('.images').$viewer
            viewer.show()
        }
    }
}
</script>

<style lang="scss" rel="stylesheet/scss" scoped>
  .image {
    width: calc(20% - 10px);
    cursor: pointer;
    margin: 5px;
    display: inline-block;
  }
</style>