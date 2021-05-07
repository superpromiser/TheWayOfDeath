<template>
  <v-container class="pa-0">
    <v-dialog v-model="dialogDelete" max-width="500px">
        <v-card>
        <v-card-title class="headline">确定要删除这个请假单吗？</v-card-title>
        <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="closeDelete">{{lang.cancel}}</v-btn>
        <v-btn color="blue darken-1" text @click="deleteItemConfirm" :loading="isDeleteSchool">{{lang.ok}}</v-btn>
        <v-spacer></v-spacer>
        </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog
        v-model="reasonDialog"
        max-width="500px"
    >
        <v-card>
        <v-card-title class="title">
            请假原因
        </v-card-title>
        <v-card-text
        >
            {{ vacationReasonData }}
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
            text
            color="primary"
            @click="reasonDialog = false"
            >
                {{lang.ok}}
            </v-btn>
        </v-card-actions>
        </v-card>
    </v-dialog>

    <v-row class="px-10 mt-5">
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="vacationData"
          :loading="isLoadingSchoolData"
          loading-text="正在下载..."
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar
                flat
            >
                <v-toolbar-title><strong>请假审批</strong></v-toolbar-title>
                <v-divider
                class="mx-4"
                inset
                vertical
                ></v-divider>
                <v-spacer></v-spacer>

                
            </v-toolbar>
          </template>
          <template v-slot:[`item.reasonFlag`]="{ item }">
                <span v-if="item.reasonFlag == true"> 事假 </span>
                <span v-else> 病假 </span>
          </template>
          <template v-slot:[`item.reason`]="{ item }">
            <v-btn
              text
              small
              @click="showReasonDialog(item.reason)"
              >
              查看休假原因
            </v-btn>
          </template>
          <template v-slot:[`item.startTime`]="{ item }">
              {{TimeView(item.startTime)}}
          </template>
          <template v-slot:[`item.endTime`]="{ item }">
              {{TimeView(item.endTime)}}
          </template>
          <template v-slot:[`item.status`]="{ item }">
            <v-chip v-if="item.status == 'deny'" class="ma-2" color="pink" label text-color="white" >
              <v-icon left> mdi-cancel </v-icon> 否定
            </v-chip>
            <v-chip v-else-if="item.status == 'allow'" class="ma-2" color="success"  label text-color="white" >
              <v-icon left> mdi-hand   </v-icon> 允许
            </v-chip>
            <v-chip v-else-if="item.status == 'pending'" class="ma-2" color="orange"  label text-color="white" >
              <v-icon left> mdi-clock-outline   </v-icon> 待办的
            </v-chip>
          </template>
          <template v-slot:[`item.actions`]="{ item }">
                <v-tooltip bottom v-if="item.status == 'pending'">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="replyItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-reply
                        </v-icon>
                    </template>
                    <span>回复</span>
                </v-tooltip>
                <v-tooltip bottom v-if="item.status == 'allow'">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="denyItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-cancel
                        </v-icon>
                    </template>
                    <span>否定</span>
                </v-tooltip>
                <v-tooltip bottom v-if="item.status == 'deny'">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="allowItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-hand
                        </v-icon>
                    </template>
                    <span>允许</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            @click="deleteItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                    <span>删除假期</span>
                </v-tooltip>
          </template>
          <template v-slot:no-data>
            <p>没有请假信息</p>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {getVacationData,deleteVacationData,updateVacationData} from '~/api/vacation';
import lang from '~/helper/lang.json'
export default {
    components:{
    },

    data: () => ({
        lang,
        dialog: false,
        reasonDialog: false,
        dialogDelete: false,
        headers: [
            { text: '请假人', value: 'studentName', sortable: false, align: 'start'},
            { text: '开始时间', value: 'startTime', sortable: false },
            { text: '结束时间', value: 'endTime', sortable: false },
            { text: '休假表格', value: 'reasonFlag', sortable: false },
            { text: '请假原因', value: 'reason', sortable: false, align: 'center' },
            { text: '审批状态', value: 'status', sortable: false, align: 'center' },
            { text: '操作', value: 'actions', sortable: false },
        ],
        vacationData: [],
        schoolListRaw : [],
        editedIndex: -1,
        editedItem: {
            studentName: '',
            startTime: null,
            endTime: null,
            reasonFlag: false,
            reason: '',
        },
        defaultItem: {
            studentName: '',
            startTime: null,
            endTime: null,
            reasonFlag: false,
            reason: '',
        },
        
        baseUrl:window.Laravel.base_url,
        isCreatingSchool : false,
        isLoadingSchoolData : false,
        isDeleteSchool : false,
        vacationReasonData : '',
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? '新增课' : '编辑课'
        },
    },

    async created(){
        this.isLoadingSchoolData = true;
        await getVacationData().then(res=>{
            this.vacationData = res.data
        }).catch(err=>{
            console.log(err.response)
        })
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
            this.editedIndex = this.vacationData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
      },

      deleteItem (item) {
            console.log('---',item)
            this.editedIndex = this.vacationData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
      },

        async deleteItemConfirm () {
            console.log(this.editedItem)
            this.isDeleteSchool = true
            await deleteVacationData({postId:this.editedItem.postId}).then(res=>{
                this.vacationData.splice(this.editedIndex, 1)
                this.isDeleteSchool = false
            }).catch(err=>{
                console.log(err.response)
            })
            // let payload = {
            //     id : this.editedItem.id
            // }
            // this.isDeleteSchool = true;
            // await deleteSchool(payload)
            // .then((res) => {
            //     if(res.data.msg == 1){
                    
            //     }
            //     this.isDeleteSchool = false;
            // }).catch((err) => {
            //     console.log(err)
            //     this.isDeleteSchool = false;
            // });
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
            //update vacationData
            if (this.editedIndex > -1) {
                Object.assign(this.vacationData[this.editedIndex], this.editedItem)
            } 
            //save vacationData
            else {

                this.vacationData.push(this.editedItem)
            }
            this.close()
        },

        showReasonDialog (reason){
            this.vacationReasonData = reason;
            this.reasonDialog = true;
        },

        replyItem(item){
            console.log(item);
            this.$router.push({ name : 'posts.vacationTeacherReply', params:{vId:item.id} })
        },
        async denyItem(item){
            console.log('deny',item)
            await updateVacationData({vId:item.id,status:'deny'}).then(res=>{
                console.log(res.data)
                item.status = 'deny'
            }).catch(err=>{
                console.log(err.response)
            })
        },
        async allowItem(item){
            console.log('allow',item)
            await updateVacationData({vId:item.id,status:'allow'}).then(res=>{
                console.log(res.data)
                item.status = 'allow'
            }).catch(err=>{
                console.log(err.response)
            })
        }
    },
}
</script>
<style>

</style>