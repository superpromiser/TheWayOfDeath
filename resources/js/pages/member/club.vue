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
                    <h2>小组</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        tile
                        dark
                        color="#7879ff"
                        class="mx-2 float-right"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        新增小组
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="#7879ff"
            ></v-progress-circular>
        </div>
        <div v-else class="px-10">
            <!-- <v-row class="py-5">
                <v-col cols="4">
                    小组名称
                </v-col>
                <v-col cols="4">
                </v-col>
                <v-col cols="4">
                    <v-btn
                        tile
                        dark
                        color="#7879ff"
                        class="mx-2 float-right"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        新增群组
                    </v-btn>
                </v-col>
            </v-row>
            <v-divider light class="thick-border"></v-divider> -->
            <div v-for="club in clubList" :key="club.id">
                <v-row @click="addMember(club)"  class="hover-cursor-point py-3">
                    <v-col cols="3">
                        {{club.clubName}}
                    </v-col>
                    <v-col cols="6">
                        <span v-for="(member,index) in club.members" :key="index">
                            {{member}}
                            <span v-if="index != club.members.length-1">,</span>
                        </span>
                        <!-- <span>{{club.members}}</span> -->
                        <span></span>
                    </v-col>
                    <v-col cols="3" class="text-right">
                        <!-- <v-btn
                            tile
                            dark
                            color="primary lighten-1"
                            class="mx-2 float-right"
                            @click="editClub(club)"
                        >
                            删除小组
                        </v-btn> -->
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    small
                                    :loading="isEditing"
                                    @click="editClub(club)"
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                <v-icon small>mdi-pencil</v-icon>
                                </v-btn>
                            </template>
                            <span>编辑</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    small
                                    :loading="isDeleting"
                                    @click="removeClub(club)"
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                <v-icon small>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                            <span>删除</span>
                        </v-tooltip>
                    </v-col>
                </v-row>
                <v-divider light class="thick-border"></v-divider>
            </div>
        </div>
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
        clubList:[],
        isLoading:false,
        isEditing:false,
        isDeleting:false,
    }),
    computed:{
        currentPath(){
           return this.$route
        }
    },
    async created(){
        this.$store.dispatch('member/storeClubName','');
        this.$store.dispatch('member/storeClubMembers',[]);
        this.isLoading = true
        await getClub({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
            console.log(res.data)
            this.clubList = res.data
            this.isLoading = false
        }).catch(err=>{
            console.log(err.response)
            this.isLoading = false
        })
    },
    methods:{
        async submit(){
            // if(this.clubName == ''){
                
            //     return;
            // }
            // this.isSubmit = true
            // await createClub({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId,clubName:this.clubName}).then(res=>{
            //     console.log(res.data)
            //     this.isSubmit = false
            //     this.clubList.push(res.data)
            //     this.clubName = ''
            // }).catch(err=>{
            //     console.log(err.response)
            //     this.isSubmit = false
            // })
            this.$router.push({name:'member.newClub'})
        },
        editClub(club){
            // deleteClub({id:club.id}).then(res=>{
            //     console.log(res.data)
            //     let index = this.clubList.indexOf(club);
            //     if(index > -1){
            //         this.clubList.splice(index,1)
            //     }
            // }).catch(err=>{
            //     console.log(err.response)
            // })
            let selUsers = []

            club.member.map(member=>{
                selUsers.push(member.user)
            })
            this.$store.dispatch('member/storeClubName',club.clubName);
            this.$store.dispatch('member/storeClubMembers',selUsers);
            this.$router.push({name:'member.newClub',query:{clubId:club.id}})
        },
        async removeClub(club){
            this.isDeleting = true
            await deleteClub({id:club.id}).then(res=>{
                console.log(res.data)
                this.isDeleting = false
                let index = this.clubList.indexOf(club);
                if(index > -1){
                    this.clubList.splice(index,1)
                }
            }).catch(err=>{
                this.isDeleting = false
                console.log(err.response)
            })
        },
        addMember(club){

        },
        memberList(members){
            // let newString = members.replace()
            return members;
        }
    }
}
</script>

<style>

</style>