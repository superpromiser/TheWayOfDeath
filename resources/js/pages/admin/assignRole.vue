<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-data-table
                    :headers="headers"
                    :items="userRoleList"
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
                                    <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                                    添加
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="headline">{{ formTitle }}</span>
                                    </v-card-title>
                                    <v-card-text style="height:400px;">
                                        <v-container>
                                            <v-row>
                                                <v-col cols="12" >
                                                    <v-text-field
                                                    v-model="editedItem.roleName"
                                                    label="Dessert name"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-treeview
                                                    selectable
                                                    :items="categoryItems"
                                                ></v-treeview>
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
  import {getUserRole} from '~/api/userRole';

  export default {
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
      },
      defaultItem: {
        roleName: '',
      },
      categoryItems: [
        {
          id: 5,
          name: 'Documents :',
          children: [
            {
              id: 6,
              name: 'vuetify :',
              children: [
                {
                  id: 7,
                  name: 'src :',
                },
                {
                  id: 7,
                  name: 'src :',
                },
                {
                  id: 7,
                  name: 'src :',
                },
              ],
            },
            {
              id: 10,
              name: 'material2 :',
              children: [
                {
                  id: 11,
                  name: 'src :',
                },
                {
                  id: 11,
                  name: 'src :',
                },
                {
                  id: 11,
                  name: 'src :',
                },
              ],
            },
          ],
        },
      ],
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? '新增角色' : '编辑角色'
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
      initialize () {
        getUserRole().then(res=>{
          console.log(res.data)
          this.userRoleList = res.data
          this.userRoleList.map(item=>{
            item.created_at = this.TimeView(item.created_at)
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

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.userRoleList[this.editedIndex], this.editedItem)
        } else {
          this.userRoleList.push(this.editedItem)
        }
        this.close()
      },
    },
  }
</script>
<style>

</style>