<template>
  <v-container class="pa-0">
    <v-container v-if="$isMobile()" class="pa-0" >
      <v-col cols="12" class="d-flex align-center bg-white py-1 position-sticky-top-0" v-touch="{
        left: () => swipe('Left'),
        right: () => swipe('Right'),
      }">
        <transition name="page" mode="out-in">
          <v-text-field
            v-if="isSearching" key="1"
            solo
            class="mo-search-input-text-field"
            v-model="searchKeyword"
            label="请输入您的搜索词"
            prepend-inner-icon="mdi-magnify"
            hide-details
            color="#7879ff"
            dense 
          >
            <v-icon
                v-if="searchKeyword.trim() !== ''"
                slot="append"
                @click="searchKeyword = ''"
                small
              >
              mdi-close-circle
            </v-icon>
          </v-text-field>
          <v-select
            v-else key="2"
            solo
            class="mo-select-white-bg"
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
        <v-btn text small v-if="isSearching" key="3" class="ml-3 px-0 min-width-0" @click="onFalseSearching">
          取消
        </v-btn>
        <v-btn icon plain v-else key="4" class="ml-3" @click="isSearching = true">
          <v-icon size="30">
            mdi-magnify
          </v-icon>
        </v-btn>
        </transition>
      </v-col>
      <v-row class="ma-0">
        <v-col cols="12" class="py-2" >
          <carousel v-if="isSchoolSpace == true" :key="bannerKey" class="position-relative owl-cus-con" :nav="false" :items="1" :margin="10" :loop="true"  :autoplay="true" :autoplaySpeed="1500">
            <img :src="`${baseUrl}${story.schoolstory.content[0].imgUrl[0].path}`" v-for="story in bannerStoryList" :key="story.id" alt="carousel" class="mo-home-carousel-img"  @click="showDetailSchoolStory(story)" />
          </carousel>
          <carousel v-else class="position-relative owl-cus-con" :nav="false" :items="1" :margin="10" :loop="true" :autoplay="true" :autoplaySpeed="1500">
            <img :src="`${baseUrl}${story.classstory.content[0].imgUrl[0].path}`" v-for="story in bannerStoryList" :key="story.id" alt="carousel" class="mo-home-carousel-img" @click="showDetailClassStory(story)" />
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
                    <v-img :src="`${baseUrl}/asset/img/appIcon/others/addItem.png`" alt="postItem" width="50" height="50" class="mx-auto"></v-img>
                    <p class="font-size-0-75 pt-1 mb-0">添加</p>
                  </div>
                </v-sheet>
              </v-col>
            </carousel>
            <carousel class="mb-3" v-else-if="chooseableItemGroup.length > 0" :key="carouselKey" :nav="false" :items="5" :loop="false" :dots="false">
              <v-col class="pa-0 d-flex justify-center" v-for="(chooseableItem, i) in chooseableItemGroup" :key="i" @click="selectItem(chooseableItem)">
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
                    <v-img :src="`${baseUrl}/asset/img/appIcon/others/addItem.png`" alt="postItem" width="50" height="50" class="mx-auto"></v-img>
                    <p class="font-size-0-75 pt-1 mb-0">添加</p>
                  </div>
                </v-sheet>
              </v-col>
            </carousel>
            <v-divider class="mx-3" light></v-divider>

          <v-dialog overlay-opacity="0" persistent v-model="addItemDialog" width="100%" max-width="500" scrollable>
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
                      color="#7879ff"
                      @click="closeAddItemDialog "
                  >
                      {{lang.cancel}}
                  </v-btn>
                  <v-btn
                      text
                      color="#7879ff"
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
      <div class="cus-divider"></div>
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
        <v-row class="ma-0" v-for="(story, index) in bodyStoryList" :key="index" @click="showDetailSchoolStory(story)">
          <v-col cols="7" class="pl-0 d-flex align-start flex-column">
            <p class="mb-auto font-weight-bold d-inline-block text-truncate w-100">{{story.schoolstory.content[0].text}}</p>
            <div class="d-flex align-center justify-space-between w-100">
              <p class="mb-0">{{TimeViewYMD(story.created_at)}}</p>
              <p class="mb-0">{{story.users.name}}</p>
            </div>
          </v-col>
          <v-col cols="5" class="pr-0">
            <v-img :src="`${baseUrl}${story.schoolstory.content[0].imgUrl[0].path}`" height="100"></v-img>
          </v-col>
          <div v-if="index < bodyStoryList.length - 1" class="cus-divider-light-gray-height"></div>
        </v-row>
      </v-container>
      <v-container v-else class="pb-16" v-touch="{
        left: () => swipe('Left'),
        right: () => swipe('Right'),
      }">
        <v-row class="ma-0" v-for="(story, index) in bodyStoryList" :key="index" @click="showDetailClassStory(story)">
          <v-col cols="7" class="pl-0 d-flex align-start flex-column">
            <p class="mb-auto font-weight-bold d-inline-block text-truncate w-100">{{story.classstory.content[0].text}}</p>
            <div class="d-flex align-center justify-space-between w-100">
              <p class="mb-0">{{TimeViewYMD(story.created_at)}}</p>
              <p class="mb-0">{{story.users.name}}</p>
            </div>
          </v-col>
          <v-col cols="5" class="pr-0">
            <v-img :src="`${baseUrl}${story.classstory.content[0].imgUrl[0].path}`" height="100"></v-img>
          </v-col>
          <div v-if="index < bodyStoryList.length - 1 " class="cus-divider-light-gray-height"></div>
        </v-row>
      </v-container>
      
    </v-container>

    <v-container v-else class="">
      <v-row v-for="(schoolItem, i) in mySchoolList" :key="i" class="ma-0 pa-0">
        <v-col cols="12" class="hover-cursor-point" @click="goNewsOfSchool(schoolItem.id)">
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
            </v-card-text>
          </v-card>
        </v-col>
        <v-col class="ma-0 pa-0" cols="12" >
          <v-row class="ma-0" v-for="(grade, k) in schoolItem.grades" :key="k">
            <v-col v-for="(lesson, j) in grade.lessons" :key="j" cols="12" md="4" sm="6" class="hover-cursor-point" @click="goNewsOfClass(lesson)">
              <v-card>
                <v-img :src="`${baseUrl}${lesson.imgUrl}`" alt="school" class="class-card-img"></v-img>
                <v-card-title>{{lesson.lessonName}} - {{grade.gradeName}}</v-card-title>
              </v-card>
            </v-col>
          </v-row>
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
import {createReadCnt} from '~/api/alarm'
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
    schoolSpaceItems:[],
    classSpaceItems:[],
    carouselKey: 0,
    bannerKey: 0,
    selectedStoryGroup: [],
    bannerStoryList: [],
    bodyStoryList: [],
    adminSchoolItems:[
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regname"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"交接班",//교대반관리
        imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
        path:"shiftMng"
      },
      {
        title:"维修工单",//수리공
        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
        path:"repair"
      },
      {
        title:"安全教育",//안전교육
        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
        path:"safeStudy"
      },
      {
        title:"学校动态",//학교동태
        imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
        path:"schoolStory",
      },
    ],
    managerSchoolItems:[
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regname"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"交接班",//교대반관리
        imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
        path:"shiftMng"
      },
      {
        title:"维修工单",//수리공
        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
        path:"repair"
      },
      {
        title:"安全教育",//안전교육
        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
        path:"safeStudy"
      },
      {
        title:"学校动态",//학교동태
        imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
        path:"schoolStory",
      },
    ],
    teacherSchoolItems:[
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regname"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"交接班",//교대반관리
        imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
        path:"shiftMng"
      },
      {
        title:"维修工单",//수리공
        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
        path:"repair"
      },
      {
        title:"安全教育",//안전교육
        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
        path:"safeStudy"
      },
      {
        title:"学校动态",//학교동태
        imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
        path:"schoolStory",
      },
    ],
    parentSchoolItems:[
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regname"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"安全教育",//안전교육
        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
        path:"safeStudy"
      },
      {
        title:"学校动态",//학교동태
        imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
        path:"schoolStory",
      },
    ],
    studentSchoolItems:[
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regname"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"交接班",//교대반관리
        imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
        path:"shiftMng"
      },
      {
        title:"维修工单",//수리공
        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
        path:"repair"
      },
      {
        title:"安全教育",//안전교육
        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
        path:"safeStudy"
      },
      {
        title:"学校动态",//학교동태
        imgUrl:"/asset/img/appIcon/schoolStory/schoolStory.png",
        path:"schoolStory",
      },
    ],
    employeeSchoolItems:[
      {
        title:"交接班",//교대반관리
        imgUrl:"/asset/img/appIcon/schoolSafety/shiftMng.png",
        path:"shiftMng"
      },
      {
        title:"维修工单",//수리공
        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
        path:"repair"
      },
    ],
    adminClassItems:[
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regName"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"维修工单",//수리공
        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
        path:"repair"
      },
      {
        title:"安全教育",//안전교육
        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
        path:"safeStudy"
      },
      {
        title:"班级动态",//학급동태
        imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
        path:"classStory",
      },
      {
        title:"班际动态",//학급별동태
        imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
        path:"interClassStory",
      },
      {
        title:"表彰",//영예표창
        imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
        path:"recognition",
      },
    ],
    managerClassItems:[
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regName"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"维修工单",//수리공
        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
        path:"repair"
      },
      {
        title:"安全教育",//안전교육
        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
        path:"safeStudy"
      },
      {
        title:"班级动态",//학급동태
        imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
        path:"classStory",
      },
      {
        title:"班际动态",//학급별동태
        imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
        path:"interClassStory",
      },
      {
        title:"表彰",//영예표창
        imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
        path:"recognition",
      },
    ],
    teacherClassItems:[
      {
        title:"请假审批",//휴가심사
        imgUrl:"/asset/img/appIcon/attendance/vocationReply.png",
        path:"vocation"
      },
      {
        title:"课程表",//시간표
        imgUrl:"/asset/img/appIcon/attendance/scheduleClass.png",
        path:"admin.scheduleClass"
      },
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regName"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"作业",//숙제
        imgUrl:"/asset/img/appIcon/homeSchool/homework.png",
        path:"homework"
      },
      {
        title:"访客管理",//방문자관리
        imgUrl:"/asset/img/newIcon/manageGuests.png",
        path:"classSpace.manageGuests"
      },
      {
        title:"归程队",//귀한팀관리
        imgUrl:"/asset/img/appIcon/schoolSafety/returnTeam.png",
        path:"classSpace.returnTeam"
      },
      {
        title:"维修工单",//수리공
        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
        path:"repair"
      },
      {
        title:"安全教育",//안전교육
        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
        path:"safeStudy"
      },
      {
        title:"班级动态",//학급동태
        imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
        path:"classStory",
      },
      {
        title:"班际动态",//학급별동태
        imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
        path:"interClassStory",
      },
      {
        title:"表彰",//영예표창
        imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
        path:"recognition",
      },
    ],
    parentClassItems:[
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regname"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"作业",//숙제
        imgUrl:"/asset/img/appIcon/homeSchool/homework.png",
        path:"homework"
      },
      {
        title:"班级动态",//학급동태
        imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
        path:"classStory",
      },
      {
        title:"班际动态",//학급별동태
        imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
        path:"interClassStory",
      },
      {
        title:"表彰",//영예표창
        imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
        path:"recognition",
      },
    ],
    studentClassItems:[
      {
        title:"请假单",//휴가신청
        imgUrl:"/asset/img/appIcon/attendance/vocationRequest.png",
        path:"vacation"
      },
      {
        title:"课程表",//시간표
        imgUrl:"/asset/img/appIcon/attendance/scheduleClass.png",
        path:"admin.scheduleClass"
      },
      {
        title:"分享",//공유
        imgUrl:"/asset/img/appIcon/basicCommunity/share.png",
        path:"share"
      },
      {
        title:"问卷",//설문
        imgUrl:"/asset/img/appIcon/basicCommunity/questionnaire.png",
        path:"questionnaire"
      },
      {
        title:"投票",//투표
        imgUrl:"/asset/img/appIcon/basicCommunity/voting.png",
        path:"voting"
      },
      {
        title:"报名",//이름등록
        imgUrl:"/asset/img/appIcon/basicCommunity/regName.png",
        path:"regname"
      },
      {
        title:"公告",//공시
        imgUrl:"/asset/img/appIcon/homeSchool/announcement.png",
        path:"announcement"
      },
      {
        title:"作业",//숙제
        imgUrl:"/asset/img/appIcon/homeSchool/homework.png",
        path:"homework"
      },
      {
        title:"归程队",//귀한팀관리
        imgUrl:"/asset/img/appIcon/schoolSafety/returnTeam.png",
        path:"classSpace.returnTeam"
      },
      {
        title:"维修工单",//수리공
        imgUrl:"/asset/img/appIcon/schoolSafety/repair.png",
        path:"repair"
      },
      {
        title:"安全教育",//안전교육
        imgUrl:"/asset/img/appIcon/schoolSafety/safeStudy.png",
        path:"safeStudy"
      },
      {
        title:"班级动态",//학급동태
        imgUrl:"/asset/img/appIcon/schoolStory/classStory.png",
        path:"classStory",
      },
      {
        title:"班际动态",//학급별동태
        imgUrl:"/asset/img/appIcon/schoolStory/interClassStory.png",
        path:"interClassStory",
      },
      {
        title:"表彰",//영예표창
        imgUrl:"/asset/img/appIcon/schoolStory/recognition.png",
        path:"recognition",
      },
    ],


    mySchoolList:[],
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
      classStoryList: 'mo/classStoryList',
      isSchoolSpaceStore: 'mo/isSchoolSpace'
    }),

    
  },

  async created(){
    this.isSchoolSpace = this.isSchoolSpaceStore;
    
    if(this.user.roleId == 1){
      this.schoolSpaceItems = this.adminSchoolItems;
      this.classSpaceItems = this.adminClassItems;
    }
    else if(this.user.roleId == 2){
      this.schoolSpaceItems = this.managerSchoolItems;
      this.classSpaceItems = this.managerClassItems;
    }
    else if(this.user.roleId == 3 || this.user.roleId == 7){
      this.schoolSpaceItems = this.teacherSchoolItems;
      this.classSpaceItems = this.teacherClassItems;
    }
    else if(this.user.roleId == 4){
      this.schoolSpaceItems = this.parentSchoolItems;
      this.classSpaceItems = this.parentClassItems;
    }
    else if(this.user.roleId == 5){
      this.schoolSpaceItems = this.studentSchoolItems;
      this.classSpaceItems = this.studentClassItems;
    }
    else if(this.user.roleId == 6){
      this.schoolSpaceItems = this.employeeSchoolItems;
      this.classSpaceItems = [];
    }
    if(this.$isMobile()){
      if(this.schoolStoryList == null || this.classStoryList == null){
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
        if(this.isSchoolSpace == true){
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

    }

    console.log("this.schoolTree", this.schoolTree);
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
      console.log("@@@@@@@@@@@@@@@@@@@@@@@@this.schoolListDropdownItem",this.schoolListDropdownItem);
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
    else if(this.user.roleId == 6){
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

    if(this.user.roleId == 1){
      this.mySchoolList = this.schoolData
    }else if(this.user.roleId == 2){
      this.schoolData.map(schoolItem=>{
        if(this.user.schoolId == schoolItem.id){
          this.mySchoolList.push(schoolItem)
        }
      })
    }else if(this.user.roleId == 6){
      let myschoolData = {}
      this.schoolData.map(schoolItem=>{
        if(this.user.schoolId == schoolItem.id){
          myschoolData = schoolItem
        }
      })
      console.log("myschoolData-------",myschoolData)
      myschoolData.grades = [] 
      this.mySchoolList.push(myschoolData)
    }
    else{
      let myschoolData = {}
      this.schoolData.map(schoolItem=>{
        if(this.user.schoolId == schoolItem.id){
          myschoolData = schoolItem
        }
      })
      let clonedVal1 = JSON.parse(JSON.stringify(myschoolData))
      let clonedVal2 = JSON.parse(JSON.stringify(myschoolData))
      clonedVal1.grades = []
      clonedVal2.grades.map(grade=>{
        grade.lessons.map(lesson=>{
          this.user.groupArr.map(groupId=>{
            if(lesson.id == groupId){
              console.log('^^^^^^^',lesson)
              let index = clonedVal1.grades.indexOf(grade)
              if(index > -1){
                clonedVal1.grades[index].lessons.push(lesson)
              }
              else{
                clonedVal1.grades.push(grade)
                let gindex = clonedVal1.grades.indexOf(grade)
                clonedVal1.grades[gindex].lessons = []
                clonedVal1.grades[gindex].lessons.push(lesson)
              }
            }
          })
        })
      })
      this.mySchoolList.push(clonedVal1)
    }
    console.log("#########", "this.mySchoolList", this.mySchoolList);

    if(this.selectedSchoolItem == null){
      this.selectedItem = this.schoolListDropdownItem[0];
      this.$store.dispatch('mo/onSelectedSchoolItem', this.selectedItem);
    }
    else  {
      this.selectedItem = this.selectedSchoolItem
    }

    
    if(this.isSchoolSpace){
      this.selectedTypeItemGroup = this.schoolSpaceItems;
    }
    else {
      this.selectedTypeItemGroup = this.classSpaceItems
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
        if(this.isSchoolSpace == true){
            console.log(item);
            this.$router.push({name: `schoolSpace.applications.${item.path}`, params: {schoolId:this.selectedSchoolItem.schoolId}});
        }
        else{
            console.log(item);
            this.$router.push({name:`classSpace.applications.${item.path}`,params:{schoolId:this.selectedSchoolItem.schoolId,gradeId:this.selectedSchoolItem.gradeId,lessonId:this.selectedSchoolItem.lessonId}})
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
        this.chooseableItemGroup = [];
        this.carouselKey += 1
        this.selectedItemGroup.map(namedItem=>{
          this.schoolSpaceItems.map(item =>{
            if(item.title == namedItem){
              this.chooseableItemGroup.push(item);
              this.carouselKey += 1
            }
          })
        });
        let payload = {
          schoolItem: this.selectedItemGroup
        }
        this.$store.dispatch('mo/onSelectedItemGroupForSchoolDiaStore', this.selectedItemGroup);
        this.$store.dispatch('mo/onSelectedItemSchoolGroupStore', this.chooseableItemGroup);
        postChooseableSchoolItem(payload)
        .then((res) => {
          
        }).catch((err) => {
          
        });
      }
      else{
        this.chooseableItemGroup = [];
        this.carouselKey += 1
        this.selectedItemGroup.map(namedItem=>{
          this.classSpaceItems.map(item =>{
            if(item.title == namedItem){
              this.chooseableItemGroup.push(item);
              this.carouselKey += 1
            }
          })
        });
        let payload = {
          classItem: this.selectedItemGroup
        }
        this.$store.dispatch('mo/onSelectedItemGroupForClassDiaStore', this.selectedItemGroup);
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
      createReadCnt({postId:story.id}).then(res=>{
      }).catch(err=>{
      })
      story.schoolstory.content = JSON.stringify(story.schoolstory.content);
      this.$store.dispatch('content/storePostDetail',story)
      this.$router.push({name:'details.schoolDefault'});
    },

    showDetailClassStory(story){
      createReadCnt({postId:story.id}).then(res=>{
      }).catch(err=>{
      })
      story.classstory.content = JSON.stringify(story.classstory.content);
      this.$store.dispatch('content/storePostDetail',story)
      this.$router.push({name:'details.classDefault'});
    },
  }
}
</script>
