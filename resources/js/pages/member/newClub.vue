<template>
  <v-container>
      <div v-if="newClub == true">
        <v-row>
            <v-col cols="12">
                <v-text-field solo label="club name" hide-details dense v-model="clubName"></v-text-field>
            </v-col>
        </v-row>
        <v-row @click="selStudent" class="hover-cursor-point">
            <v-col cols="6">
                student
            </v-col>
            <v-col cols="6" class="text-right">
                <v-icon>
                    mdi-chevron-right
                </v-icon>
            </v-col>
        </v-row>
        <v-row>
            <v-col class="text-right">
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
      </div>
      <div v-else>
          <router-view></router-view>
      </div>
  </v-container>
</template>

<script>
import {mapGetters} from 'vuex'
import lang from '~/helper/lang.json'
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
    methods:{
        selStudent(){
            this.$router.push({name:"classSpace.contact"})
        },
        submit(){
            console.log(this.clubMembers)
        }
    }
}
</script>

<style>

</style>