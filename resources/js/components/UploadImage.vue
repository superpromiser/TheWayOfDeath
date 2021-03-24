<template>
    <v-file-input
        accept="image/*"
        :label="uploadLabel"
        @change="getImgUrl"
        :loading="isUploading"
        :solo="solo"
    ></v-file-input>
</template>

<script>
import {uploadImage} from '~/api/upload'
export default {
    props:{
        uploadLabel:{
            type: String,
            required: true,
        },
        solo:{
            type: Boolean,
            required: false,
        },
    },

    data: () => ({
        token : window.Laravel.csrfToken,
        isUploading : false,
    }),

    methods : {
        getImgUrl(file){
            if(file !== undefined && file !== null) {
                this.isUploading = true;
                let fileData = new FormData();
                fileData.append('file', file);
                uploadImage(fileData)
                .then((res) => {
                    res = `/uploads/image/${res.data}`
                    this.$emit('upImgUrl',res)
                    this.isUploading = false
                }).catch((err) => {
                    //console.log(err.response.data);
                    this.isUploading = false
                });
            }
            else{
                this.$emit('clearedImg')
            }
        }
    }

}
</script>

<style>

</style>