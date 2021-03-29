<template>
    <v-container>
        <!-- <v-banner>
            <v-row justify-space-between>
                <v-col cols="6" class="pa-5">
                    <span>头像</span>
                </v-col>
                <v-col cols="6">
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row>
                <v-col cols="9">
                    小组名称
                </v-col>
                <v-col cols="3">
                    <v-text-field class="member-chk" label="place holder" style="height:33px;"></v-text-field>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row>
                <v-col cols="6">
                    邀请成员
                </v-col>
                <v-col cols="6">
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
        </v-banner> -->
        <v-banner>
            <v-row>
                <v-col cols="6">
                    小组名称
                </v-col>
                <v-col cols="3">
                    <v-text-field class="member-chk" label="place holder" style="height:33px;" v-model="groupName"></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-btn
                        tile
                        dark
                        color="green lighten-1"
                        class="mx-2 float-right"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        新增群组
                    </v-btn>
                </v-col>
            </v-row>
        </v-banner>
    </v-container>
</template>

<script>
export default {
    data:()=>({
        isSubmit:false,
        groupName:'',
        groupList:[]
    }),
    computed:{
        currentPath(){
           return this.$route
        }
    },
    methods:{
        async submit(){
            this.isSubmit = true
            // await addGroup({schoolId:this.currentPath.params.schoolId,name:this.groupName}).then(res=>{
            //     console.log(res.data)
            //     this.isSubmit = false
            // }).catch(err=>{
            //     console.log(err.response)
            // })
        }
    }
}
</script>

<style>

</style>