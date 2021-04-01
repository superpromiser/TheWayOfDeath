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
        <RouterBack title="小组"></RouterBack>
        <v-banner>
            <v-row>
                <v-col cols="6">
                    小组名称
                </v-col>
                <v-col cols="3">
                    <v-text-field class="member-chk" label="place holder" style="height:33px;" v-model="clubName"></v-text-field>
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
        <v-banner v-for="club in clubList" :key="club.id">
            <v-row @click="addMember(club)"  class="hover-cursor-point">
                <v-col cols="3">
                    {{club.clubName}}
                </v-col>
                <v-col cols="6">

                </v-col>
                <v-col cols="3">
                    <v-btn
                        tile
                        dark
                        color="primary lighten-1"
                        class="mx-2 float-right"
                        @click="removeClub(club)"
                    >
                        删除群组
                    </v-btn>
                </v-col>
            </v-row>
        </v-banner>
    </v-container>
</template>

<script>
import {getClub,createClub,deleteClub} from '~/api/group'
import RouterBack from '~/components/routerBack'
export default {
    components:{
        RouterBack,
    },
    data:()=>({
        isSubmit:false,
        clubName:'',
        clubList:[]
    }),
    computed:{
        currentPath(){
           return this.$route
        }
    },
    async created(){
        await getClub({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            this.clubList = res.data
        }).catch(err=>{
            console.log(err.response)
        })
    },
    methods:{
        async submit(){
            if(this.clubName == ''){
                
                return;
            }
            this.isSubmit = true
            await createClub({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId,clubName:this.clubName}).then(res=>{
                console.log(res.data)
                this.isSubmit = false
                this.clubList.push(res.data)
                this.clubName = ''
            }).catch(err=>{
                console.log(err.response)
                this.isSubmit = false
            })
        },
        async removeClub(club){
            await deleteClub({id:club.id}).then(res=>{
                console.log(res.data)
                let index = this.clubList.indexOf(club);
                if(index > -1){
                    this.clubList.splice(index,1)
                }
            }).catch(err=>{
                console.log(err.response)
            })
        },
        addMember(club){

        }
    }
}
</script>

<style>

</style>