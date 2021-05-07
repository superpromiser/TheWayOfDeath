<template>
    <v-container>
        <v-row>
            <v-col cols="6" class="d-flex align-center justify-start">
                <v-btn color="#3989FC" dark 
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
                    id='excelUpload'
                    type="file"
                    accept=".csv, .xlsx, .xls"
                    @change="onFileFileChanged"
                >
            </v-col>
            <v-col cols="6" class="d-flex justify-end">
                
                <v-btn color="#f89651" dark
                    class="mx-2" 
                    @click="cancelUpload">
                    <!-- <v-icon left>
                        mdi-file-upload
                    </v-icon> -->
                    取消
                </v-btn>
                <v-btn color="#7879ff" dark 
                    :loading="isUploading"
                    @click="uploadExcel">
                    <!-- <v-icon left>
                        mdi-file-upload
                    </v-icon> -->
                    保存
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-data-table
                    :headers="headers"
                    :items="uploadData"
                    loading-text="正在加载..."
                    sort-by="calories"
                    class="elevation-1"
                >
                    <template v-slot:[`item.生日`]="{ item }">
                        <span>{{TimeView(ConvertBirth(item.生日))}}</span>
                    </template>
                    <template v-slot:no-data>
                        <p>没有学习资料</p>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { uploadOtherForExcel,uploadExcelApi } from '~/api/upload'
