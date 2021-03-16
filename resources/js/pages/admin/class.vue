<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="classData"
          :loading="isLoadingClassData"
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar flat>
              <v-toolbar-title>My CRUD</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-dialog
                  v-model="dialog"
                  max-width="500px"
                  >
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                    >
                    New Item
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
                              item-value="id"
                              v-model="editedItem.schoolId"
                              :disabled="schoolInfo.length === 0" 
                              @change="selectSchool(editedItem.schoolId)"
                              label="--学校--"
                            ></v-select>
                          </v-col>
                          <v-col cols="12" sm="6" md="4" >
                            <v-select
                              :items="gradeInfo"
                              item-text="gradeName"
                              item-value="id"
                              v-model="editedItem.gradeId"
                              :disabled="gradeInfo.length === 0" 
                              @change="selectGrade(editedItem.gradeId)"
                              label="--年级--"
                            ></v-select>
                          </v-col>
                          <v-col cols="12" sm="6" md="4" >
                            <v-text-field
                            v-model="editedItem.lessonName"
                            label="机构名称"
                            ></v-text-field>
                          </v-col>
                        </v-row>
                        <v-row class=" align-center">
                          <v-col cols="12" md="4" sm="6" class="d-flex justify-center">
                            <img v-if="editedItem.imgUrl == ''" :src="`${baseUrl}/asset/img/icon/schoolGrayImage2.png`" alt="SchoolIcon" style="width:127px; height: 127px;">
                            <img v-else-if="editedItem.imgUrl !== ''" :src="editedItem.imgUrl" alt="" style="width:127px; height: 127px;">
                          </v-col>
                          <v-col cols="12" md="8" sm="6">
                            <UploadImage @upImgUrl="upImgUrl" @clearedImg="clearedImg" uploadLabel="上传学校图片" />
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
                          Cancel
                      </v-btn>
                      <v-btn
                          color="blue darken-1"
                          text
                          @click="save"
                          :loading="isCreatingClassData"
                      >
                          Save
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="500px">
                  <v-card>
                    <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
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
            <p>没有学习资料</p>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import {getClass, createClass, updateClass, deleteClass, getGradeInfo} from '~/api/class';
  import {getSchoolInfo} from '~/api/grade';
  import UploadImage from '~/components/UploadImage';
  export default {
    components:{
      UploadImage,
      
    },
    data: () => ({
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: '序号',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: '图标', value: 'imgUrl' },
        { text: '学校', value: 'schoolName' },
        { text: '年级', value: 'gradeName' },
        { text: 'className', value: 'lessonName' },
        { text: '操作', value: 'actions', sortable: false },
      ],
      classData: [],
      schoolInfo:[],
      gradeInfo:[],
      isLoadingClassData:false,
      isCreatingClassData:false,
      editedIndex: -1,
      baseUrl:window.Laravel.base_url,
      editedItem: {
        id:0,
        imgUrl:'',
        schoolId:'',
        schoolName:'',
        gradeId:'',
        gradeName:'',
        lessonName:'',
      },
      defaultItem: {
        id:0,
        imgUrl:'',
        schoolId:'',
        schoolName:'',
        gradeId:'',
        gradeName:'',
        lessonName:'',
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
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
        this.isLoadingClassData = true;
        await getClass().then(res=>{
          this.classData = res.data
        }).catch(err=>{
          console.log(err)
        })
        this.isLoadingClassData = false;
        getSchoolInfo().then(res=>{
          this.schoolInfo = res.data
        }).catch(err=>{
          console.log(err)
        })
      },

      editItem (item) {
        this.editedIndex = this.classData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        console.log(this.editedItem)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.classData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.classData.splice(this.editedIndex, 1)
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
        this.isCreatingClassData = true;
        if (this.editedIndex > -1) {
          await updateClass(this.editedItem).then(res=>{
            this.editedItem = res.data;
            Object.assign(this.classData[this.editedIndex], this.editedItem);
          }).catch(err=>{
            console.log(err)
          })
        } else {
          await createClass(this.editedItem).then(res=>{
            this.editedItem = res.data;
            this.classData.push(this.editedItem);
          }).catch(err=>{
            console.log(err)
          })
        }
        this.isCreatingClassData = false;
        this.close()
      },
      async selectSchool(id){
        console.log(id)
        await getGradeInfo({id:id}).then(res=>{
          console.log(res)
          this.gradeInfo = res.data
        }).catch(err=>{
          console.log(err)
        })
      },
      selectGrade(id){
        console.log(id)
      },
      upImgUrl(value) {
        this.editedItem.imgUrl = value;
        console.log(this.editedItem.imgUrl);
      },
      clearedImg(){
        this.editedItem.imgUrl = ''
        console.log(this.editedItem.imgUrl);
      },
    },
  }
</script>
<style>

</style>