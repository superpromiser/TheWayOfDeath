<template>
    <v-container fluid>
        <v-row>
            <v-textarea
                background-color="grey lighten-3"
                color="grey darken-4"
                clearable
                clear-icon="mdi-close-circle"
                :label="Label"
                value=""
                v-model="contentData.text"
            ></v-textarea>
        </v-row>
        <v-row>
            <v-btn
                color="error"
                fab
                small
                dark
                :loading="isImageSelecting"
                @click="clickUploadImageBtn"
            >
              <v-icon>mdi-file-image-outline</v-icon>
            </v-btn>
            <input
                ref="uploader"
                class="d-none"
                type="file"
                accept="image/*"
                @change="onImageFileChanged"
            >
            <!-- <v-file-input
                accept="image/*"
                ref="uploader"
                class="d-none"
                @change="onImageFileChanged"
            ></v-file-input> -->
        </v-row>
    </v-container>
</template>

<script>
import {uploadImage} from '~/api/upload'
export default {
    props: {
        Label : {
            type: String,
            required: true
        }
    },
    data: () =>({
        contentData:{
            text:'',
            imgUrl:[],
            otherUrl:[],
            videoUrl:[]
        },
        selectedImageFile: null,
        isImageSelecting: false
    }),
    methods:{
        clickUploadImageBtn() {
            this.isImageSelecting = true
            window.addEventListener('focus', () => {
                this.isImageSelecting = false
            }, { once: true })
            this.$refs.uploader.click()
        },
        async onImageFileChanged(e) {
            this.selectedImageFile = e.target.files[0];
            if(this.selectedImageFile !== undefined && this.selectedImageFile !== null) {
                this.isImageSelecting = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedImageFile);
                await uploadImage(fileData)
                .then((res) => {
                    console.log(res);
                    res = `/uploads/image/${res.data}`
                    this.contentData.imgUrl.push(res);
                    this.isImageSelecting = false
                }).catch((err) => {
                    console.log(err);
                    this.isImageSelecting = false
                });
            }
            console.log("^^^^^^^^^^^^^^^^", this.contentData.imgUrl);
            // this.selectedImageFile = e.target.files[0]
        }
    }
}
</script>

<style>

</style>