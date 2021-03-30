<template>
  <v-container>
    <v-row class="align-center ma-0">
        <v-col cols="12" md="6">
            <v-row class="ma-0 align-center justify-center justify-md-start">
                <v-avatar class="ma-3 school-card-avatar" tile >
                    <v-img :src="`${baseUrl}/asset/img/icon/公告 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-15 mb-3"> {{lang.regname}}  </p>
            </v-row>
        </v-col>
        <v-col cols="12" md="6">
            <v-row class="ma-0 align-center justify-center justify-md-end" >
                <v-icon medium color="primary" class="mr-2">mdi-clock-outline </v-icon>
                <p class="mb-0 mr-8" v-if="contentData !== null">{{TimeView(contentData.created_at)}}</p>
                <v-icon medium color="primary" class="mr-2">mdi-account </v-icon>
                <p class="mb-0" v-if="contentData !== null">{{contentData.users.name}}</p>
            </v-row>
        </v-col>
    </v-row>
    <v-row class="ma-0">
        <v-col cols="12" class="text-center">
            <h1>{{regNameData.title}}</h1>
        </v-col>
        <v-col cols="12" >
            <p class="text-wrap">{{regNameData.content[0].text}}</p>
        </v-col>
        <v-col cols="12" v-if="checkIfAttachExist(regNameData.content[0])">
            <AttachItemViewer :items="regNameData.content[0]" />
        </v-col>
    </v-row>
    <v-divider light></v-divider>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="desserts"
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar flat>
              <v-toolbar-title>My CRUD</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-btn>something</v-btn>
            </v-toolbar>
          </template>
          <template v-slot:[`item.actions`]="{  }">
            <v-icon
              small
              class="mr-2"
            >
              mdi-pencil
            </v-icon>
            <v-icon
              small

            >
              mdi-delete
            </v-icon>
          </template>
          <template v-slot:no-data>
            no data
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex';
import {getAnswerList, } from '~/api/regname'
import AttachItemViewer from '~/components/attachItemViewer';
  export default {
    data: () => ({
        lang,
        dialog: false,
        regNameData: null,
        desserts: [
            
        ],
        baseUrl:window.Laravel.base_url,
        headers: [
            { text: 'student', align: 'start', sortable: false, value: 'name' },
            { text: 'className', value: 'calories', sortable: false },
            { text: 'view', value: 'fat', sortable: false },
            { text: 'status', value: 'carbs', sortable: false, align: 'center' },
            { text: 'Actions', value: 'actions', sortable: false },
        ],
        
    }),

    components:{
        AttachItemViewer,
    },

    computed: {
        ...mapGetters({
            contentData: 'content/postDetail',
            user: 'auth/user'
        }),
    },

    watch: {
    },

    async created () {
        if(this.contentData == null){
            this.$router.push({name: 'schoolSpace.news'});
        }
        else{
            console.log("^^^", this.contentData);
            this.regNameData = this.contentData.regnames;
            this.regNameData.content = JSON.parse(this.regNameData.content);
            this.regNameData.inputTypeList = JSON.parse(this.regNameData.inputTypeList);
            this.regNameData.viewList = JSON.parse(this.regNameData.viewList);

            // this.regNameData.inputTypeList.map(x=>{
            //     this.regAnswerData[x] = "";
            // })

            console.log("###",this.regNameData, this.regAnswerData);

            let payload = {
                id: this.regNameData.id
            }

            await getAnswerList(payload)
            .then((res) => {
                console.log(res);
            }).catch((err) => {
                console.log(err)
            });
        }
    },

    methods: {

    },
  }
</script>
<style>

</style>