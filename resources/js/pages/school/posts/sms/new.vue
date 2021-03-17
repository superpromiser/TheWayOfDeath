<template>
  <v-container>
        <v-banner class=" mb-10" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.sms}}</h2>
            </div>
            <template v-slot:actions>
                <v-btn
                    text
                    color="primary"
                    @click="selContent('template')"
                >
                    可用模板 0， 草稿 0
                </v-btn>
                <v-btn
                    dark
                    color="green lighten-1"
                    class="mr-8"
                    :loading="isSubmit"
                    @click="submit"
                >
                    {{lang.submit}}
                </v-btn>
                <v-btn
                    dark
                    color="lighten-1"
                    class="mr-8"
                    :loading="isDraft"
                    @click="saveDraft"
                >
                    {{lang.saveDraft}}
                </v-btn>
            </template>
        </v-banner>
        <QuestionItem :Label="lang.contentPlaceFirst" :emoji="true" :contact="true"  ref="child" @contentData="loadContentData"></QuestionItem>
        <v-snackbar
            timeout="3000"
            v-model="requiredText"
            color="error"
            absolute
            top
            >
            {{lang.requiredText}}
        </v-snackbar>
        <v-snackbar
        timeout="3000"
            v-model="isSuccessed"
            color="success"
            absolute
            top
            >
            {{lang.successText}}
        </v-snackbar>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
import {createSms} from '~/api/sms'
export default {
    components:{
        QuestionItem,
    },

    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        isSubmit:false,
        isDraft:false,
        requiredText:false,
        smsData:[],
        isSuccessed:false,
    }),

    methods:{
        saveDraft(){

        },

        async submit(){
            this.$refs.child.emitData()
            if(this.smsData.length == 0){
                return
            }
            console.log(this.smsData)
            this.isSubmit = true
            await createSms({smsData:this.smsData}).then(res=>{
                console.log(res)
                this.isSubmit = false
                this.isSuccessed = true;
                this.$router.push({name:'schoolSpace.news'})
            }).catch(err=>{
                console.log(err.response)
                this.isSubmit = false
            })
        },

        loadContentData(data){
            if(data.text === ''){
                this.requiredText = true;
                this.smsData = [];
                return;
            }
            this.smsData.push(data)
        }
    }
}
</script>

<style>

</style>