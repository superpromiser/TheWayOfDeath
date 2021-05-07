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
                    上传文件
                </v-btn>
                <input
                    ref="fileUploader"
                    class="d-none"
                    type="file"
                    accept=".csv, .xlsx, .xls"
                    @change="onFileFileChanged"
                >
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { uploadOtherForExcel } from '~/api/upload'
import XLSX from 'xlsx'
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
            // this.selectedFile = e.target.files[0];
            var files = e.target.files, f = files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, {type: 'array'});
                let sheetName = workbook.SheetNames[0]
                /* DO SOMETHING WITH workbook HERE */
                console.log(workbook);
                let worksheet = workbook.Sheets[sheetName];
                console.log(XLSX.utils.sheet_to_json(worksheet));
            };
            reader.readAsArrayBuffer(f);
            // if(this.selectedFile !== undefined && this.selectedFile !== null) {
            //     this.isFileSelecting = true;
            //     let fileData = new FormData();
            //     fileData.append('file', this.selectedFile);
            //     await uploadOtherForExcel(fileData)
            //     .then((res) => {
            //         console.log(res);
            //         this.isFileSelecting = false
            //     }).catch((err) => {
            //         //console.log(err);
            //         this.isFileSelecting = false
            //     });
                
            // }
            //reset file input
            this.$refs.fileUploader.value = ''
        },
    }
}
</script>

<style>

</style>