import xlsx from 'xlsx';
export default {
    data: ()=> ({
        selectedFile: null,
        isFileSelecting: false,
        headers: [
            { text: "姓名", value: "姓名", align: 'start', },
            { text: '电话号码', value: '电话号码', sortable: false },
            { text: 'imei', value: 'imei', sortable: false },
            { text: '角色代码', value: '角色代码' },
            { text: '学校代码', value: '学校代码', sortable: false },
            { text: '年级代码', value: '年级代码', sortable: false },
            { text: '班级代码', value: '班级代码'},
            { text: '性别', value: '性别', sortable: false },
            { text: '国籍', value: '国籍', sortable: false },
            { text: '身份证号码', value: '身份证号码', sortable: false },
            { text: '家庭地址(省)', value: '家庭地址(省)', sortable: false },
            { text: '家庭地址(市)', value: '家庭地址(市)', sortable: false },
            { text: '家庭地址(区)', value: '家庭地址(区)', sortable: false },
            { text: '家庭地址(详细地址)', value: '家庭地址(详细地址)', sortable: false },
            { text: '现住址(省)', value: '现住址(省)', sortable: false },
            { text: '现住址(市)', value: '现住址(市)', sortable: false },
            { text: '现住址(区)', value: '现住址(区)', sortable: false },
            { text: '现住址(详细地址)', value: '现住址(详细地址)', sortable: false },
            { text: '子女', value: '子女', sortable: false },
            { text: '简介', value: '简介', sortable: false },
            { text: '生日', value: '生日', sortable: false },
            { text: '微信', value: '微信', sortable: false },
            { text: 'QQ', value: 'QQ', sortable: false },
            { text: '学号', value: '学号', sortable: false },
            { text: '科目（老师）', value: '科目（老师）', sortable: false },
            { text: '群组', value: '群组', sortable: false },

        ],
        uploadData:[],
        isUploading:false
    }),
    methods:{
        clickUploadFileBtn() {
            window.addEventListener('focus', () => {
            }, { once: true })
            this.$refs.fileUploader.click()
        },
        getHeader(sheet) {
            const XLSX = xlsx;
            const headers = [];
            const range = XLSX.utils.decode_range(sheet["!ref"]); // worksheet['!ref'] Is the valid range of the worksheet
            let C;
            /* Get cell value start in the first row */
            const R = range.s.r; //Line / / column C
            let i = 0;
            for (C = range.s.c; C <= range.e.c; ++C) {
                var cell =
                sheet[
                    XLSX.utils.encode_cell({ c: C, r: R })
                ]; /* Get the cell value based on the address  find the cell in the first row */
                var hdr = "UNKNOWN" + C; // replace with your desired default
                // XLSX.utils.format_cell Generate cell text value
                if (cell && cell.t) hdr = XLSX.utils.format_cell(cell);
                if(hdr.indexOf('UNKNOWN') > -1){
                if(!i) {
                    hdr = '__EMPTY';
                }else {
                    hdr = '__EMPTY_' + i;
                }
                i++;
                }
                headers.push(hdr);
            }
            return headers;
        },
        onFileFileChanged(e) {
            const files = e.target.files;
            console.log(files);
            if (!files.length) {
                return ;
            } else if (!/\.(xls|xlsx)$/.test(files[0].name.toLowerCase())) {
                return alert("The upload format is incorrect. Please upload xls or xlsx format");
            }
            const fileReader = new FileReader();
            fileReader.onload = ev => {
                try {
                    const data = ev.target.result;
                    const XLSX = xlsx;
                    const workbook = XLSX.read(data, {
                        type: "binary"
                    });
                    const wsname = workbook.SheetNames[0]; // Take the first sheet，wb.SheetNames[0] :Take the name of the first sheet in the sheets
                    const ws = XLSX.utils.sheet_to_json(workbook.Sheets[wsname]); // Generate JSON table content，wb.Sheets[Sheet名]    Get the data of the first sheet
                    const excellist = [];  // Clear received data
                    // Edit data
                    for (var i = 0; i < ws.length; i++) {
                        excellist.push(ws[i]);
                    }
                    console.log("Read results", excellist); // At this point, you get an array containing objects that need to be processed
                    this.uploadData = excellist
                    const a = workbook.Sheets[workbook.SheetNames[0]];
                    const headers = this.getHeader(a);
                    console.log('headers', headers);
                } catch (e) {
                    return alert("Read failure!");;
                }
            };
            fileReader.readAsBinaryString(files[0]);
            var input = document.getElementById("excelUpload");
            input.value = "";
        },
        async uploadExcel(){
            console.log(this.uploadData)
            let serverData = []
            this.uploadData.map(upData=>{
                let newData = {}
                newData.name = upData.姓名;
                newData.phoneNumber = upData.电话号码
                newData.imei = upData.imei
                newData.roleId = upData.角色代码
                newData.schoolId = upData.学校代码
                newData.gradeId = upData.年级代码
                newData.lessonId = upData.班级代码
                newData.gender = upData.性别
                newData.nation = upData.国籍
                newData.cardNum = upData.身份证号码
                newData.familyAddress = {
                    province:upData['家庭地址(省)'],
                    city:upData['家庭地址(市)'],
                    region:upData['家庭地址(区)'],
                    detail:upData['家庭地址(详细地址)']
                }
                newData.residenceAddress = {
                    province:upData['现住址(省)'],
                    city:upData['现住址(市)'],
                    region:upData['现住址(区)'],
                    detail:upData['现住址(详细地址)']
                }
                newData.introduce = upData.简介
                newData.birthday = this.TimeView(this.ConvertBirth(upData.生日))
                newData.wechat = upData.微信
                newData.qq = upData.QQ
                newData.studentId = upData.学号
                newData.subjectName = upData['科目（老师）']
                let groupArr = upData.群组
                newData.groupArr = groupArr
                serverData.push(newData)
            })
            console.log('--------',serverData)
            this.isUploading = true
            await uploadExcelApi({serverData:serverData}).then(res=>{
                console.log(res.data)
                this.isUploading = false
            }).catch(err=>{
                console.log(err.response)
                this.isUploading = false
            })
        },
        cancelUpload(){
            this.uploadData = []
        },
        ConvertBirth(excelDate){
            return new Date((excelDate - (25567+2))*86400*1000);
        }
    }
}
</script>

<style>

</style>