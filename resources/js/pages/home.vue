<template>
  <v-container>
    <v-row v-if="user.roleId == 1">
      <v-col v-for="(schoolItem, i) in schoolList" :key="i" cols="12" md="4" sm="6" class="hover-cursor-point" @click="goNewsOfSchool(schoolItem.id)">
        <v-card>
          <v-img :src="`${baseUrl}${schoolItem.imgUrl}`" alt="school" class="school-card-img"></v-img>
          <v-card-title>{{schoolItem.schoolName}}</v-card-title>
          <v-card-text>
            <div class="my-2 subtitle-1 d-flex align-center">
              <v-icon class="mr-2">mdi-account</v-icon>
              <span><strong>{{schoolItem.head}}</strong></span>
            </div>

            <div class="my-2 subtitle-1 d-flex align-center">
              <v-icon class="mr-2">mdi-phone-hangup</v-icon>
              <span><strong>{{schoolItem.phoneNum}}</strong></span>
            </div>

            <div>{{schoolItem.introduce}}</div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-else-if="user.roleId == 2">
      <v-col v-for="(lesson, i) in mySchoolLessonData" :key="i" cols="12" md="4" sm="6" class="hover-cursor-point" @click="goNewsOfClass(lesson)">
        <v-card>
          <v-img :src="`${baseUrl}${lesson.imgUrl}`" alt="school" class="school-card-img"></v-img>
          <v-card-title>{{lesson.lessonName}} - {{lesson.gradeName}}</v-card-title>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-else>
      <v-col cols="12" md="4" sm="6" @click="goNewsOfClass(myLessonData)" class="hover-cursor-point">
        <v-card>
          <v-img :src="`${baseUrl}${myLessonData.imgUrl}`" alt="school" class="school-card-img"></v-img>
          <v-card-title>{{myLessonData.lessonName}} - {{myLessonData.gradeName}}</v-card-title>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script> 
import { mapGetters } from 'vuex'
import { getSchool } from '~/api/school'
export default {
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    baseUrl: window.Laravel.base_url,
    schoolList : [],
    isLoadingSchoolData : false,
    mySchoolLessonData: [],
    myLessonData:{}
  }),

  computed:{
    ...mapGetters({
      user : 'auth/user',
      schoolTree : 'schooltree/schoolData'
    })
  },

  async created(){
    if(this.user.roleId == 1){
      this.isLoadingSchoolData = true;
      getSchool()
        .then((res) => {
          this.schoolList = res.data;
          this.isLoadingSchoolData = false;
        }).catch((err) => {
          console.log(err);
          this.isLoadingSchoolData = false;
        });
    }
    else if (this.user.roleId == 2){
      let myschoolData = {}
      this.schoolTree.map(x=>{
        if(this.user.schoolId == x.id){
          myschoolData = x;
        }
      })
      myschoolData.grades.map(grade=>{
        grade.lessons.map(lesson=>{
          lesson["gradeName"] = grade.gradeName;
          this.mySchoolLessonData.push(lesson);
        })
      })

    }
    else{
      this.schoolTree.map(school=>{
        school.grades.map(grade=>{
          grade.lessons.map(lesson=>{
            if(this.user.lessonId == lesson.id){
              this.myLessonData = lesson;
              this.myLessonData["gradeName"] = grade.gradeName;
            }
          })
        })
      })
    }
  },

  methods:{
    goNewsOfSchool(schoolId){
      this.$router.push({name: 'schoolSpace', params:{schoolId: schoolId}});
    },
    goNewsOfClass(lesson){
      this.$router.push({name: 'classSpace', params:{schoolId: lesson.schoolId, gradeId: lesson.gradeId, lessonId: lesson.id}});
    }
  }
}
</script>
