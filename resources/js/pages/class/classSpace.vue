<template>
    <v-container class="pa-0">
        <v-container class="d-flex align-center pa-0 pt-5 school-tab-bar" v-if="isPost">
            <v-tabs color="#7879ff">
                <v-tab :to="{name:'classSpace.news'}">最新</v-tab>
                <v-tab :to="{name:'classSpace.application'}">应用</v-tab>
                <v-tab :to="{name:'classSpace.member'}">成员</v-tab>
            </v-tabs>
            <v-btn
                tile
                color="#7879ff"
                class="mr-5"
                @click="post"
                >
                <v-icon left>
                    mdi-book-plus 
                </v-icon>
                发布
            </v-btn>
        </v-container>
        <transition name="fade" mode="out-in">
            <router-view :key="$route.path"></router-view>
            <!-- <router-view></router-view> -->
        </transition>
    </v-container>
</template>

<script>
export default {
    computed:{
        currentPath(){
            return this.$route;
        },
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.name=="classSpace" || val.name=="classSpace.news" || val.name == "classSpace.member" || val.name == "classSpace.application"){
                    this.isPost = true
                }
            },
            deep:true
        },
        $route(to, from) {
            // this.$router.go()
        }
    },
    created(){
        //console.log(this.currentPath)
        if(this.currentPath.name=="classSpace" || this.currentPath.name=="classSpace.news" || this.currentPath.name == "classSpace.member" || this.currentPath.name == "classSpace.application"){
            this.isPost = true
        }
    },
    methods:{
        post(){
            this.$router.push({name:"classSpace.post"})
            this.isPost = false
        }
    }

}
</script>

<style>

</style>