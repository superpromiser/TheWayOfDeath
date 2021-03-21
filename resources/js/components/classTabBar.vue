<template>
    <v-container class="d-flex align-center pa-0 pt-5 school-tab-bar">
        <v-tabs>
            <v-tab :to="`/schoolspace/${path.params.id}/class/${path.params.gradeId}/${path.params.classId}/news`">最新</v-tab>
            <v-tab :to="`/schoolspace/${path.params.id}/class/${path.params.gradeId}/${path.params.classId}/application`">应用</v-tab>
            <v-tab :to="`/schoolspace/${path.params.id}/class/${path.params.gradeId}/${path.params.classId}/member`">成员</v-tab>
        </v-tabs>
        <router-link :to="`/schoolspace/${path.params.id}/class/${path.params.gradeId}/${path.params.classId}/post`">
            <v-btn
                tile
                color="success"
                class="mr-5"
                >
                <v-icon left>
                    mdi-book-plus 
                </v-icon>
                发布
            </v-btn>
        </router-link>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    props:{
        path: {
            type: Object,
            required: true,
        }
    },
    computed:{
        ...mapGetters({
            schoolData : 'schooltree/schoolData'
        }),
    },

    mounted(){
        console.log("this.path", this.path);
    }
}
</script>

<style>

</style>