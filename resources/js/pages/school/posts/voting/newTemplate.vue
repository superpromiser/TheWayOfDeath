<template>
    <v-container>
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
          <div class="d-flex align-center">
              <v-avatar
                  class="ma-3 ml-3"
                  size="50"
                  tile
              >
                  <v-img :src="`${baseUrl}/asset/img/icon/投票.png`" alt="postItem" ></v-img>
              </v-avatar>
              <h2>{{lang.voting}}模板</h2>
          </div>
          <template v-slot:actions>
            <v-btn
                dark
                color="green lighten-1"
                class="mr-md-8"
                :loading="isSubmit"
                @click="submit"
            >
                {{lang.submit}}
            </v-btn>
          </template>
        </v-banner>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newTemplateData.tempTitle"
                        label="模板名称"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newTemplateData.title"
                        label="标题"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newTemplateData.description"
                        label="说明（选填）"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <UploadImage @upImgUrl="upImgUrl" @clearedImg="clearedImg" :solo="true" uploadLabel="模板封面" />
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import AttachItemViewer from '~/components/attachItemViewer'
import UploadImage from '~/components/UploadImage';
import QuestionItem from '~/components/questionItem'
export default {
    middleware:'auth',
    components: {
        QuestionItem,
        AttachItemViewer,
        UploadImage
    },
    data:()=>({
        isSubmit:false,
        lang,
        baseUrl:window.Laravel.base_url,
        newTemplateData:{
            imgUrl:'',
            tempTitle:'',
            title:'',
            description:'',
        }
    }),
    methods:{
        submit(){

        },
        upImgUrl(value) {
            this.newTemplateData.imgUrl = value;
        },
        clearedImg(){
            this.newTemplateData.imgUrl = ''
        },
    },
}
</script>

<style>

</style>