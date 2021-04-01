<template>
    <v-container>
        <RouterBack title="邀请成员"></RouterBack>
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
            <v-row space-between @click="inviteMember" class="hover-cursor-point">
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
        <v-banner v-for="lesson in mySchoolData" :key="lesson.lessonId" class="hover-cursor-point" v-if="lesson.lessonId != currentPath.params.lessonId">
            <v-row space-between  @click="selLesson(lesson)">
                <v-col>
                    <span>{{lesson.lessonName}}</span> 
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
import RouterBack from '~/components/routerBack'
export default {
    components:{
        RouterBack
    },
    data:()=>({
        roleId:"3",
        mySchoolData:null
    }),
    computed:{
        currentPath(){
            return this.$route
        }
    },
    created(){
        this.mySchoolData = this.mySchoolInfo(this.currentPath.params.schoolId)
        console.log(this.mySchoolData)
    },
    methods:{
        inviteMember(){
            this.$router.push({
                name:'classSpace.inviteMember',
                params:{
                    schoolId:this.currentPath.params.schoolId,
                    gradeId:this.currentPath.params.gradeId,
                    lessonId:this.currentPath.params.lessonId
                },
                query:{
                    roleId:this.roleId
                }
            })
        },
        selLesson(lesson){
            console.log(lesson)
            this.$router.push({
                name:'classSpace.inviteMember',
                params:{
                    schoolId:this.currentPath.params.schoolId,
                    gradeId:this.currentPath.params.gradeId,
                    lessonId:this.currentPath.params.lessonId
                },
                query:{
                    roleId:this.roleId,
                    otherLesson:lesson.lessonId
                }
            })
        }
    }
}
</script>

<style>

</style>