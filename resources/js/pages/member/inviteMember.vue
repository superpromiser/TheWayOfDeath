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
            <v-row  justify-space-between>
                <v-col>
                    <v-checkbox
                        v-model="selected"
                        label="全选"
                        value="John"
                        class="member-chk"
                        style="height:20px !important"
                        @click="selectAll"
                    ></v-checkbox>
                </v-col>
            </v-row>
            </v-banner>
        <v-banner v-for="(user,index) in userList" :key="index">
            <v-row>
                <v-col>
                    <v-checkbox
                        v-model="selected[index]"
                        :label="user.name"
                        :value="user.id"
                        class="member-chk"
                    ></v-checkbox>
                </v-col>
                <v-col>
                    性别：{{transGender(user.gender)}}
                </v-col>
                <v-col>
                    手机号码：{{pnEncrypt(user.phoneNumber)}}
                </v-col>
            </v-row>
        </v-banner>
    </v-container>
</template>

<script>
import {getSchoolMemberList} from '~/api/user'
export default {
    data:() => ({
        selected:[],
        userList:[],
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        getSchoolMemberList({schoolId:this.currentPath.params.schoolId}).then(res=>{
            console.log(res.data)
            this.userList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        selectAll(){
            if(this.selected.length == 0){
                for(let i=0; i< this.userList.length;i++){
                    this.selected.push(this.userList[i].id)
                }
            }else{
                this.selected = []
            }
            console.log(this.selected)
        }
    }
}
</script>

<style>

</style>