<template>
    <v-container>
        <v-row>
            <v-col cols="12" class="d-flex align-center justify-center">
                <v-btn color="#7879ff" dark 
                    :loading="isFileSelecting"
                    @click="clickUploadFileBtn">
                    <v-icon left>
                        mdi-file-upload
                    </v-icon>
                    upload csv
                </v-btn>
                <input
                    ref="fileUploader"
                    class="d-none"
                    type="file"
                    accept="file/*"
                    @change="onFileFileChanged"
                >
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { uploadOtherForExcel } from '~/api/upload'
export default {
    data: ()=> ({
        selectedFile: null,
        isFileSelecting: false,
    }),

    methods:{
        clickUploadFileBtn() {
            window.addEventListener('focus', () => {
            }, { once: true })
            this.$refs.fileUploader.click()
        },
        async onFileFileChanged(e) {
            this.selectedFile = e.target.files[0];
            if(this.selectedFile !== undefined && this.selectedFile !== null) {
                this.isFileSelecting = true;
                let fileData = new FormData();
                fileData.append('file', this.selectedFile);
                await uploadOtherForExcel(fileData)
                .then((res) => {
                    console.log(res);
                    this.isFileSelecting = false
                }).catch((err) => {
                    //console.log(err);
                    this.isFileSelecting = false
                });
                
            }
            //reset file input
            this.$refs.fileUploader.value = ''
        },
    }
}
</script>

<style>

</style>