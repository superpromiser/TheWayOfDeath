<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-data-table
                    :headers="headers"
                    :items="userRoleList"
                    :loading="isLoadingRoleData"
                    loading-text="正在加载..."
                    class="elevation-1"
                >
                    <template v-slot:top>
                        <v-toolbar
                            flat
                        >
                            <v-toolbar-title><strong>角色</strong></v-toolbar-title>
                            <v-divider
                            class="mx-4"
                            inset
                            vertical
                            ></v-divider>
                            <v-spacer></v-spacer>
                            <v-dialog
                            v-model="dialog"
                            max-width="500px"
                            scrollable
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn color="#7879ff" dark class="mb-2" v-bind="attrs" v-on="on">
                                    添加
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="headline">{{ formTitle }}</span>
                                    </v-card-title>
                                    <v-card-text style="height:100px;">
                                        <v-container>
                                            <v-row>
                                                <v-col cols="12" >
                                                    <v-text-field
                                                    v-model="editedItem.roleName"
                                                    label="角色名字"
                                                    ></v-text-field>
                                                </v-col>
                                                <!-- <v-treeview
                                                    selectable
                                                    v-model="editedItem.permission"
                                                    :items="schoolSpaceMenu.data"
                                                    return-object
                                                    open-all
                                                ></v-treeview> -->
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
                                        {{lang.cancel}}
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                        :loading="isCreating"
                                    >
                                        {{lang.save}}
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
                                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">{{lang.ok}}</v-btn>
                                    <v-spacer></v-spacer>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-toolbar>
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
  import {getUserRole,createUserRole,updateUserRole,deleteUserRole} from '~/api/userRole';
  import { mapGetters } from 'vuex';
  import schoolSpaceMenu from '~/helper/schoolSpaceMenu.json'
  import lang from '~/helper/lang.json'
  export default {
    middleware: 'auth',
    data: () => ({
      dialog: false,
      dialogDelete: false,
      headers: [
        { text: '角色', value: 'roleName',  sortable: false, align: 'start' },
        { text: '创建于', value: 'created_at', sortable: false },
        { text: '操作', value: 'actions', sortable: false },
      ],
      userRoleList: [],
      editedIndex: -1,
      editedItem: {
        roleName: '',
        permission:[]
      },
      defaultItem: {
        roleName: '',
        permission:[]
      },
      selection:[],
      selectionType: 'leaf',
      isLoadingRoleData : false,
      categoryItems: [
        {
          id: 1,
          name: 'Root',
          children: [
            { id: 2, name: 'Child #1' },
            { id: 3, name: 'Child #2' },
            {
              id: 4,
              name: 'Child #3',
              children: [
                { id: 5, name: 'Grandchild #1' },
                { id: 6, name: 'Grandchild #2' },
              ],
            },
          ],
        },
      ],
      schoolSpaceMenu,
      lang,
      isCreating : false,
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? '新增角色' : '编辑角色'
      },
      ...mapGetters({
        authenticated: 'auth/check'
      })
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
        this.isLoadingRoleData = true;
        getUserRole().then(res=>{
          this.isLoadingRoleData = false;
          this.userRoleList = res.data
          this.userRoleList.map(item=>{
            item.created_at = this.TimeView(item.created_at)
            item.permission = JSON.parse(item.permission)
          })
        })
      },
      editItem (item) {
        this.editedIndex = this.userRoleList.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.userRoleList.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.userRoleList.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      async closeDelete () {
        await deleteUserRole(this.editedItem).then(res=>{
          this.dialogDelete = false
          this.$nextTick(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.editedIndex = -1
          })
        }).catch(err=>{
          //console.log(err)
        })
      },

     async save () {
       this.isCreating = true;
        if(this.editedIndex > -1){
          await updateUserRole(this.editedItem).then(res=>{
            Object.assign(this.userRoleList[this.editedIndex], this.editedItem)
          }).catch(err=>{
            //console.log(err)
          })
        }
        else {
          //console.log(this.editedItem)
          await createUserRole(this.editedItem).then(res=>{
            res.data.created_at = this.TimeView(res.data.created_at)
            this.editedItem = res.data
            this.editedItem.permission = JSON.parse(this.editedItem.permission);
            this.userRoleList.push(this.editedItem)
          }).catch(err=>{
            //console.log(err)
          })
        }
        this.isCreating = false;
        this.close()
      },
    },
  }
</script>
<style>

</style>