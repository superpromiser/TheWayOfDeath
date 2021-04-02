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
          <h2 class="ml-3">{{selectedItem.label}}</h2>
        </v-col>
        <v-col cols="12" class="mo-glow-small-shadow mt-5 d-flex" >
          <transition name="page" mode="out-in">
            <v-text-field
              v-if="isSearching" key="1"
              class="mo-glow-v-text"
              solo
              clearable
              v-model="searchKeyword"
              label="请输入您的搜索词"
              append-icon="mdi-check"
              @click:append="onSearch"
              prepend-inner-icon="mdi-magnify"
              hide-details
            ></v-text-field>
            <v-select
              v-else key="2"
              solo
              :items="schoolListDropdownItem"
              :menu-props="{ top: false, offsetY: true }"
              item-text="label"
              label="栏目"
              hide-details
              class="mo-glow-v-select"
              v-model="selectedItem"
              @change="onSelectSchoolItem"
            ></v-select>
          </transition>
          <transition name="page" mode="out-in">
          <v-avatar v-if="isSearching" key="3" class="mo-glow-small-shadow ml-3" @click="onFalseSearching">
            <v-icon color="#7879ff">
              mdi-close
            </v-icon>
          </v-avatar>
          <v-avatar v-else key="4" class="mo-glow-small-shadow ml-3" @click="isSearching = true">
            <v-icon color="#7879ff">
              mdi-magnify
            </v-icon>
          </v-avatar>
          </transition>
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
              <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                <div class="text-center">
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" width="30" height="30"></v-img>
                  <span class="font-size-0-75 pt-2"> 首页</span>
                </div>
              </v-card>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                <div class="text-center">
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" width="30" height="30"></v-img>
                  <span class="font-size-0-75 pt-2"> 首页</span>
                </div>
              </v-card>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                <div class="text-center">
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" width="30" height="30"></v-img>
                  <span class="font-size-0-75 pt-2"> 首页</span>
                </div>
              </v-card>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                <div class="text-center">
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" width="30" height="30"></v-img>
                  <span class="font-size-0-75 pt-2"> 首页</span>
                </div>
              </v-card>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                <div class="text-center">
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" width="30" height="30"></v-img>
                  <span class="font-size-0-75 pt-2"> 首页</span>
                </div>
              </v-card>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3" >
              <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                <div class="text-center">
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" width="30" height="30"></v-img>
                  <span class="font-size-0-75 pt-2"> 首页</span>
                </div>
              </v-card>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" class="mt-5 d-flex pa-0 px-3 align-center">
          <div class="trapezoid position-relative"></div>
          <div class="parallelogram ml-4"></div>
          <div class="ml-4">
            something
          </div>
        </v-col>
      </v-row>
      <v-row class="ma-0 mt-5 mb-16">
        <v-col cols="12" class="pa-0 d-flex align-center">
          <v-avatar tile class="mo-glow-small-shadow" size="40" >
            <v-icon color="#7879ff">
              mdi-school
            </v-icon>
          </v-avatar>
          <h3 class="ml-3">something</h3>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 报名  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item link >
                        <v-list-item-title class="px-2">delete</v-list-item-title>
                      </v-list-item>
                      <v-list-item link >
                        <v-list-item-title class="px-2">fix to top</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
            </v-row>
          </v-card>
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 报名  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item link >
                        <v-list-item-title class="px-2">delete</v-list-item-title>
                      </v-list-item>
                      <v-list-item link >
                        <v-list-item-title class="px-2">fix to top</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
            </v-row>
          </v-card>
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 报名  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item link >
                        <v-list-item-title class="px-2">delete</v-list-item-title>
                      </v-list-item>
                      <v-list-item link >
                        <v-list-item-title class="px-2">fix to top</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
            </v-row>
          </v-card>
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 报名  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item link >
                        <v-list-item-title class="px-2">delete</v-list-item-title>
                      </v-list-item>
                      <v-list-item link >
                        <v-list-item-title class="px-2">fix to top</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
            </v-row>
          </v-card>
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 报名  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item link >
                        <v-list-item-title class="px-2">delete</v-list-item-title>
                      </v-list-item>
                      <v-list-item link >
                        <v-list-item-title class="px-2">fix to top</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
              </v-col>
              <v-col cols="12" class="d-flex align-center pt-2 pl-8">
                <v-icon medium color="primary" class="mr-1">mdi-account </v-icon>
                <p class="mb-0 mr-5">sammie</p>
                <v-icon medium color="primary" class="mr-1">mdi-clock-outline </v-icon>
                <p class="mb-0">2011/12/3</p>
              </v-col>
            </v-row>
          </v-card>
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
    schoolListDropdownItem: [],
    selectedItem : {},
    myLessonData:{},
    isSearching: false,
    searchKeyword: '',
    isSchoolSpace: true,
  }),

  computed:{
    ...mapGetters({
      user : 'auth/user',
      schoolTree : 'schooltree/schoolData',
      selectedSchoolItem : 'mo/selectedSchoolItem'
    })
  },

  async created(){
    console.log(this.schoolTree);
    if(this.user.roleId == 1){
      this.schoolList = this.schoolTree;
      this.schoolTree.map((school, schoolIndex)=>{
        let schoolObj = {
          label : school.schoolName,
          schoolId : school.id,
          type : "school",
          value : 's'+schoolIndex
        }
        this.schoolListDropdownItem.push(schoolObj)
        let dividerObj = {
          divider : true
        }
        this.schoolListDropdownItem.push(dividerObj);
        console.log("***", this.schoolListDropdownItem)
        school.grades.map( (grade,gradeIndex) =>{
            let gradeObj = {
                header : grade.gradeName,
            }
            this.schoolListDropdownItem.push(gradeObj);
            grade.lessons.map( (lesson, lessonIndex) =>{
                let lessonObj = {
                    schoolId : school.id,
                    lessonId : lesson.id,
                    gradeId : grade.id,
                    label : lesson.lessonName,
                    type: "lesson",
                    value: 'l'+schoolIndex+gradeIndex+lessonIndex
                }
                this.schoolListDropdownItem.push(lessonObj);
            } )
            let dividerObj = {
                divider : true
            }
            this.schoolListDropdownItem.push(dividerObj);
        } )
      })
    }
    else if (this.user.roleId == 2){
      let myschoolData = {}
      this.schoolTree.map((x, schoolIndex)=>{
        if(this.user.schoolId == x.id){
          myschoolData = x;
          let schoolObj = {
            label : x.schoolName,
            schoolId : x.id,
            type : "school",
            value : 's'+schoolIndex
          }
          this.schoolListDropdownItem.push(schoolObj)
        }
      })
      myschoolData.grades.map((grade, gradeIndex)=>{
        let gradeObj = {
            header : grade.gradeName,
          }
          this.schoolListDropdownItem.push(gradeObj)
        grade.lessons.map((lesson, lessonIndex)=>{
          lesson["gradeName"] = grade.gradeName;
          this.mySchoolLessonData.push(lesson);
          let lessonObj = {
            lessonId : lesson.id,
            gradeId : grade.id,
            schoolId : myschoolData.id,
            label : lesson.lessonName,
            type : "lesson",
            value: 'l'+gradeIndex+lessonIndex
          }
          this.schoolListDropdownItem.push(lessonObj)
        })
      })

    }
    else{
      let myschoolData = {}
      this.schoolTree.map((school, schoolIndex)=>{
        if(this.user.schoolId == school.id){
          myschoolData = school;
          let schoolObj = {
            label : school.schoolName,
            schoolId : school.id,
            type : "school",
            value : 's'+schoolIndex
          }
          this.schoolListDropdownItem.push(schoolObj)
        }
        myschoolData.grades.map((grade, gradeIndex)=>{
          grade.lessons.map((lesson, lessonIndex)=>{
            if(this.user.lessonId == lesson.id){
              this.myLessonData = lesson;
              this.myLessonData["gradeName"] = grade.gradeName;
            }
          })
        })
      })
      let lessonObj = {
          lessonId : this.myLessonData.id,
          gradeId : this.myLessonData.gradeId,
          label : this.myLessonData.lessonName,
          schoolId : myschoolData.id,
          type: "lesson",
          value: 'l'+this.myLessonData.id
      }
      this.schoolListDropdownItem.push(lessonObj)
    }
    if(this.selectedSchoolItem == null){
      this.selectedItem = this.schoolListDropdownItem[0];
      this.$store.dispatch('mo/onSelectedSchoolItem', this.selectedItem);
    }
    else  {
      this.selectedItem = this.selectedSchoolItem
    }
  },

  methods:{
    goNewsOfSchool(schoolId){
      this.$router.push({name: 'schoolSpace', params:{schoolId: schoolId}});
    },
    goNewsOfClass(lesson){
      this.$router.push({name: 'classSpace', params:{schoolId: lesson.schoolId, gradeId: lesson.gradeId, lessonId: lesson.id}});
    },
    onSelectSchoolItem(val){
      console.log(val);
      console.log(this.schoolListDropdownItem);
      if(val == this.selectedItem.value){
        return
      }
      else{
        this.schoolListDropdownItem.map( x =>{
          if(x.value == val){
            this.selectedItem = x;
            if(this.selectedItem.type == "school"){
              this.isSchoolSpace = true;
            }
            else{
              this.isSchoolSpace = false;
            }
            this.$store.dispatch('mo/onIsSchoolSpace', this.isSchoolSpace);
            this.$store.dispatch('mo/onSelectedSchoolItem', this.selectedItem);
          }
        })
      }
    },
    onSearch(){
      console.log(this.searchKeyword)
    },
    onFalseSearching(){
      this.isSearching = false;
      this.searchKeyword = '';
    }
  }
}
</script>
