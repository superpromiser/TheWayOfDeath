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
                    <h2>选择成员</h2>
                </v-col>
                <v-col cols="12" md="4" class="d-flex align-center justify-end">
                <v-text-field
                    solo
                    label="搜索"
                    prepend-inner-icon="mdi-magnify"
                    v-model="search"
                    hide-details
                    dense
                    class="mx-2"
                ></v-text-field>
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
        <v-row class="py-5 px-10">
            <v-col>
                <v-checkbox
                    v-model="checkAll"
                    label="全选"
                    class="member-chk"
                    style="height:20px !important"
                    @click="selectAll"
                ></v-checkbox>
            </v-col>
        </v-row>
        <v-divider light class="thick-border"></v-divider>
        <div v-if="isLoading == true" class="d-flex justify-center align-center py-16">
            <v-progress-circular
                indeterminate
                color="#7879ff"
            ></v-progress-circular>
        </div>
        <div v-for="(user, index) in filteredList" :key="index" v-else>
            <v-row class="py-5 px-10 justify-space-between">
                <v-col cols="12" md="4">
                    <v-checkbox
                    v-model="user.checkbox"
                    :label="user.name"
                    class="member-chk"
                    @click="selectMem(user)"
                    ></v-checkbox>
                </v-col>
                <v-col cols="12" md="4"> 性别：{{ transGender(user.gender) }} </v-col>
                <v-col cols="12" md="4" class="text-right"> 手机号码：{{ pnEncrypt(user.phoneNumber) }} </v-col>
            </v-row>
            <v-divider light class="thick-border"></v-divider>
        </div>
    </v-container>
</template>

<script>
import {getGroupMember,deleteGroupMember} from '~/api/group';
import lang from "~/helper/lang.json";
import {mapGetters} from 'vuex';
export default {
    data: () => ({
        checkAll: false,
        userList: [],
        lang,
        isSubmit: false,
        selected: [],
        search:'',
        isLoading:false,
    }),
    computed: {
        currentPath() {
            return this.$route;
        },
        filteredList(){
            return this.userList.filter(user=>{
                return user.name.toLowerCase().includes(this.search.toLowerCase())
            })
        },
        ...mapGetters({
            selUsers:'member/clubMembers'
        })
    },
    async created(){
        console.log("------",this.selUsers)
        this.isLoading = true
        await getGroupMember({
            schoolId:this.currentPath.params.schoolId,
            lessonId: this.currentPath.params.lessonId,
            roleId:5,
        })
        .then(res => {
            console.log(res.data)
            res.data.map(user => {
                this.$set(user, "checkbox", false);
                this.selUsers.map(selUser=>{
                    if(user.id == selUser.id){
                        user.checkbox = true
                    }
                })
            });
            this.userList = res.data;
            this.isLoading = false
            console.log('+++++++',this.userList)
        })
        .catch(err => {
            console.log(err.response);
            this.isLoading = false
        });
    },
    methods:{
        selectAll() {
            console.log(this.checkAll);
            if (this.checkAll == false) {
                this.userList.map(user => {
                    user.checkbox = false;
                });
            } else {
                this.userList.map(user => {
                    user.checkbox = true;
                    console.log(user.checkbox);
                });
            }
        },
        selectMem(user) {
            console.log(this.userList);
            this.checkAll = true;
            this.userList.map(user => {
                if (user.checkbox == false) {
                    console.log(user.checkbox);
                    this.checkAll = false;
                }
            });
        },
        submit(){
            console.log(this.userList)
            let selUsers = []
            this.userList.map(user=>{
                if(user.checkbox == true){
                    selUsers.push(user)
                }
            })
            
            this.$store.dispatch('member/storeClubMembers',selUsers);
            if(this.currentPath.query.clubId){
                this.$router.push({name:'member.newClub',query:{clubId:this.currentPath.query.clubId}});
            }else{
                this.$router.push({name:'member.newClub'});    
            }
            
        }
    }
}
</script>

<style>

</style>