<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-data-table
                    :headers="headers"
                    :items="schoolData"
                    sort-by="calories"
                    class="elevation-1"
                >
                    <template v-slot:top>
                        <v-toolbar
                            flat
                        >
                            <v-toolbar-title><strong>学校</strong></v-toolbar-title>
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
                                            <v-text-field
                                            v-model="editedItem.schoolName"
                                            label="机构名称"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" >
                                            <v-text-field
                                            v-model="editedItem.code"
                                            label="组织机构代码"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" >
                                            <v-text-field
                                            v-model="editedItem.phoneNum"
                                            label="固定电话"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" >
                                            <v-text-field
                                            v-model="editedItem.zipCode"
                                            label="邮编"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" >
                                            <v-text-field
                                            v-model="editedItem.head"
                                            label="学校负责人"
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
                                    Cancel
                                </v-btn>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="save"
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
                    <template v-slot:item.actions="{ item }">
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
                        <v-btn
                            color="primary"
                            @click="initialize"
                        >
                            Reset
                        </v-btn>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
        
    </v-container>
</template>

<script>

import cityListJson from '!!raw-loader!./cityLaw.txt';
export default {
    data: () => ({
        dialog: false,
        dialogDelete: false,
        headers: [
            { text: '号码', value: 'id', align: 'start'},
            { text: '图标图像', value: 'imgUrl', sortable: false },
            { text: '机构名称', value: 'schoolName', sortable: false },
            { text: '组织机构代码', value: 'code' },
            { text: '固定电话', value: 'phoneNum' },
            { text: '邮编', value: 'zipCode' },
            { text: '学校负责人', value: 'head', sortable: false },
            { text: '学校地址', value: 'address', sortable: false },
            { text: '学校简介', value: 'introduce', sortable: false },
            { text: '行动', value: 'actions', sortable: false },
        ],
        schoolData: [],
        editedIndex: -1,
        editedItem: {
            id: 0,
            imgUrl: '',
            schoolName: '',
            code: 0,
            phoneNum: 0,
            zipCode: 0,
            head: '',
            address : {
                province : null,
                city : null, 
                region : null,
                detail : '',
            },
            introduce: '',
        },
        defaultItem: {
            id: 0,
            imgUrl: '',
            schoolName: '',
            code: 0,
            phoneNum: 0,
            zipCode: 0,
            head: '',
            address : {
                province : null,
                city : null, 
                region : null,
                detail : '',
            },
            introduce: '',
        },
        provinceListJsonArr:[],
        madeJsonFromString : [],
        willBeCityDataOfSchoolAddress : null,
        willBeRegionDataOfSchoolAddress : null,
        willBeCityDataOfResidenceAddress : null,
        willBeCityDataOfFamilyAddress : null,
        willBeRegionDataOfResidenceAddress : null,
        willBeRegionDataOfFamilyAddress : null,
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? '新增学校' : '编辑学校'
      },
    },

    async created(){
        this.provinceListJsonArr = cityListJson.split("#");
        for (let i = 0; i < this.provinceListJsonArr.length; i++) {
            let provinceObj = {
                value : 1,
                label : "",
                city : []
            }
            let province = this.provinceListJsonArr[i].split("$")[0];
            provinceObj.value = province.split("-")[0];
            provinceObj.label = province.split("-")[1];
            this.madeJsonFromString.push(provinceObj);
            let TArea = this.provinceListJsonArr[i].split("$")[1].split("|");
            for(let j = 0 ; j < TArea.length ; j++){
                let cityObj = {
                    value : 1,
                    label : "",
                    region : []
                }
                let cityArr = TArea[j].split(",");
                cityObj.value = cityArr[0].split("-")[0];
                cityObj.label = cityArr[0].split("-")[1];
                for( let k = 1 ; k < cityArr.length ; k++){
                    let regionObj = {
                        value : 1, 
                        label : "",
                    }
                    regionObj.value = cityArr[k].split("-")[0];
                    regionObj.label = cityArr[k].split("-")[1];
                    cityObj.region.push(regionObj);
                }
                this.madeJsonFromString[i].city.push(cityObj);
            }
        }
        // const res = await this.callApi('get','/api/school');
        // if(res.status == 200){
        //     this.schoolList = res.data;
        //     for(let i = 0 ; i < this.schoolList.length ; i++){
        //         let clonedVal = JSON.parse(JSON.stringify(this.schoolList[i]));
        //         this.schoolListRaw.push(clonedVal); 
        //         this.schoolList[i].address = this.convertAddress(this.schoolList[i].address);
        //     }
        // }
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
      initialize () {
        this.schoolData = [
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 2234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          {
            id: 1,
            imgUrl: '/somethinhg',
            schoolName: 'Eschool',
            code: 1234354,
            phoneNum: 4634524,
            zipCode: 4634524,
            head: 'Head',
            address: 'address Something',
            introduce: "introduce something",
          },
          
        ]
      },

      editItem (item) {
        this.editedIndex = this.schoolData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.schoolData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.schoolData.splice(this.editedIndex, 1)
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

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.schoolData[this.editedIndex], this.editedItem)
        } else {
          this.schoolData.push(this.editedItem)
        }
        this.close()
      },
    },
  }
</script>
<style>

</style>