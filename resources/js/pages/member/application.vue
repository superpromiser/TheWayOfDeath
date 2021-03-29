<template>
    <v-container>
        <v-banner>
            <v-row>
                <v-col>
                    <v-text-field
                        solo
                        label="Prepend inner"
                        prepend-inner-icon="mdi-magnify"
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row justify-space-between>
                <v-col cols="8">申请人信息</v-col>
                <v-col cols="4">邀请人</v-col>
            </v-row>
        </v-banner>
        <v-banner v-for="member in userList" :key="member.id">
            <v-row justify-space-between>
                <v-col cols="8">
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
                <v-col cols="4">
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
        </v-banner>
    </v-container>
</template>

<script>
import {getGroupMember,updateGroupMember} from '~/api/group';
export default {
    data:()=>({
        userList:[],
        isAllow:false,
        isDeny:false,
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    async created(){
        await getGroupMember({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            this.userList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        async allow(member){
            // this.isAllow = true
            console.log('allow',member)
            await updateGroupMember({id:member.id,status:'allow'}).then(res=>{
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
            updateGroupMember({id:member.id,status:'deny'}).then(res=>{
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