<template>
  <v-container class="pa-0">
      <div v-if="newClub == true">
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
                    <h2>new club</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                    <v-btn
                        tile
                        dark
                        color="#7879ff"
                        :loading="isSubmit"
                        @click="submit"
                    >
                        {{ lang.submit }}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-row class="px-10 py-5">
            <v-col cols="12">
                <v-text-field solo label="club name" hide-details dense v-model="clubName"></v-text-field>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <v-row @click="selStudent" class="hover-cursor-point px-10 py-5">
            <v-col cols="6">
                student
            </v-col>
            <v-col cols="6" class="text-right">
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-divider light></v-divider>
        <div v-for="member in clubMembers" :key="member.id">
            <v-row class="py-2 px-10">
                <v-col cols="12" md="4">
                    {{member.name}}
                </v-col>
                <v-col cols="12" md="4"> 性别：{{ transGender(member.gender) }} </v-col>
                <v-col cols="12" md="4" class="text-right"> 手机号码：{{ pnEncrypt(member.phoneNumber) }} </v-col>
            </v-row>
            <v-divider light></v-divider>
        </div>
      </div>
      <div v-else>
          <router-view></router-view>
      </div>
  </v-container>
</template>

<script>
import {mapGetters} from 'vuex'
import lang from '~/helper/lang.json'
import  {createClub,updateClub} from '~/api/group'
export default {
    data:()=>({
        clubName:"",
        newClub:false,
        isSubmit:false,
        lang,
    }),
    created(){
        // if(this.cName == '' || this.clubMembers.length == 0){
        //     this.$router.push({name:'classSpace.club'})
        // }
        this.newClub = true
        this.clubName = this.cName
        console.log(this.clubMembers,"this.clubMembers")
    },
    computed:{
        currentPath(){
            return this.$route
        },
        ...mapGetters({
            clubMembers:'member/clubMembers',
            cName:'member/clubName'
        })
    },
    methods:{
        selStudent(){
            this.$store.dispatch('member/storeClubName',this.clubName);
            if(this.currentPath.query.clubId){
                this.$router.push({name:"classSpace.contact",query:{clubId:this.currentPath.query.clubId}})
            }else{
                this.$router.push({name:"classSpace.contact"})
            }
            
        },
        async submit(){
            // console.log(this.clubMembers)
            // console.log('cName',this.cName)
            // return
            
            if(this.clubName.trim() == ''){
                return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
            }
            if(this.clubMembers.length == 0){
                return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
            }
            let memberNames = [];
            this.clubMembers.map(member=>{
                memberNames.push(member.name)
            })
            let memberIds = [];
            this.clubMembers.map(member=>{
                memberIds.push(member.id)
            })
            this.isSubmit = true
            if(this.currentPath.query.clubId){
                console.log('edit mode')
                await updateClub({
                    clubId:this.currentPath.query.clubId,
                    clubName:this.clubName,
                    memberNames:memberNames,
                    memberIds:memberIds,
                    schoolId:this.currentPath.params.schoolId,
                    lessonId:this.currentPath.params.lessonId
                }).then(res=>{
                    console.log(res.data)
                    this.$router.push({name:'classSpace.club'})
                })
            }else{
                await createClub({
                clubName:this.clubName,
                memberNames:memberNames,
                memberIds:memberIds,
                schoolId:this.currentPath.params.schoolId,
                lessonId:this.currentPath.params.lessonId
                }).then(res=>{
                    console.log(res.data)
                    this.isSubmit = false
                    return this.$router.push({name:"classSpace.club"})
                }).catch(err=>{
                    console.log(err.response)
                    this.isSubmit = false
                })
            }
        }
    }
}
</script>

<style>

</style>