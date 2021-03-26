<template>
    <v-container>
        <v-row>
            <v-col v-if="isGettingBaseData" cols="12" class="d-flex justify-center my-7">
                <v-progress-circular
                    
                    color="primary"
                    indeterminate
                    ></v-progress-circular>
            </v-col>
            <v-tabs
                background-color="transparent"
                color="primary"
                grow
                class="my-7"
                v-else
            >   
                <v-tab v-for="(gradeData) in mySchoolData.grades" :key="gradeData.id" @click="triggerGrade(gradeData)">
                    <v-icon class="mr-2">mdi-bookmark</v-icon>{{gradeData.gradeName}}
                </v-tab>
            </v-tabs>
        </v-row>
        <transition name="fade" mode="out-in">
            <v-data-table
            :headers="headers"
            :items="scheduleSettingData"
            :loading="isLoadingSchoolData"
            loading-text="等一下..."
            sort-by="calories"
            class="elevation-1"
            >
            <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-toolbar-title><strong>{{currentSelectedGrade ? currentSelectedGrade.gradeName : ''}} 课程安排</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>

                    <v-dialog
                    v-model="dialog"
                    max-width="500px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-btn
                        color="primary"
                        dark
                        tile
                        class="mb-2"
                        v-bind="attrs"
                        v-on="on"
                        :disabled="!isEditable"
                        >
                        添加
                        </v-btn>
                        </template>
                        <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="subjectNameItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.subject"
                                        label="课时类型"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="teacherNameItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.teacher"
                                        label="课时类型"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="classItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.lesson"
                                        label="课时类型"
                                        hide-details
                                    ></v-select>
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
                    <v-dialog v-model="dialogDelete" max-width="500px">
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

                    <v-btn
                        color="green accent-4"
                        dark
                        class="mb-2 ml-2"
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
                        color="orange accent-4"
                        dark
                        class="mb-2 ml-2"
                        tile
                        v-if="isEditable == true"
                        @click="isEditable = !isEditable"
                        >
                        <v-icon left>
                            mdi-alert-circle-outline
                        </v-icon>
                        无法修改
                    </v-btn>
                    <router-link :to="{ name : 'admin.schedule'}">
                        <v-btn
                            color="light-blue accent-4"
                            dark
                            class="mb-2 ml-2"
                            tile
                            >
                            课时维护
                            <v-icon right> 
                                mdi-arrow-right-thick 
                            </v-icon>
                        </v-btn>
                    </router-link>
                </v-toolbar>
            </template>
            
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
                <p>没有学习资料</p>
            </template>
            </v-data-table>
        </transition>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import { getBaseData,getSchedule,createSchedule,updateSchedule,deleteSchedule} from '~/api/managerSchedule'
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
            { text: '任课教师', value: 'teacherName', sortable: false },
            { text: '任课班级', value: 'lessonName', sortable: false },
            { text: '操作', value: 'actions', sortable: false },
        ],
        scheduleSettingData: [
            
        ],
        editedIndex: -1,
        editedItem: {
            subject:{
                label:'',
                value:'',
            },
            teacher:{
                label:'',
                value:'',
            },
            lesson:{
                label:'',
                value:'',
            },
        },
        defaultItem: {
            subject:{
                label:'',
                value:'',
            },
            teacher:{
                label:'',
                value:'',
            },
            lesson:{
                label:'',
                value:'',
            },
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
            return this.editedIndex === -1 ? '新增课程安排' : '编辑课程安排'
        },
    },
    async created(){
        this.isLoadingSchoolData = true;
        this.isGettingBaseData = true;
        await getBaseData()
        .then((res) => {
            this.initialized(res.data.data)
        }).catch((err) => {
            //console.log(err.response)
        });
        this.isGettingBaseData = false
        this.schoolData.map(x=>{
            if(this.user.schoolId == x.id){
                this.mySchoolData = x;
            }
        })
        this.currentSelectedGrade = this.mySchoolData.grades[0];
        //console.log(this.currentSelectedGrade)
        await getSchedule({gradeId:this.currentSelectedGrade.id}).then(res=>{
            this.scheduleSettingData = res.data
            //console.log(this.scheduleSettingData)
        }).catch(err=>{
            //console.log(err.response);
        })
        this.triggerLesson()
        this.isLoadingSchoolData = false;
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
        initialized(data){
            data.subjectArr.map(sub=>{
                let element = {}
                element.label = sub.subjectName
                element.value = sub
                this.subjectNameItem.push(element)
            })
            data.teacherArr.map(user=>{
                let element = {}
                element.label = user.name;
                element.value = {id:user.id,teacherName:user.name};
                this.teacherNameItem.push(element);
            })
            // this.scheduleSettingData = data.scheduleArr;
        },
      editItem (item) {
          //console.log('------',item)
            this.editedIndex = this.scheduleSettingData.indexOf(item)

            this.editedItem.subject.label = item.subjectName
            this.editedItem.subject.value = item.subjectId
            this.editedItem.teacher.label = item.teacherName
            this.editedItem.teacher.value = item.teacherId
            this.editedItem.lesson.label = item.lessonName
            this.editedItem.lesson.value = item.lessonId
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
            this.$set(this.editedItem,'gradeId',this.currentSelectedGrade.id)
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
        triggerGrade(gradeData){
            this.currentSelectedGrade = gradeData;
            this.triggerLesson()
        },
        async triggerLesson(){
            this.isLoadingSchoolData = true;
            await getSchedule({gradeId:this.currentSelectedGrade.id}).then(res=>{
                this.scheduleSettingData = res.data
            }).catch(err=>{
                //console.log(err.response);
            })
            this.isLoadingSchoolData = false;
            this.classItem = []
            this.currentSelectedGrade.lessons.map(lesson=>{
                let element = {
                    label:'',
                    value:''
                }
                element.label = lesson.lessonName
                element.value = {id:lesson.id,lessonName:lesson.lessonName}
                this.classItem.push(element)
            })
        },
        triggerSubject(data){
            this.subjectNameItem = []
            data.map(sub=>{
                let element = {
                    label:'',
                    value:''
                }
                element.label = sub.subjectName
                element.value = sub.id
                this.subjectNameItem.push(element)
            })
        }
    },
}
</script>

