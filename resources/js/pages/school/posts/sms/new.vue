<template>
    <v-container class="pa-0">
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
        <QuestionItem :Label="lang.contentPlaceFirst" :btnType="btnType"></QuestionItem>
    </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import QuestionItem from '~/components/questionItem'
export default {
    components:{
        QuestionItem,
    },

    data: ()=> ({
        lang,
        baseUrl: window.Laravel.base_url,
        isSubmit:false,
        isDraft:false,
        btnType:{
            emoji:'emoji',
            sms:"sms"
        },
    }),

    methods:{
        saveDraft(){

        },

        submit(){

        }
    }
}
</script>

<style>

</style>