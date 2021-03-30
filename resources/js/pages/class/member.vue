<template>
  <v-container>
      <v-row>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);" @click="action('add')">
            <v-card-text>
              <span>邀请成员</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);" @click="action('invite')">
            <v-card-text>
              <span>移除成员</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);" @click="action('application')">
            <v-card-text>
              <span>申请</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);" @click="action('import')">
            <v-card-text>
              <span>导入</span>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-row >
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);" @click="action('group')">
            <v-card-text>
              <span>小组</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);" @click="action('seat')">
            <v-card-text>
              <span>座位</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);" @click="action('studentId')">
            <v-card-text>
              <span>学号</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
        </v-col>
        <v-col></v-col>
      </v-row>
      <v-row v-if="isLoading">
        <v-col>
          {{lang.noData}}
        </v-col>
      </v-row>
      <v-row v-else>
        <v-col cols=12>
          老师
          <v-divider></v-divider>
        </v-col>
        <v-col v-for="user in userList.teachers" :key="user.id"  cols="12" sm="6" md="4" lg="2" @click="selMember(user)" class="hover-cursor-point">
          <v-card>
            <div class="mx-auto text-center">
              <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="primary" size="60" class="ma-5">
                  <span class="white--text headline">{{user.name[0]}}</span>
              </v-avatar>
              <v-avatar v-else
                size="60"
                class="ma-5"
              >
                <v-img :src="user.avatar"></v-img>
              </v-avatar>
              <v-list>
                <v-list-item-content>
                  <v-list-item-title v-text="user.name"></v-list-item-title>
                </v-list-item-content>
                <v-list-item-content>
                  <v-list-item-title v-text="pnEncrypt(user.phoneNumber)"></v-list-item-title>
                </v-list-item-content>
              </v-list>
            </div>
            
          </v-card>
        </v-col>
        <v-col cols=12>
          学生
          <v-divider></v-divider>
        </v-col>
        <v-col v-for="user in userList.students" :key="user.id"  cols="12" sm="6" md="4" lg="2" @click="selMember(user)" class="hover-cursor-point">
          <v-card>
            <div class="mx-auto text-center">
              <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="primary" size="60" class="ma-5">
                  <span class="white--text headline">{{user.name[0]}}</span>
              </v-avatar>
              <v-avatar v-else
                class="ma-5"
                size="60"
              >
                <v-img :src="user.avatar"></v-img>
              </v-avatar>
              <v-list flat>
                <v-list-item-content>
                  <v-list-item-title v-text="user.name"></v-list-item-title>
                </v-list-item-content>
                <v-list-item-content>
                  <v-list-item-title v-text="pnEncrypt(user.phoneNumber)"></v-list-item-title>
                </v-list-item-content>
              </v-list>
            </div>
            
          </v-card>
        </v-col>
        <v-col cols=12>
          家长
          <v-divider></v-divider>
        </v-col>
        <v-col v-for="user in userList.parents" :key="user.id"  cols="12" sm="6" md="4" lg="2" @click="selMember(user)" class="hover-cursor-point">
          <v-card>
            <div class="mx-auto text-center" >
              <v-avatar v-if="user.name !== '' && user.avatar == '/'" color="primary" size="60" class="ma-5">
                  <span class="white--text headline">{{user.name[0]}}</span>
              </v-avatar>
              <v-avatar v-else
                size="60"
                class="ma-5"
              >
                <v-img :src="user.avatar"></v-img>
              </v-avatar>
              <v-list flat>
                <v-list-item-content>
                  <v-list-item-title v-text="user.name"></v-list-item-title>
                </v-list-item-content>
                <v-list-item-content>
                  <v-list-item-title v-text="pnEncrypt(user.phoneNumber)"></v-list-item-title>
                </v-list-item-content>
              </v-list>
            </div>
            
          </v-card>
        </v-col>
      </v-row>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import {getUserByRole} from '~/api/user'
export default {
  data:() => ({
    lang,
    userList:null,
    isLoading:false
  }),
  computed:{
    currentPath(){
      return this.$route
    }
  },
  async created(){
    this.isLoading = true
    await getUserByRole({schoolId:this.currentPath.params.schoolId,lessonId:this.currentPath.params.lessonId}).then(res=>{
      this.isLoading = false
      console.log(res.data)
      this.userList = res.data

    }).catch(err=>{
      console.log(err.response)
    })
  },
  methods:{
    action(type){
      switch(type){
        case 'add':
          this.$router.push({name:'classSpace.addMember',params:{schoolId:this.currentPath.params.schoolId,gradeId:this.currentPath.params.gradeId,lessonId:this.currentPath.params.lessonId}});
          break;
        case 'invite':
          this.$router.push({name:'classSpace.inviteMember',params:{schoolId:this.currentPath.params.schoolId,gradeId:this.currentPath.params.gradeId,lessonId:this.currentPath.params.lessonId}});
          break;
        case 'application':
          this.$router.push({name:'classSpace.appliMember', params:{schoolId:this.currentPath.params.schoolId,gradeId:this.currentPath.params.gradeId,lessonId:this.currentPath.params.lessonId}});
          break;
        case 'import':
          this.$router.push({name:'classSpace.importMember', params:{schoolId:this.currentPath.params.schoolId,gradeId:this.currentPath.params.gradeId,lessonId:this.currentPath.params.lessonId}});
          break;
        case 'group':
          this.$router.push({name:'classSpace.club', params:{schoolId:this.currentPath.params.schoolId,gradeId:this.currentPath.params.gradeId,lessonId:this.currentPath.params.lessonId}});
          break;
        case 'seat':
          this.$router.push({name:'classSpace.seatMember', params:{schoolId:this.currentPath.params.schoolId,gradeId:this.currentPath.params.gradeId,lessonId:this.currentPath.params.lessonId}});
          break;
        case 'studentId':
          this.$router.push({name:'classSpace.studentIdMember', params:{schoolId:this.currentPath.params.schoolId,gradeId:this.currentPath.params.gradeId,lessonId:this.currentPath.params.lessonId}});
          break;
        default:
          break;
      }
    },
    selMember(user){
      console.log(user)
      this.$router.push({name:'schoolSpace.memProfile',params:{userId:user.id}});
    }
  }
}
</script>

<style>

</style>