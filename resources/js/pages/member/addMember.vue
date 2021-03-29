<template>
    <v-container>
        <v-banner>
            <v-row space-between>
                <v-col cols="6">
                    <span>角色</span> 
                </v-col>
                <v-col cols="6">
                    <v-radio-group
                        v-model="roleId"
                        row
                        class="float-right member-chk"
                    >
                        <v-radio
                            label="老师"
                            value="3"
                        ></v-radio>
                        <v-radio
                            label="学生"
                            value="5"
                        ></v-radio>
                        <v-radio
                            label="家长"
                            value="4"
                        ></v-radio>
                    </v-radio-group>
                </v-col>
            </v-row>
        </v-banner>
        <v-banner>
            <v-row space-between @click="inviteMember">
                <v-col>
                    <span>邀请成员</span> 
                </v-col>
                <v-col>
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
        </v-banner>
        <div class="divider" style="height:2rem;padding-left:22px;">
            从其他群主邀请
        </div>
        <v-banner v-for="school in schoolData" :key="school.id">
            <v-row space-between>
                <v-col>
                    <span>{{school.schoolName}}</span> 
                </v-col>
                <v-col>
                    <v-icon class="float-right">
                        mdi-chevron-right
                    </v-icon>
                </v-col>
            </v-row>
        </v-banner>
      
  </v-container>
</template>

<script>
export default {

    data:()=>({
        roleId:"3"
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        this.schoolData = this.returnSchoolTree(this.currentPath.params.schoolId)
        console.log(this.schoolData)
    },
    methods:{
        inviteMember(){
            this.$router.push({name:'schoolSpace.inviteMember',params:{schoolId:this.currentPath.params.schoolId}})
        }
    }
}
</script>

<style>

</style>