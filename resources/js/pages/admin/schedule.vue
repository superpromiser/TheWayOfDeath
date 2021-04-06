<template>
  <v-container>
    <v-row>
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
                            <v-col cols="12"  >
                                <v-text-field
                                    solo
                                    v-model="editedItem.subjectName"
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
                                    v-model="editedItem.subjectType"
                                    label="课时类型"
                                    hide-details
                                ></v-select>
                            </v-col>
                            <v-col cols="12"  >
                                <v-select
                                    solo
                                    :items="subjectOrderItem"
                                    :menu-props="{ top: false, offsetY: true }"
                                    item-text="label"
                                    v-model="editedItem.subjectOrder"
                                    label="课时类型"
                                    hide-details
                                ></v-select>
                            </v-col>
                            <!-- <v-col cols="12" >
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
                                    :return-value.sync="editedItem.subjectDate"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="editedItem.subjectDate"
                                            label="生效时间"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                            solo
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="editedItem.subjectDate"
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
                                        @click="$refs.subjectDateMenu.save(editedItem.subjectDate)"
                                    >
                                        {{lang.ok}}
                                    </v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col> -->
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
                <router-link :to="{ name : 'admin.scheduleSetting'}">
                    <v-btn
                        color="light-blue accent-4"
                        dark
                        class="mb-2 ml-2"
                        tile
                        >
                        课程安排
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
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { createSchool, updateSchool, getSchool, deleteSchool } from '~/api/school'
import { createSubject, updateSubject, getSubject, deleteSubject } from '~/api/managersubject'
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
        subjectTypeItem : [
            { 
                label : "outsidePlay", 
                value : "outsidePlay" 
            },
            { 
                label : "insidePlay", 
                value : "insidePlay" 
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
            { text: '课时名称', value: 'subjectName', align: 'start'},
            { text: '课时类型', value: 'subjectType', sortable: false },
            { text: '上课时间', value: 'subjectOrder', sortable: false },
            
            // { text: '上课时间', value: 'startTime', sortable: false },
            // { text: '下课时间', value: 'endTime', sortable: false },
            // { text: '生效时间', value: 'subjectDate', sortable: false },

            { text: '操作', value: 'actions', sortable: false },
        ],
        scheduleData: [
            // {
            //     subjectName: 'math',
            //     subjectType: 'outsidePlay',
            //     startTime: '00:00',
            //     endTime: '00:01',
            // },
        ],
        schoolListRaw : [],
        editedIndex: -1,
        editedItem: {
            subjectName: '',
            subjectType: '',
            subjectOrder:'',
            // startTime: null,
            // endTime: null,
            // subjectDate: null,
        },
        defaultItem: {
            subjectName: '',
            subjectType: '',
            subjectOrder:'',
            // startTime: null,
            // endTime: null,
            // subjectDate: null,
        },
        
        baseUrl:window.Laravel.base_url,
        isCreating : false,
        isLoadingSchoolData : false,
        isDeleting : false,
        schoolIntroduceData : '',
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? '新增课' : '编辑课'
        },
    },

    async created(){
        this.isLoadingSchoolData = true;
        await getSubject()
        .then((res) => {
            //console.log(res.data)
            this.scheduleData = res.data
        }).catch((err) => {
            
        });
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
            // this.editedItem.subjectDate = val;
        }
    },
}
</script>
<style>

</style>