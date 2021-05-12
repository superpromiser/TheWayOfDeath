<template>
    <v-container class="pa-0">
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class="left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>课程维护</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        color="#7879ff"
                        dark
                        tile
                        @click="dialog = ! dialog"
                        :disabled="!isEditable"
                    >
                        添加
                    </v-btn>
                    <v-btn
                        color="#f19861"
                        dark
                        
                        tile
                        v-if="isEditable == false"
                        @click="isEditable = !isEditable"
                        >
                        <v-icon left>
                            mdi-check
                        </v-icon>
                        修改
                    </v-btn>
                    <v-btn
                        color="#f19861"
                        dark
                        tile
                        v-if="isEditable == true"
                        @click="isEditable = !isEditable"
                        class="mx-2"
                        >
                        <v-icon left>
                            mdi-alert-circle-outline
                        </v-icon>
                        保存
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-dialog
            v-model="dialog"
            persistent
            max-width="500px"
            >
                <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                    <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="editedItem.subjectName"
                                label="请输入课程名称"
                                hide-details
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                    color="blue darken-1"
                    text
                    @click="close"
                    >
                    取消
                    </v-btn>
                    <v-btn
                    color="blue darken-1"
                    text
                    :loading="isCreating"
                    @click="save"
                    >
                    保存
                    </v-btn>
                </v-card-actions>
                </v-card>
        </v-dialog>
        <v-dialog persistent v-model="dialogDelete" max-width="500px">
            <v-card>
            <v-card-title class="headline">{{lang.confirmSentence}}</v-card-title>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeDelete">{{lang.cancel}}</v-btn>
            <v-btn color="blue darken-1" text @click="deleteItemConfirm" :loading="isDeleting">{{lang.ok}}</v-btn>
            <v-spacer></v-spacer>
            </v-card-actions>
            </v-card>
        </v-dialog>
        <v-row class="my-5 align-center px-10">
            <v-col cols="12" md="6">
                <p class="mb-0">请选择需要维护的课程</p>
            </v-col>
            <v-col cols="12" md="6">
                <v-select
                    :items="mySchoolData.grades"
                    item-text="gradeName"
                    item-value="id"
                    :menu-props="{ top: false, offsetY: true }"
                    v-model="currentSelectedGrade"
                    :disabled="mySchoolData.grades.length === 0"
                    :loading="isLoadingSchoolData"
                    hide-details
                    solo
                    @change="onChangeGrade"
                ></v-select>
            </v-col>
        </v-row>
        <div class="px-10">
            <v-data-table
                :headers="headers"
                :items="scheduleSettingData"
                :loading="isLoadingSchoolData"
                loading-text="正在加载..."
                sort-by="calories"
                class="elevation-1"
            >
            
            <template v-slot:[`item.actions`]="{ item }">
                <v-icon
                    small
                    color="success"
                    class="mr-2"
                    :disabled="!isEditable"
                    @click="editItem(item)"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    color="error"
                    :disabled="!isEditable"
                    @click="deleteItem(item)"
                >
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <p>暂无</p>
            </template>
            </v-data-table>
        </div>
        
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import { getSchedule,createSchedule,updateSchedule,deleteSchedule} from '~/api/managerSchedule'
import lang from '~/helper/lang.json'
export default {
    components:{
    },
    
    data: () => ({
        lang,
        dialog: false,
        dialogDelete: false,
        time: null,
        startTimeMenu: false,
        endTimeMenu: false,
        isEditable : false,
        isGettingBaseData: false,
        currentSelectedGrade : null,
        teacherNameItem : [
            
        ],
        subjectNameItem : [
        
        ],
        classItem : [
    
        ],
        headers: [
            { text: '课程名称', value: 'subjectName', align: 'start'},
            { text: '操作', value: 'actions', sortable: false },
        ],
        scheduleSettingData: [
            
        ],
        editedIndex: -1,
        editedItem: {
            gradeId: null,
            subjectName: ''
        },
        defaultItem: {
            gradeId: null,
            subjectName: ''
        },
        
        baseUrl:window.Laravel.base_url,
        isCreating : false,
        isLoadingSchoolData : false,
        isDeleting : false,
        schoolIntroduceData : '',
        mySchoolData: {}
    }),

    computed:{
        ...mapGetters({
            schoolData : 'schooltree/schoolData',
            user : 'auth/user'
        }),
        formTitle () {
            return this.editedIndex === -1 ? '新科目' : '主题名称更改'
        },
    },
    async created(){
        
        this.schoolData.map(x=>{
            if(this.user.schoolId == x.id){
                this.mySchoolData = x;
            }
        })
        if(this.mySchoolData.grades.length > 0){
            this.isLoadingSchoolData = true;
            this.currentSelectedGrade = this.mySchoolData.grades[0].id;
            await getSchedule({gradeId:this.currentSelectedGrade}).then(res=>{
                this.scheduleSettingData = res.data
            }).catch(err=>{
    
            })
            this.isLoadingSchoolData = false;
        }
    },
    
    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },

    methods: {
      editItem (item) {
          //console.log('------',item)
            this.editedIndex = this.scheduleSettingData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            //console.log('+++++',this.editedItem)
            this.dialog = true
      },

      deleteItem (item) {
            this.editedIndex = this.scheduleSettingData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
      },

        async deleteItemConfirm () {
            this.isDeleting = true
            await deleteSchedule({id:this.editedIndex}).then(res=>{
                this.scheduleSettingData.splice(this.editedIndex, 1)
                //console.log(res)
                this.isDeleting = false
            }).catch(err=>{
                this.isDeleting = false
                //console.log(err.response)
            })
            this.closeDelete()
        },

        close () {
            this.dialog = false
            this.$nextTick(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.editedIndex = -1
            })
        },

        closeDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.editedIndex = -1
            })
        },

        async save () {
            //update scheduleSettingData
            this.isCreating = true
            //console.log(this.editedItem)
            this.$set(this.editedItem,'gradeId',this.currentSelectedGrade)
            //console.log(this.editedIndex)
            if (this.editedIndex > -1) {
                await updateSchedule(this.editedItem).then(res=>{

                    Object.assign(this.scheduleSettingData[this.editedIndex], this.editedItem)
                }).catch(err=>{
                    this.isCreating = false;
                    //console.log(err.response)
                })
            } 
            //save scheduleSettingData
            else {
                this.editedItem.gradeId = this.currentSelectedGrade;
                await createSchedule(this.editedItem).then(res=>{
                    // let index = this.subjectNameItem.findIndex(sbj=> sbj.value === this.editedItem.subject)
                    // if(index > -1){
                    //     this.subjectNameItem.splice(index,1)
                    // }
                    this.scheduleSettingData.push(res.data)
                }).catch(err=>{
                    this.isCreating = false;
                    //console.log(err.response);
                })
            }
            this.isCreating = false;
            this.close()
        },

        async onChangeGrade(val){
            this.currentSelectedGrade = val;

            this.isLoadingSchoolData = true;
            await getSchedule({gradeId:this.currentSelectedGrade}).then(res=>{
                this.scheduleSettingData = res.data
            }).catch(err=>{
    
            })
            this.isLoadingSchoolData = false;
        }
    },
}
</script>

