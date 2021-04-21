<template>
    <v-container class="pa-0">
        <v-container class="px-10 z-index-2 banner-custom">
            <v-row>
                <v-col cols="6" md="4" class="d-flex align-center position-relative">
                    <a @click="$router.go(-1)">
                        <v-icon size="70" class=" left-24p">
                            mdi-chevron-left
                        </v-icon>
                    </a>
                </v-col>
                <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                    <h2>申请</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-text-field
                        solo
                        label="搜索"
                        prepend-inner-icon="mdi-magnify"
                        v-model="search"
                        hide-details
                        dense
                        class=""
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-container>
        <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="primary"
            ></v-progress-circular>
        </div>
        <div v-else class="px-10">
            <v-row class="py-3">
                <v-col cols="6" md="8">申请人信息</v-col>
                <v-col cols="6" md="4">邀请人</v-col>
            </v-row>
            <v-divider light class="thick-border"></v-divider>
            <div v-for="member in filteredList" :key="member.id">
                <v-row class="py-3">
                    <v-col cols="12" md="8">
                        <v-row>
                            <v-col>
                                <v-row>
                                    <v-col>姓名：{{member.members.name}}</v-col>
                                    <v-col>{{transGender(member.members.gender)}}</v-col>
                                    <v-col>{{pnEncrypt(member.members.phoneNumber)}}</v-col>
                                    <v-col>{{transRole(member.members.roleId)}}</v-col>
                                    <!-- <v-col>李四母亲</v-col> -->
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-row>
                            <v-col cols="6">
                                {{member.users.name}}
                            </v-col>
                            <v-col cols="3">
                                <v-btn
                                    depressed
                                    color="primary"
                                    :loading="isAllow"
                                    @click="allow(member)"
                                >
                                    接受
                                </v-btn>
                            </v-col>
                            <v-col cols="3">
                                <v-btn
                                    depressed
                                    color="primary"
                                    :loading="isDeny"
                                    @click="deny(member)"
                                >
                                    拒绝
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-divider light class="thick-border"></v-divider>
            </div>
        </div>
    </v-container>
</template>

<script>
import {getPendingGroupMember,updateGroupMember,deleteGroupMember} from '~/api/group';
import RouterBack from '~/components/routerBack'
export default {
    components:{
        RouterBack,
    },
    data:()=>({
        userList:[],
        isAllow:false,
        isDeny:false,
        search:'',
        isLoading:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        },
        filteredList(){
            return this.userList.filter(user=>{
                return user.members.name.toLowerCase().includes(this.search.toLowerCase())
            })
        }
    },
    async created(){
        this.isLoading = true
        await getPendingGroupMember({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            this.userList = res.data
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
        })
    },
    methods:{
        async allow(member){
            // this.isAllow = true
            console.log('allow',member)
            await updateGroupMember({id:member.id}).then(res=>{
                this.isAllow = false
                let index = this.userList.indexOf(member)
                console.log(index)
                if(index > -1){
                    this.userList.splice(index,1)
                }
            }).catch(err=>{
                this.isAllow = false
                console.log(err.response)
            })
        },
        deny(member){
            // this.isDeny = true
            let userList = []
            userList.push(member.id)
            deleteGroupMember({userList:userList}).then(res=>{
                this.isDeny = false
                let index = this.userList.indexOf(member)
                console.log(index)
                if(index > -1){
                    this.userList.splice(index,1)
                }
            }).catch(err=>{
                this.isDeny = false
                console.log(err.response)
            })
            console.log('deny',member)
        }
    }
}
</script>

<style>

</style>