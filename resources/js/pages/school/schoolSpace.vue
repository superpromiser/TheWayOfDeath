<template>
    <v-container class="pa-0">
        <v-container class="d-flex align-center pa-0 pt-5 school-tab-bar" v-if="isPost">
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
        <transition name="fade" mode="out-in">
            <keep-alive>
                <!-- <router-view :key="$route.path"></router-view> -->
                <router-view></router-view>
            </keep-alive>
        </transition>
    </v-container>
</template>

<script>
export default {
    data:() =>({
        isPost:false
    }),

    computed:{
        currentPath(){
            return this.$route
        }
    },
    watch:{
        currentPath:{
            handler(val){
                //console.log('*********',val)
                if(val.name=="schoolSpace" || val.name=="schoolSpace.news" || val.name == "schoolSpace.member" || val.name == "schoolSpace.application"){
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
        if(this.currentPath.name=="schoolSpace" || this.currentPath.name=="schoolSpace.news" || this.currentPath.name == "schoolSpace.member" || this.currentPath.name == "schoolSpace.application"){
            this.isPost = true
        }
    },
    methods:{
        post(){
            this.$router.push({name:"schoolSpace.post"})
            this.isPost = false
        }
    }
}
</script>

<style>

</style>