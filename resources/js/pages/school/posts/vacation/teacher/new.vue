<template>
    <v-container class="pa-0">
        <v-banner class=" mb-10" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/icon/请假.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>请假</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                dark
                color="green lighten-1"
                class="mr-8"
            >
                提交
            </v-btn>
            </template>
        </v-banner>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newVacationData.title"
                        label="标题"
                        hide-details
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>

import { mapGetters } from 'vuex'
import lang from '~/helper/lang.json'

export default {
    data: () => ({
        lang,
        baseUrl: window.Laravel.base_url,
        newVacationData : {
            title:'',
            
        },
        dialog:false,
        date: new Date().toISOString().substr(0, 10),
        menu: false,
    }),

    components: {
        QuestionItem,
    },

    computed: {
        ...mapGetters({
            schoolTree : 'schooltree/schoolTree',
        })
    },

    mounted(){
        
    },

    methods:{
        
        
    }
}
</script>

<style>

</style>