<template>
  <v-container class="pa-0">
    <v-container v-if="$isMobile()" class="pa-0" >
      <v-row class="ma-0">
        <v-col cols="12" class="d-flex align-center bg-secondary py-2" v-touch="{
          left: () => swipe('Left'),
          right: () => swipe('Right'),
        }">
          <transition name="page" mode="out-in">
            <v-text-field
              v-if="isSearching" key="1"
              solo
              clearable
              class="mo-select-gray-bg"
              v-model="searchKeyword"
              label="请输入您的搜索词"
              append-icon="mdi-check"
              @click:append="onSearch"
              prepend-inner-icon="mdi-magnify"
              hide-details
              color="#7879ff"
              dense 
            ></v-text-field>
            <v-select
              v-else key="2"
              solo
              class="mo-select-gray-bg"
              color="#7879ff"
              :items="schoolListDropdownItem"
              :menu-props="{ top: false, offsetY: true }"
              item-text="label"
              label="栏目"
              hide-details
              v-model="selectedItem"
              @change="onSelectSchoolItem"
              dense 
            ></v-select>
          </transition>
          <transition name="page" mode="out-in">
          <v-btn icon v-if="isSearching" key="3" class="ml-3" @click="onFalseSearching">
            <v-icon>
              mdi-close
            </v-icon>
          </v-btn>
          <v-btn icon plain v-else key="4" class="ml-3" @click="isSearching = true">
            <v-icon size="30">
              mdi-magnify
            </v-icon>
          </v-btn>
          </transition>
        </v-col>
        <v-col cols="12" class="" >
          <carousel v-if="isSchoolSpace" :key="bannerKey" class="position-relative owl-cus-con" :nav="false" :items="1" :margin="10" :loop="true"  :autoplaySpeed="5000">
            <img :src="`${baseUrl}${story.schoolstory.content.imgUrl[0].path}`" v-for="story in bannerStoryList" :key="story.id" alt="carousel" class="mo-home-carousel-img"  @click="showDetailSchoolStory(story)" />
          </carousel>
          <carousel v-else class="position-relative owl-cus-con" :nav="false" :items="1" :margin="10" :loop="true"  :autoplaySpeed="5000">
            <img :src="`${baseUrl}${story.classstory.content.imgUrl[0].path}`" v-for="story in bannerStoryList" :key="story.id" alt="carousel" class="mo-home-carousel-img" @click="showDetailClassStory(story)" />
          </carousel>
        </v-col>
        <v-col cols="12" class="pa-0">
            <v-row v-if="isLoadingPostItems" class="ma-0 d-flex justify-center py-5 mb-3" >
              <v-progress-circular
                indeterminate
                color="#7879ff"
              ></v-progress-circular>
            </v-row>
            <!-- <carousel class="mb-3" v-else-if="chooseableItemGroup.length == 0" :key="carouselKey" :nav="false" :items="5" :loop="false" :dots="false"> -->
            <carousel class="mb-3" v-else-if="chooseableItemGroup.length == 0" :nav="false" :items="5" :loop="false" :dots="false">
              <v-col class="pa-0 d-flex justify-center">
                <v-sheet tile class=" d-flex justify-center align-center" @click="openAddItemDialog">
                  <div class="text-center">
                    <v-img :src="`${baseUrl}/asset/img/appIcon/others/全部.png`" alt="postItem" width="50" height="50" class="mx-auto"></v-img>
                    <p class="font-size-0-75 pt-1 mb-0">添加</p>
                  </div>
                </v-sheet>
              </v-col>
            </carousel>
            <carousel class="mb-3" v-else-if="chooseableItemGroup.length > 0" :key="carouselKey" :nav="false" :items="5" :loop="false" :dots="false">
              <v-col class="pa-0 d-flex justify-center" v-for="(chooseableItem, i) in chooseableItemGroup" :key="i">
                <v-sheet tile class=" d-flex justify-center align-center">
                  <div class="text-center">
                    <v-img :src="`${baseUrl}${chooseableItem.imgUrl}`" alt="postItem" width="50" height="50" class="mx-auto"></v-img>
                    <p class="font-size-0-75 pt-1 mb-0">{{chooseableItem.title}}</p>
                  </div>
                </v-sheet>
              </v-col>
              <v-col class="pa-0 d-flex justify-center">
                <v-sheet tile class=" d-flex justify-center align-center" @click="openAddItemDialog">
                  <div class="text-center">
                    <v-img :src="`${baseUrl}/asset/img/appIcon/others/全部.png`" alt="postItem" width="50" height="50" class="mx-auto"></v-img>
                    <p class="font-size-0-75 pt-1 mb-0">添加</p>
                  </div>
                </v-sheet>
              </v-col>
            </carousel>
            <v-divider class="mx-3" light></v-divider>

          <v-dialog v-model="addItemDialog" width="100%" max-width="500" scrollable>
              <v-card>
                  <v-card-title class="title"> 添加 </v-card-title>
                  <v-card-text class="px-0" style="height: 300px; ">
                      <v-list >
                        <v-list-item-group
                          v-model="selectedItemGroup"
                          multiple
                          scrollable
                        >
                          <template v-for="(item, i) in selectedTypeItemGroup">
                            <v-list-item
                              :key="i"
                              :value="item.title"
                              active-class="deep-purple--text text--accent-2"
                            >
                              <template v-slot:default="{ active }">
                                <v-list-item-avatar size="30">
                                  <v-img :src="`${baseUrl}${item.imgUrl}`"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                  <v-list-item-title v-text="item.title"></v-list-item-title>
                                </v-list-item-content>

                                <v-list-item-action>
                                  <v-checkbox
                                    :input-value="active"
                                    color="deep-purple accent-2"
                                  ></v-checkbox>
                                </v-list-item-action>
                              </template>
                            </v-list-item>
                          </template>
                        </v-list-item-group>
                      </v-list>
                  </v-card-text>
                  
                  <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                      text
                      color="#49d29e"
                      @click="closeAddItemDialog "
                  >
                      {{lang.cancel}}
                  </v-btn>
                  <v-btn
                      text
                      color="#49d29e"
                      @click="saveSelectedItemGroup "
                  >
                      {{lang.ok}}
                  </v-btn>
                  </v-card-actions>
              </v-card>
          </v-dialog>
        </v-col>
        
        <v-col cols="12" class="d-flex px-3 align-center mo-home-tag-bg-img position-relative" v-touch="{
          left: () => swipe('Left'),
          right: () => swipe('Right'),
        }">
          <img :src="`${baseUrl}/asset/img/mo-tag-bg-img.svg`"  alt="">
          <p class="mb-0 ml-4 font-size-0-75">学校要闻</p>
        </v-col>
      </v-row>
      <v-divider class="thick-border" light></v-divider>
      <v-row class="ma-0 pt-1" v-touch="{
        left: () => swipe('Left'),
        right: () => swipe('Right'),
      }">
        <v-col cols="12" class="d-flex align-center pb-0">
          <p class="mb-0 pl-3 border-left-5">学校要闻</p>
        </v-col>
      </v-row>
      <v-container v-if="isSchoolSpace" class="pb-16" v-touch="{
        left: () => swipe('Left'),
        right: () => swipe('Right'),
      }" >
        <v-row class="ma-0" v-for="story in bodyStoryList" :key="story.id" @click="showDetailSchoolStory(story)">
          <v-col cols="7" class="pl-0 d-flex align-start flex-column">
            <p class="mb-auto font-weight-bold d-inline-block text-truncate w-100">{{story.schoolstory.content.text}}</p>
            <div class="d-flex align-center justify-space-between w-100">
              <p class="mb-0">{{TimeViewYMD(story.created_at)}}</p>
              <p class="mb-0">{{story.users.name}}</p>
            </div>
          </v-col>
          <v-col cols="5" class="pr-0">
            <v-img :src="`${baseUrl}${story.schoolstory.content.imgUrl[0].path}`" height="100"></v-img>
          </v-col>
        </v-row>
        <v-divider light></v-divider>
      </v-container>
      <v-container v-else class="pb-16" v-touch="{
        left: () => swipe('Left'),
        right: () => swipe('Right'),
      }">
        <v-row class="ma-0" v-for="story in bodyStoryList" :key="story.id" @click="showDetailClassStory(story)">
          <v-col cols="7" class="pl-0 d-flex align-start flex-column">
            <p class="mb-auto font-weight-bold">{{story.classstory.content.text}}</p>
            <div class="d-flex align-center justify-space-between w-100">
              <p class="mb-0">{{TimeViewYMD(story.created_at)}}</p>
              <p class="mb-0">{{story.users.name}}</p>
            </div>
          </v-col>
          <v-col cols="5" class="pr-0">
            <v-img :src="`${baseUrl}${story.schoolstory.content.imgUrl[0].path}`" height="100"></v-img>
          </v-col>
        </v-row>
        <v-divider light></v-divider>
      </v-container>
      
    </v-container>

    <v-container v-else class="">
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
import {getSchoolStoryMo} from '~/api/schoolStory'
import {getClassStory} from '~/api/classStory'
import {postChooseableSchoolItem,  postChooseableClassItem, getPostItem} from '~/api/user'
import carousel from 'v-owl-carousel';
import lang from '~/helper/lang.json'
export default {
  middleware: 'auth',

  components:{
    carousel,
  },
  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    lang,
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
    addItemDialog: false,
    chooseableItemGroup: [],
    selectedItemGroup: [],
    selectedItemSchoolGroup: [],
    selectedItemClassGroup: [],
    selectedTypeItemGroup: null,
    selectedItemGroupForSchoolDia: [],
    selectedItemGroupForClassDia: [],
    isLoadingPostItems: false,
    schoolSpaceItems:[
      {
        title : "问卷",
        imgUrl : "/asset/img/appIcon/基础沟通/问卷.png",
        path : "posts.questionnaire"
      },
      {
        title : "投票",
        imgUrl : "/asset/img/appIcon/基础沟通/投票.png",
        path : "posts.voting"
      },
      {
        title : "短信",
        imgUrl : "/asset/img/appIcon/基础沟通/短信.png",
        path : "posts.sms"
      },
      {
        title : "校园动态",
        imgUrl : "/asset/img/appIcon/校园文化/校园动态.png",
        path : "posts.campus"
      },
      {
        title : "公告",
        imgUrl : "/asset/img/appIcon/家校互动/公告.png",
        path : "posts.announcement"
      },
      {
        title : "分享",
        imgUrl : "/asset/img/appIcon/基础沟通/分享.png",
        path : "posts.share"
      },
      {
        title : "布告栏",
        imgUrl : "/asset/img/appIcon/others/布告栏.png",
        path : "posts.bulletinboard"
      },
      {
        title : "考勤",
        imgUrl : "/asset/img/appIcon/智能考勤/考勤.png",
        path : "something"
      },
      {
        title : "作业",
        imgUrl : "/asset/img/appIcon/家校互动/作业.png",
        path : "something"
      },
      {
        title : "通讯录",
        imgUrl : "/asset/img/appIcon/基础沟通/通讯录.png",
        path : "something"
      },
      {
        title : "家访",
        imgUrl : "/asset/img/appIcon/others/家访.png",
        path : "posts.homevisit"
      },
      {
        title : "报名",
        imgUrl : "/asset/img/appIcon/基础沟通/报名.png",
        path : "posts.regname"
      },
      {
        title : "请假",
        imgUrl : "/asset/img/appIcon/智能考勤/请假审批.png",
        path : "posts.vocation"
      },
    ],
    classSpaceItems:[
      {
        title : "问卷",
        imgUrl : "/asset/img/appIcon/基础沟通/问卷.png",
        path : "posts.Cquestionnaire"
      },
      {
        title : "投票",
        imgUrl : "/asset/img/appIcon/基础沟通/投票.png",
        path : "posts.Cvoting"
      },
      {
        title : "作业",
        imgUrl : "/asset/img/appIcon/家校互动/作业.png",
        path : "something"
      },
      {
        title : "习题",
        imgUrl : "/asset/img/icon/习题.png",
        path : "something"
      },
      {
        title : "家访",
        imgUrl : "/asset/img/appIcon/others/家访.png",
        path : "posts.Chomevisit"
      },
      {
        title : "通知",
        imgUrl : "/asset/img/icon/通知 拷贝.png",
        path : "posts.Cnotification"
      },
      {
        title : "评价",
        imgUrl : "/asset/img/icon/评价.png",
        path : "posts.Cevaluation"
      },
      {
        title : "表彰",
        imgUrl : "/asset/img/icon/表彰.png",
        path : "posts.Crecognition"
      },
      {
        title : "课表",
        imgUrl : "/asset/img/appIcon/智能考勤/课程表.png",
        path : "something"
      },
      {
        title : "相册",
        imgUrl : "/asset/img/appIcon/工具/相册.png",
        path : "posts.Calbum"
      },
      {
        title : "文件",
        imgUrl : "/asset/img/appIcon/基础沟通/文件.png",
        path : "file"
      },
    ],
    carouselKey: 0,
    bannerKey: 0,
    selectedStoryGroup: [],
    bannerStoryList: [],
    bodyStoryList: [],
  }),

  watch:{
  },

  computed:{
    ...mapGetters({
      user : 'auth/user',
      schoolTree : 'schooltree/schoolData',
      selectedSchoolItem : 'mo/selectedSchoolItem',
      selectedItemSchoolGroupStore : 'mo/selectedItemSchoolGroupStore',
      selectedItemClassGroupStore : 'mo/selectedItemClassGroupStore',
      selectedItemGroupForSchoolDiaStore : 'mo/selectedItemGroupForSchoolDiaStore',
      selectedItemGroupForClassDiaStore : 'mo/selectedItemGroupForClassDiaStore',
      schoolStoryList: 'mo/schoolStoryList',
      classStoryList: 'mo/classStoryList'
    }),

    
  },

  async created(){
    if(this.$isMobile() && this.schoolStoryList == null){
      let obj = {
        schoolId: this.user.schoolId,
        lessonId: this.user.lessonId
      }
      await getSchoolStoryMo(obj)
      .then((res) => {
        res.data.schoolStory.map(item=>{
          item.schoolstory.content = JSON.parse(item.schoolstory.content);
        });
        res.data.classStory.map(item=>{
          item.classstory.content = JSON.parse(item.classstory.content);
        });
        this.$store.dispatch('mo/onSchoolStoryList', res.data.schoolStory);
        this.$store.dispatch('mo/onClassStoryList', res.data.classStory);
        this.selectedStoryGroup =  JSON.parse(JSON.stringify(this.schoolStoryList))
        if(this.selectedStoryGroup.length < 6 ){
          this.bannerStoryList = this.selectedStoryGroup;
          this.bodyStoryList = [];
          this.bannerKey++;
        }
        else{
          this.bannerStoryList = this.selectedStoryGroup.splice(0, 5);
          this.bodyStoryList = this.selectedStoryGroup;
          this.bannerKey++;
        }
      }).catch((err) => {
        
      });
    }
    else{
      if(this.isSchoolSpace){
        this.selectedStoryGroup =  JSON.parse(JSON.stringify(this.schoolStoryList))
      }
      else{
        this.selectedStoryGroup =  JSON.parse(JSON.stringify(this.classStoryList))
      }
      if(this.selectedStoryGroup.length < 6 ){
        this.bannerStoryList = this.selectedStoryGroup;
        this.bodyStoryList = [];
        this.bannerKey++;
      }
      else{
        this.bannerStoryList = this.selectedStoryGroup.splice(0, 5);
        this.bodyStoryList = this.selectedStoryGroup;
        this.bannerKey++;
      }
    }
    if(this.selectedItemSchoolGroupStore !== null || this.selectedItemClassGroupStore !== null){
      if(this.selectedSchoolItem.type == "school"){
        this.chooseableItemGroup = this.selectedItemSchoolGroupStore;
        this.selectedItemGroup = this.selectedItemGroupForSchoolDiaStore;
      }
      else{
        this.chooseableItemGroup = this.selectedItemClassGroupStore;
        this.selectedItemGroup = this.selectedItemGroupForClassDiaStore;
      }
      
    }
    else{
      this.isLoadingPostItems = true;
      await getPostItem()
      .then((res) => {
        let schoolArr = JSON.parse(res.data.schoolItem);
        let classArr = JSON.parse(res.data.classItem);
        this.selectedItemGroupForSchoolDia = schoolArr;
        this.selectedItemGroupForClassDia = classArr;
        this.$store.dispatch('mo/onSelectedItemGroupForSchoolDiaStore', this.selectedItemGroupForSchoolDia);
        this.$store.dispatch('mo/onSelectedItemGroupForClassDiaStore', this.selectedItemGroupForClassDia);
        schoolArr.map(y=>{
          this.schoolSpaceItems.map(x=>{
            if(x.title == y){
              this.selectedItemSchoolGroup.push(x)
            }
          })
        })
        classArr.map(y=>{
          this.classSpaceItems.map(x=>{
            if(x.title == y){
              this.selectedItemClassGroup.push(x)
            }
          })
        })
      }).catch((err) => {
        
      });
      
      this.$store.dispatch('mo/onSelectedItemSchoolGroupStore', this.selectedItemSchoolGroup);
      this.$store.dispatch('mo/onSelectedItemClassGroupStore', this.selectedItemClassGroup);
      // if(this.selectedItemSchoolGroupStore == null && this.selectedItemClassGroupStore == null){
      // }
      this.chooseableItemGroup = this.selectedItemSchoolGroupStore;

      this.isLoadingPostItems = false;

      this.selectedItemGroup = this.selectedItemGroupForSchoolDia;
    }
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
    this.selectedTypeItemGroup = this.schoolSpaceItems;
  },

  methods:{
    goNewsOfSchool(schoolId){
      this.$router.push({name: 'schoolSpace', params:{schoolId: schoolId}});
    },
    goNewsOfClass(lesson){
      this.$router.push({name: 'classSpace', params:{schoolId: lesson.schoolId, gradeId: lesson.gradeId, lessonId: lesson.id}});
    },
    onSelectSchoolItem(val){
      this.carouselKey += 1
      if(val == this.selectedItem.value){
        return
      }
      else{
        this.schoolListDropdownItem.map( x =>{
          if(x.value == val){
            this.selectedItem = x;
            if(this.selectedItem.type == "school"){
              this.isSchoolSpace = true;
              this.selectedTypeItemGroup = this.schoolSpaceItems;
              this.selectedItemGroup = this.selectedItemGroupForSchoolDiaStore;
              this.chooseableItemGroup = this.selectedItemSchoolGroupStore;
              //story
              this.selectedStoryGroup = JSON.parse(JSON.stringify(this.schoolStoryList));
            }
            else{
              this.isSchoolSpace = false;
              this.selectedTypeItemGroup = this.classSpaceItems;
              this.selectedItemGroup = this.selectedItemGroupForClassDiaStore;
              this.chooseableItemGroup  = this.selectedItemClassGroupStore;
              //story
              this.selectedStoryGroup = JSON.parse(JSON.stringify(this.classStoryList));
            }
            this.$store.dispatch('mo/onIsSchoolSpace', this.isSchoolSpace);
            this.$store.dispatch('mo/onSelectedSchoolItem', this.selectedItem);

            //story
            if(this.selectedStoryGroup.length < 6 ){
              this.bannerStoryList = this.selectedStoryGroup;
              this.bodyStoryList = [];
              this.bannerKey++;
            }
            else{
              this.bannerStoryList = this.selectedStoryGroup.splice(0, 5);
              this.bodyStoryList = this.selectedStoryGroup;
              this.bannerKey++;
            }
          }
        })
      }
      
    },
    onSearch(){
    },
    onFalseSearching(){
      this.isSearching = false;
      this.searchKeyword = '';
    },

    selectItem(item){
        this.sheet = false;
        if(this.isSchoolSpace == true){
            if(item.path == 'posts.vocation'){
                if(this.user.roleId == 3){
                    this.$router.push({name:"posts.vacationTeacher",params:{schoolId:this.selectedSchoolItem.schoolId}})
                }else if(this.user.roleId == 2){
                    this.$router.push({name:"posts.attendance.vacation",params:{schoolId:this.selectedSchoolItem.schoolId}})
                }
                else{
                    this.$router.push({name:item.path,params:{schoolId:this.selectedSchoolItem.schoolId}})
                }
            }else{
                this.$router.push({name:item.path,params:{schoolId:this.selectedSchoolItem.schoolId}})
            }
        }
        else{
            if(item.path == 'posts.vocation'){
                if(this.user.roleId == 3){
                    this.$router.push({name:"posts.vacationTeacher",params:{schoolId:this.selectedSchoolItem.schoolId,gradeId:this.selectedSchoolItem.gradeId,lessonId:this.selectedSchoolItem.lessonId}})
                }else if(this.user.roleId == 2){
                    this.$router.push({name:"posts.attendance.vacation",params:{schoolId:this.selectedSchoolItem.schoolId,gradeId:this.selectedSchoolItem.gradeId,lessonId:this.selectedSchoolItem.lessonId}})
                }
                else{
                    this.$router.push({name:item.path,params:{schoolId:this.selectedSchoolItem.schoolId,gradeId:this.selectedSchoolItem.gradeId,lessonId:this.selectedSchoolItem.lessonId}})
                }
            }else{
                this.$router.push({name:item.path,params:{schoolId:this.selectedSchoolItem.schoolId,gradeId:this.selectedSchoolItem.gradeId,lessonId:this.selectedSchoolItem.lessonId}})
            }
        }
    },
    openAddItemDialog(){
      this.addItemDialog = true;
    },
    closeAddItemDialog(){
      this.addItemDialog = false
    },
    saveSelectedItemGroup(){
      if(this.selectedItem.type == "school"){
        this.selectedItemGroupForSchoolDia = this.selectedItemGroup;
        this.selectedItemGroupForSchoolDia.map(namedItem =>{
          let found = this.chooseableItemGroup.some(el=>el.title == namedItem)
          if(!found) {
            this.schoolSpaceItems.map(schoolItem=>{
              if(schoolItem.title == namedItem){
                this.chooseableItemGroup.push(schoolItem);
                this.carouselKey += 1
              }
            })
          }
        })
        let payload = {
          schoolItem: this.selectedItemGroupForSchoolDia
        }
        this.$store.dispatch('mo/onSelectedItemGroupForSchoolDiaStore', this.selectedItemGroupForSchoolDia);
        this.$store.dispatch('mo/onSelectedItemSchoolGroupStore', this.chooseableItemGroup);
        postChooseableSchoolItem(payload)
        .then((res) => {
          
        }).catch((err) => {
          
        });
      }
      else{
        this.selectedItemGroupForClassDia = this.selectedItemGroup;
        this.selectedItemGroupForClassDia.map(namedItem =>{
          let found = this.chooseableItemGroup.some(el=>el.title == namedItem)
          if(!found) {
            this.classSpaceItems.map(classItem=>{
              if(classItem.title == namedItem){
                this.chooseableItemGroup.push(classItem);
                this.carouselKey += 1
              }
            })
          }
        })
        let payload = {
          classItem: this.selectedItemGroupForClassDia
        }
        this.$store.dispatch('mo/onSelectedItemGroupForClassDiaStore', this.selectedItemGroupForClassDia);
        this.$store.dispatch('mo/onSelectedItemClassGroupStore', this.chooseableItemGroup);
        postChooseableClassItem(payload)
        .then((res) => {
          
        }).catch((err) => {
          
        });
      }
      this.closeAddItemDialog();
    },

    swipe (direction) {
      if(direction == "Left"){
        this.$router.push({name: 'mochat.news'});
      }
    },

    showDetailSchoolStory(story){
      story.schoolstory.content = JSON.stringify(story.schoolstory.content);
      this.$store.dispatch('content/storePostDetail',story)
      this.$router.push({name:'details.schoolStory'});
    },

    showDetailClassStory(story){
      story.classstory.content = JSON.stringify(story.classstory.content);
      this.$store.dispatch('content/storePostDetail',story)
      this.$router.push({name:'details.classStory'});
    },
  }
}
</script>
