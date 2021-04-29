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
                <h2>学期</h2>
            </v-col>
            <v-col cols="12" md="4" class="d-flex align-center justify-end">
                <v-btn tile dark color="#7879ff" :loading="isAddingSession" @click="openAddSessionDialog" >
                    加学期
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
    <v-row class="pa-0 mt-5">
        <v-col cols="12" class="d-flex align-center ">
            <v-row class="ma-0">
                <v-col cols="12" sm="9" md="6" class="mx-auto">
                    <v-row v-if="isLoadingSessionData" class="ma-0 align-center justify-center" >
                        <v-progress-circular
                            indeterminate
                            color="primary"
                        ></v-progress-circular>
                    </v-row>
                    <v-row v-else-if="sessionDataArr.length == 0" class="ma-0">
                        <p>没有学期数据。</p>
                    </v-row>
                    <v-row v-else class="ma-0 justify-space-between align-center border-bottom-1" v-for="(item, i) in sessionDataArr" :key="i">
                        <p class="mb-0"> {{item.sessionName}}</p>
                        <div class="d-flex align-center">
                            <v-icon
                                small
                                color="success"
                                class="mr-2"
                                @click="editSession(item, i)"
                            >
                                mdi-pencil
                            </v-icon>
                            <v-icon
                                small
                                color="error"
                                @click="deleteSession(item, i)"
                            >
                                mdi-delete
                            </v-icon>
                        </div>
                    </v-row>
                </v-col>
            </v-row>
            <v-dialog v-model="addSessionDialog" transition="dialog-bottom-transition" width="100%" max-width="500">   
                <v-card>
                    <v-card-title>
                      <span class="headline">加学期</span>
                    </v-card-title>
                    <v-card-text class="pa-5">
                        <v-text-field
                            v-model="sessionName"
                            label="请输入学期名称"
                            hide-details
                        ></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="closeAddSessionDialog"
                        >
                        {{lang.cancel}}
                        </v-btn>
                        <v-btn
                        color="blue darken-1"
                        text
                        :loading="isAddingSession"
                        @click="onSubmitSession"
                        >
                        {{lang.save}}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="deleteSessionDialog" transition="dialog-bottom-transition" width="100%" max-width="500px">
                <v-card>
                    <v-card-title class="headline">{{lang.confirmSentence}}</v-card-title>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDeleteSessionDialog">{{lang.cancel}}</v-btn>
                    <v-btn color="blue darken-1" text @click="deleteSessionConfirm" :loading="isDeleting">{{lang.ok}}</v-btn>
                    <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-col>
        <v-col cols="12" class="mt-5">
            <v-row class="ma-0 align-center">
                <v-col cols="12" md="6">
                    <p class="mb-0">请选择需要维护的课时</p>
                </v-col>
                <v-col cols="12" md="6">
                    <v-select
                        :items="sessionDataArr"
                        item-text="sessionName"
                        item-value="id"
                        :menu-props="{ top: false, offsetY: true }"
                        v-model="selectedSession"
                        :disabled="sessionDataArr.length === 0"
                        :loading="isLoadingSchoolData"
                        hide-details
                        solo
                        @change="onChangeSession"
                        ></v-select>
                </v-col>
            </v-row>
        </v-col>
      <v-col cols="12">
        <v-data-table
            :headers="headers"
            :items="scheduleData"
            :loading="isLoadingSchoolData"
            loading-text="等一下..."
            sort-by="calories"
            class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title><strong>课时维护</strong></v-toolbar-title>
                <v-divider
                class="mx-4"
                inset
                vertical
                ></v-divider>
                <v-spacer></v-spacer>

                <v-dialog
                v-model="dialog"
                persistent
                max-width="500px"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-btn
                    color="#7879FF"
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
                            <v-col cols="12"  >
                                <v-text-field
                                    solo
                                    v-model="editedItem.subjectOrderName"
                                    label="机构名称"
                                    hide-details
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12"  >
                                <v-select
                                    solo
                                    :items="subjectTypeItem"
                                    :menu-props="{ top: false, offsetY: true }"
                                    item-text="label"
                                    v-model="editedItem.subjectOrderType"
                                    label="课时类型"
                                    hide-details
                                ></v-select>
                            </v-col>
                            <v-col cols="12" >
                                <v-menu
                                    ref="startTimeMenu"
                                    v-model="startTimeMenu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="time"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="290px"
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        solo
                                        v-model="editedItem.startTime"
                                        label="上课时间"
                                        prepend-icon="mdi-clock-time-four-outline"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        hide-details
                                    ></v-text-field>
                                    </template>
                                    <v-time-picker
                                        v-if="startTimeMenu"
                                        v-model="editedItem.startTime"
                                        full-width
                                        @click:minute="$refs.startTimeMenu.save(time)"
                                    ></v-time-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="12" >
                                <v-menu
                                    ref="endTimeMenu"
                                    v-model="endTimeMenu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="time"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="290px"
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        solo
                                        v-model="editedItem.endTime"
                                        label="下课时间"
                                        prepend-icon="mdi-clock-time-four-outline"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        hide-details
                                    ></v-text-field>
                                    </template>
                                    <v-time-picker
                                        v-if="endTimeMenu"
                                        v-model="editedItem.endTime"
                                        full-width
                                        @click:minute="$refs.endTimeMenu.save(time)"
                                    ></v-time-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="12" >
                                <v-menu
                                    ref="subjectDateMenu"
                                    v-model="subjectDateMenu"
                                    :close-on-content-click="false"
                                    :return-value.sync="editedItem.subjectStartDate"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="editedItem.subjectStartDate"
                                            label="生效时间"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                            solo
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="editedItem.subjectStartDate"
                                        no-title
                                        scrollable
                                        locale="zh-cn"
                                    >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        text
                                        color="primary"
                                        @click="subjectDateMenu = false"
                                    >
                                        {{lang.cancel}}
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="primary"
                                        @click="$refs.subjectDateMenu.save(editedItem.subjectStartDate)"
                                    >
                                        {{lang.ok}}
                                    </v-btn>
                                    </v-date-picker>
                                </v-menu>
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
                    color="#f19861"
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
                    color="#f19861"
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
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { 
    createSubject, 
    updateSubject, 
    getSubject, 
    deleteSubject, 
    createSession,
    updateSession,
    getSession,
    deleteSession, 
} from '~/api/managersubject'
import { mapGetters } from 'vuex';
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
        subjectDateMenu: false,
        isEditable : false,
        isAddingSession: false,
        addSessionDialog: false,
        deleteSessionDialog: false,
        sessionEditMode: false,
        sessionName:'',
        sessionDataArr: [],
        selectedSession: null,
        subjectTypeItem : [
            { 
                label : "自习", 
                value : "自习" 
            },
            { 
                label : "课程", 
                value : "课程" 
            },
            { 
                label : "其它", 
                value : "其它" 
            },
        ],
        subjectOrderItem: [
           {
            label: "第一节",
            value: "第一节"
          },
          {
            label: "第二节",
            value: "第二节"
          },
          {
            label: "第三节",
            value: "第三节"
          },
          {
            label: "第四节",
            value: "第四节"
          },
          {
            label: "第五节",
            value: "第五节"
          },
          {
            label: "第六节",
            value: "第六节"
          },
          {
            label: "第七节",
            value: "第七节"
          },
        ],
        headers: [
            { text: '课时名称', value: 'subjectOrderName', align: 'start'},
            { text: '课时类型', value: 'subjectOrderType', sortable: false },
            { text: '开始时间', value: 'startTime', sortable: false },
            { text: '结束时间', value: 'endTime', sortable: false },
            { text: '生效时间', value: 'subjectStartDate', sortable: false },
            { text: '操作', value: 'actions', sortable: false },
        ],
        scheduleData: [],
        schoolListRaw : [],
        editedIndex: -1,
        editedItem: {
            subjectOrderName: '',
            subjectOrderType: '',
            startTime: null,
            endTime: null,
            subjectStartDate: null,
            sessionId: null,
        },
        defaultItem: {
            subjectOrderName: '',
            subjectOrderType: '',
            startTime: null,
            endTime: null,
            subjectStartDate: null,
            sessionId: null,
        },
        
        baseUrl:window.Laravel.base_url,
        isCreating : false,
        isLoadingSchoolData : false,
        isLoadingSessionData : false,
        isDeleting : false,
        schoolIntroduceData : '',
        tempSession : null,
        tempSessionIndex : -1,
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? '新增课' : '编辑课'
        },
        ...mapGetters({
            user: 'auth/user',
        })
    },

    async created(){
        this.isLoadingSessionData = true;
        await getSession()
        .then((res) => {
            this.sessionDataArr = res.data;
            if(this.sessionDataArr.length > 0){
                this.selectedSession = this.sessionDataArr[0].id;
            }
        }).catch((err) => {
            console.log(err);
        });
        this.isLoadingSessionData = false;
        if(this.sessionDataArr.length > 0){
            this.isLoadingSchoolData = true;
            let payload = {
                sessionId: this.selectedSession
            }
            await getSubject(payload)
            .then((res) => {
                //console.log(res.data)
                this.scheduleData = res.data
            }).catch((err) => {
                
            });
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
            this.editedIndex = this.scheduleData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
      },

      deleteItem (item) {
            this.editedIndex = this.scheduleData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
      },

        async deleteItemConfirm () {
            this.isDeleting = true
            await deleteSubject({id:this.editedItem.id}).then(res=>{
                //console.log(res.data)
            }).catch(err=>{
                this.isDeleting = false
                //console.log(err.response)
            })
            this.isDeleting = false
            this.scheduleData.splice(this.editedIndex, 1)
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
            //update scheduleData
            this.isCreating = true
            if (this.editedIndex > -1) {
                //console.log(this.editedItem)
                await updateSubject(this.editedItem).then(res=>{
                    //console.log(res.data)
                    Object.assign(this.scheduleData[this.editedIndex], this.editedItem)
                }).catch(err=>{
                    this.isCreating = false
                    //console.log(err.response)
                })
            } 
            //save scheduleData
            else {
                this.editedItem.sessionId = this.selectedSession;
                await createSubject(this.editedItem).then(res=>{
                    //console.log(res.data)
                    this.scheduleData.push(res.data)

                }).catch(err=>{
                    this.isCreating = false
                    //console.log(err.response);
                })
            }
            this.isCreating = false
            this.close()
        },
        saveSubjectDate(){
            this.$refs.subjectDateMenu.save(val);
            // this.editedItem.subjectStartDate = val;
        },
        openAddSessionDialog(){
            this.addSessionDialog = true;
        },

        closeAddSessionDialog(){
            this.sessionName = '';
            this.addSessionDialog = false;
        },
        async onSubmitSession(){
            if(this.sessionName.trim() == ''){
                return this.$snackbar.showMessage({content: "学期名称字段为空白。", color: "error"})
            }

            if(this.sessionEditMode == false){

                this.isAddingSession = true;
                let payload = {
                    sessionName: this.sessionName
                }
                await createSession(payload)
                .then((res) => {
                    if(res.data.msg == 1){
                        let sessionObj = {
                            id: res.data.id,
                            userId: this.user.id,
                            schoolId: this.user.schoolId,
                            sessionName: this.sessionName
                        }
                        this.sessionDataArr.push(sessionObj)
                        if(this.sessionDataArr.length == 1){
                            this.selectedSession = this.sessionDataArr[0].id;
                        }
                    }
                    this.sessionName = '';
                    this.addSessionDialog = false;
                }).catch((err) => {
                    console.log(err)
                });
                this.isAddingSession = false;
            }
            else if(this.sessionEditMode = true){
                let payload = {
                    id: this.tempSession.id,
                    sessionName: this.sessionName
                }
                this.isAddingSession = true;
                await updateSession(payload)
                .then((res) => {
                    if(res.data.msg == 1){
                        this.sessionDataArr[this.tempSessionIndex].sessionName = this.sessionName;
                        this.tempSession = null;
                        this.tempSessionIndex = -1;
                        this.sessionName = '';
                        this.addSessionDialog = false;
                    }
                }).catch((err) => {
                    console.log(err)
                });
                this.isAddingSession = false;
            }
        },

        editSession(session, index){
            this.sessionEditMode = true;
            this.tempSession = session;
            this.tempSessionIndex = index;
            this.sessionName = this.tempSession.sessionName;
            this.addSessionDialog = true;
        },

        deleteSession(session, index){
            this.tempSession = session;
            this.tempSessionIndex = index;
            this.deleteSessionDialog = true;
        },

        closeDeleteSessionDialog(){
            this.tempSessionIndex = -1;
            this.tempSession = null;
            this.deleteSessionDialog = false;
        },

        async deleteSessionConfirm(){
            this.isDeleting = true;
            let payload = {
                id: this.tempSession.id,
            }
            await deleteSession(payload)
            .then((res) => {
                if(res.data.msg == 1){
                    this.sessionDataArr.splice(this.tempSessionIndex, 1);
                    this.tempSessionIndex = -1;
                    this.tempSession = null;
                }
            }).catch((err) => {
                
            });
            this.deleteSessionDialog = false;
            this.isDeleting = false;

        },

        async onChangeSession(val){
            this.selectedSession = val;

            this.isLoadingSchoolData = true;
            let payload = {
                sessionId: this.selectedSession
            }
            await getSubject(payload)
            .then((res) => {
                //console.log(res.data)
                this.scheduleData = res.data
            }).catch((err) => {
                
            });
            this.isLoadingSchoolData = false;
        }
    },
}
</script>
<style>

</style>