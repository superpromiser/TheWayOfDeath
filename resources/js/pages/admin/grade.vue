<template>
    <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="gradeData"
          :loading="isLoadingGradeData"
          loading-text="正在加载..."
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar
                flat
            >
              <v-toolbar-title><strong>年级</strong></v-toolbar-title>
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
                  color="#7879ff"
                  dark
                  class="mb-2"
                  v-bind="attrs"
                  v-on="on"
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
                        <v-col cols="12" sm="6" md="4" >
                          <v-select
                            :items="schoolInfo"
                            item-text="schoolName"
                            :menu-props="{ top: false, offsetY: true }"
                            item-value="id"
                            v-model="editedItem.schoolId"
                            :disabled="schoolInfo.length === 0" 
                            @change="selectSchool(editedItem.schoolId)"
                            label="--学校--"
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" md="4" >
                          <v-text-field
                          v-model="editedItem.gradeName"
                          label="年级名称"
                          ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row class=" align-center">
                        <v-col cols="12" md="4" sm="6" class="d-flex justify-center">
                          <img v-if="editedItem.imgUrl == ''" :src="`${baseUrl}/asset/img/icon/schoolGrayImage2.png`" alt="SchoolIcon" style="width:127px; height: 127px;">
                          <img v-else-if="editedItem.imgUrl !== ''" :src="editedItem.imgUrl" alt="" style="width:127px; height: 127px;">
                        </v-col>
                        <v-col cols="12" md="8" sm="6">
                          <UploadImage @upImgUrl="upImgUrl" @clearedImg="clearedImg" uploadLabel="上传年级图片" />
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
                      :loading="isCreatingGrade"
                      @click="save"
                    >
                      保存
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog persistent v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="headline">你确定要删除这个年级吗？</v-card-title>
                  <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="closeDelete">取消</v-btn>
                  <v-btn color="blue darken-1" text @click="deleteItemConfirm">确定</v-btn>
                  <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:[`item.imgUrl`]="{ item }">
            <img :src="`${baseUrl}${item.imgUrl}`" alt="Logo" class="school-table-img">
          </template>
          <template v-slot:[`item.actions`]="{ item }">
              <v-icon
                  small
                  class="mr-2"
                  @click="editItem(item)"
              >
                  mdi-pencil
              </v-icon>
              <v-icon
                  small
                  @click="deleteItem(item)"
              >
                  mdi-delete
              </v-icon>
          </template>
          <template v-slot:no-data>
            <p>暂无</p>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {getGrade, createGrade, updateGrade, deleteGrade, getSchoolInfo} from '~/api/grade';
import UploadImage from '~/components/UploadImage';
export default {
    components:{
      UploadImage,
      
    },
    data: () => ({
      dialog: false,
      dialogDelete: false,
      headers: [
        { text: '序号', value: 'id', align: 'start'},
        { text: '图片', value: 'imgUrl', sortable: false },
        { text: '学校', value: 'schoolName', sortable: false },
        { text: '年级', value: 'gradeName' },
        { text: '操作', value: 'actions', sortable: false },
      ],
      isLoadingGradeData:false,
      isCreatingGrade:false,
      gradeData: [],
      editedIndex: -1,
      editedItem: {
        id: 0,
        imgUrl: '',
        schoolId: '',
        schoolName:'',
        gradeName: '',

      },
      defaultItem: {
        id: 0,
        imgUrl: '',
        schoolId: '',
        schoolName:'',
        gradeName: '',
      },
      baseUrl:window.Laravel.base_url,
      schoolInfo: [],
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? '新增年级' : '编辑年级'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      async initialize () {
        getSchoolInfo().then(res=>{
          this.schoolInfo = res.data
          //console.log(this.schoolInfo)
        }).catch(err=>{
          //console.log(err)
        });
        this.isLoadingGradeData = true;
        await getGrade().then(res=>{
          //console.log(res.data)
          this.gradeData = res.data;
        }).catch(err=>{
          //console.log(err);
        })
        this.isLoadingGradeData = false;
      },

      editItem (item) {
        this.editedIndex = this.gradeData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.gradeData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      async deleteItemConfirm () {
        //console.log(this.editedIndex)
        await deleteGrade({id:this.editedIndex}).then(res=>{
          //console.log(res)
          this.gradeData.splice(this.editedIndex, 1)
        }).catch(err=>{
          //console.log(err)
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
        this.isCreatingGrade = true;
        //console.log(this.editedItem)
        if (this.editedIndex > -1) {
          await updateGrade(this.editedItem).then(res=>{
            this.editedItem.schoolName = res.data.schoolName
            Object.assign(this.gradeData[this.editedIndex], this.editedItem)
          }).catch(err=>{
            //console.log(err.response)
            this.isCreatingGrade = false
          })
        } else {
          await createGrade(this.editedItem).then(res=>{
            this.editedItem = res.data
            this.gradeData.push(this.editedItem)
          }).catch(err=>{
            //console.log(err.response)
            this.isCreatingGrade = false
          })
        }
        this.isCreatingGrade = false
        this.close()
      },
      upImgUrl(value) {
        this.editedItem.imgUrl = value;
        //console.log(this.editedItem.imgUrl);
      },
      clearedImg(){
        this.editedItem.imgUrl = ''
        //console.log(this.editedItem.imgUrl);
      },
      selectSchool(id){
        //console.log(id)
        //console.log("this.editedItem",this.editedItem)
      }
    },
  }
</script>

<style>

</style>