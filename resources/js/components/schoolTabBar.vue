<template>
    <v-container class="d-flex align-center pa-0 pt-5 school-tab-bar">
        <v-tabs>
            <v-tab :to="{name:'schoolSpace.news'}">最新</v-tab>
            <v-tab :to="{name:'schoolSpace.application'}">应用</v-tab>
            <v-tab :to="{name:'schoolSpace.member'}">成员</v-tab>
        </v-tabs>
        <v-btn
            tile
            color="success"
            class="mr-5"
            @click="post"
            >
            <v-icon left>
                mdi-book-plus 
            </v-icon>
            发布
        </v-btn>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    computed:{
        ...mapGetters({
            schoolTree:'schooltree/schoolTree'
            }),
            currentPath(){
                return this.$route
            }
    },
    created(){
        console.log(this.currentPath)
    },
    methods:{
        post(){
            this.$router.push({name:"schoolSpace.post"})
        }
    }
}
</script>

<style>

</style>