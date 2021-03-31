<template>
  <v-container>
    <v-container v-if="$isMobile()" class="pa-0">
      <v-row class="ma-0">
        <v-col class="mo-glow-small-shadow d-flex align-center" cols="12">
          <v-avatar tile class="mo-glow-small-shadow" >
            <v-icon color="#7879ff">
              mdi-school
            </v-icon>
          </v-avatar>
          <h2 class="ml-3">something</h2>
        </v-col>
        <v-col cols="12" class="mo-glow-small-shadow mt-5 d-flex">
          <!-- <v-select
            solo
            :items="typeItem"
            :menu-props="{ top: false, offsetY: true }"
            item-text="label"
            v-model="campusData.camposeCategory"
            label="栏目"
            hide-details
          ></v-select> -->
          <v-select
            solo
            :items="schoolList"
            :menu-props="{ top: false, offsetY: true }"
            item-text="label"
            label="栏目"
            hide-details
            class="mo-glow-v-select"
          ></v-select>

          <v-avatar class="mo-glow-small-shadow ml-3" >
            <v-icon color="#7879ff">
              mdi-magnify
            </v-icon>
          </v-avatar>
        </v-col>
        <v-col cols="12" class="mt-5 pa-0">
          <carousel :autoplay="true" :nav="false" :items="1" :margin="10" :loop="true" :dots="false" :autoplaySpeed="5000">
            <img :src="`${baseUrl}/asset/img/class/1.jpeg`" alt="carousel" class="mo-home-carousel-img" />
            <img :src="`${baseUrl}/asset/img/class/2.jpg`" alt="carousel" class="mo-home-carousel-img" />
            <img :src="`${baseUrl}/asset/img/class/3.png`" alt="carousel" class="mo-home-carousel-img" />
            <img :src="`${baseUrl}/asset/img/class/4.jpg`" alt="carousel" class="mo-home-carousel-img" />
            <img :src="`${baseUrl}/asset/img/class/5.jpg`" alt="carousel" class="mo-home-carousel-img" />
          </carousel>
        </v-col>
        <v-col cols="12" class="mt-5 pa-0 d-flex justify-space-between">
          <v-row class="ma-0 pa-0 pb-3 mo-glow">
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-btn tile class="mo-glow px-0 inline-btn" height="60">
                <v-icon color="#7879ff" top>
                  mdi-school
                </v-icon>
                <span class="font-size-0-75"> 首页</span>
              </v-btn>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-btn tile class="mo-glow px-0 inline-btn" height="60">
                <v-icon color="#7879ff">
                  mdi-school
                </v-icon>
                <span class="font-size-0-75"> 首页</span>
              </v-btn>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-btn tile class="mo-glow px-0 inline-btn" height="60">
                <v-icon color="#7879ff">
                  mdi-school
                </v-icon>
                <span class="font-size-0-75"> 首页</span>
              </v-btn>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-btn tile class="mo-glow px-0 inline-btn" height="60">
                <v-icon color="#7879ff">
                  mdi-school
                </v-icon>
                <span class="font-size-0-75"> 首页</span>
              </v-btn>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-btn tile class="mo-glow px-0 inline-btn" height="60">
                <v-icon color="#7879ff">
                  mdi-school
                </v-icon>
                <span class="font-size-0-75"> 首页</span>
              </v-btn>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-btn tile class="mo-glow px-0 inline-btn" height="60">
                <v-icon color="#7879ff">
                  mdi-school
                </v-icon>
                <span class="font-size-0-75"> 首页</span>
              </v-btn>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" class="mt-5 ">
          <span class="parallelogram"></span>
        </v-col>
      </v-row>
    </v-container>

    <v-container v-else class="pa-0">
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
  </v-container>
</template>

<script> 
import { mapGetters } from 'vuex'
import { getSchool } from '~/api/school'
import carousel from 'v-owl-carousel'
export default {
  middleware: 'auth',

  components:{
    carousel,
  },
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
