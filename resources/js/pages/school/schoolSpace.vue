<template>
    <v-container class="pa-0">
        <v-container class="d-flex align-center pa-0 pt-5 school-tab-bar">
            <v-tabs color="#7879ff">
                <v-tab :to="{name:'schoolSpace.news'}">最新</v-tab>
                <v-tab :to="{name:'schoolSpace.application'}">应用</v-tab>
                <!-- <v-tab :to="{name:'schoolSpace.member'}">成员</v-tab> -->
            </v-tabs>
            <v-btn
                tile
                color="#7879ff"
                dark
                class="mr-9"
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
                <router-view :key="$route.path"></router-view>
                <!-- <router-view></router-view> -->
            </keep-alive>
        </transition>
    </v-container>
</template>

<script>
import {mapGetters} from 'vuex'
import {getDashboardData} from '~/api/tablet'
export default {
    middleware:'auth',
    data:() =>({
        isPost:false,
        userRoleId:''
    }),

    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            user:'auth/user'
        })
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
        this.userRoleId = this.user.roleId
        console.log("this.user.roleId",this.userRoleId)
        if(this.currentPath.name=="schoolSpace" || this.currentPath.name=="schoolSpace.news" || this.currentPath.name == "schoolSpace.member" || this.currentPath.name == "schoolSpace.application"){
            this.isPost = true
        }

        // if(this.user.roleId == 7){
        //     console.log('dahboard called')
        //     getDashboardData().then(res=>{
        //         console.log('getdashboardData',res.data)
        //     }).catch(err=>{
        //         console.log(err.response)
        //     })
        // }
    },
    methods:{
        post(){
            this.$router.push({name:"schoolSpace.post"})
            this.isUser = false
        }
    }
}
</script>

<style>

</style>