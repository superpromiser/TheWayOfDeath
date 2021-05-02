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
        <div class="px-10">
            <v-divider light></v-divider>
        </div>
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
        <div class="px-10">
            <v-divider light></v-divider>
        </div>
        <div v-if="clubMembers" v-for="member in clubMembers" :key="member.id" class="px-10">
            <v-row class="py-2">
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
import  {createClub} from '~/api/group'
export default {
    data:()=>({
        clubName:"",
        newClub:false,
        isSubmit:false,
        lang,
    }),
    computed:{
        ...mapGetters({
            clubMembers:'member/clubMembers'
        })
    },
    created(){
        this.newClub = true
        console.log("this.clubMembers",this.clubMembers)
    },
    computed:{
        currentPath(){
            return this.$route
        }
    },
    methods:{
        selStudent(){
            this.$router.push({name:"classSpace.contact"})
        },
        async submit(){
            console.log(this.clubMembers)
            if(this.clubName.trim() == ''){
                return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
            }
            if(this.clubMembers.length == 0){
                return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
            }
            let members = [];
            this.clubMembers.map(member=>{
                members.push(member.id)
            })
            this.isSubmit = true
            await createClub({
                clubName:this.clubName,
                members:members,
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
</script>

<style>

</style>