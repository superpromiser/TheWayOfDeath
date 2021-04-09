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
          <v-row class="ma-0 pa-0 mo-glow">
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3 mb-3" v-for="(item, i) in chooseableItemGroup" :key="i" @click="selectItem(item)">
              <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                <div class="text-center">
                  <v-img :src="`${baseUrl}${item.imgUrl}`" alt="postItem" width="30" height="30" class="mx-auto"></v-img>
                  <span class="font-size-0-75 pt-2"> {{item.title}}</span>
                </div>
              </v-card>
            </v-col>
            <v-col cols="3" class="pa-0 d-flex justify-center mt-3 mb-3" @click="openAddItemDialog">
              <v-card tile class="mo-glow pa-3 d-flex justify-center align-center">
                <div class="text-center">
                  <v-icon color="#7879ff" size="30">mdi-view-grid-plus</v-icon>
                  <p class="font-size-0-75 pt-2 mb-0">添加</p>
                </div>
              </v-card>
            </v-col>
          </v-row>
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
        <v-col cols="12" class="mt-5 d-flex pa-0 px-3 align-center">
          <div class="trapezoid position-relative"></div>
          <div class="parallelogram ml-4"></div>
          <div class="ml-4">
            学校要闻
          </div>
        </v-col>
      </v-row>
      <v-row class="ma-0 mt-5">
        <v-col cols="12" class="pa-0 d-flex align-center">
          <v-avatar tile class="mo-glow-small-shadow" size="40" >
            <v-icon color="#7879ff">
              mdi-school
            </v-icon>
          </v-avatar>
          <h3 class="ml-3">学校要闻</h3>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
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
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
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
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
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
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
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
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-card class="ma-0 pa-0 mt-5 mo-glow">
            <v-row class="ma-0">
              <v-col cols="12" class="d-flex align-center pb-0">
                <v-avatar class="mr-3 " tile >
                  <v-img :src="`${baseUrl}/asset/img/icon/报名 拷贝.png`" alt="postItem" ></v-img>
                </v-avatar>
                <p class="font-weight-black fs-10 mb-0"> 晨晓  </p>
                <div class="ml-auto">
                  <v-menu offset-y >
                    <template v-slot:activator="{ attrs, on }">
                      <v-btn icon fab small v-bind="attrs" v-on="on" >
                        <v-icon>mdi-dots-vertical  </v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item >
                        <v-list-item-title class="px-2">删除</v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                        <v-list-item-title class="px-2">固定到顶部</v-list-item-title>
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
              <v-col cols="12">
                  <p class="mb-0 mr-5">
                      在《小欢喜》中，乔卫东哄女朋友小梦的是20000元的包包，哄前妻用的是500块的榴莲。
                  </p>
                  <p class="mb-0 mr-5">
                      在剧中，小梦是乔卫东的女朋友，他第一次出场，是在一顿3人的火锅上。
                  </p>
              </v-col>
              <v-col cols="12"> 
                  <v-img :src="`${baseUrl}/asset/img/login.jpg`"></v-img>
              </v-col>
              <v-col cols="12" class="d-flex justify-space-between">
                  <p class="mb-0">浏览65次</p>
                  <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    >
                    <template v-slot:activator="{ on, attrs }">
                         <v-icon v-bind="attrs" v-on="on">mdi-dots-horizontal</v-icon>
                    </template>

                    <v-list>
                        <v-list-item>
                            <v-list-item-title>点赞</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>分享</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>转发</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>评论</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
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
import {postChooseableSchoolItem,  postChooseableClassItem, getPostItem} from '~/api/user'
import carousel from 'v-owl-carousel'
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
    schoolSpaceItems:[
      {
        title : "问卷",
        imgUrl : "/asset/img/icon/问卷 拷贝.png",
        path : "posts.questionnaire"
      },
      {
        title : "投票",
        imgUrl : "/asset/img/icon/投票.png",
        path : "posts.voting"
      },
      {
        title : "短信",
        imgUrl : "/asset/img/icon/短信 拷贝.png",
        path : "posts.sms"
      },
      {
        title : "校园动态",
        imgUrl : "/asset/img/icon/动态 拷贝.png",
        path : "posts.campus"
      },
      {
        title : "公告",
        imgUrl : "/asset/img/icon/公告 拷贝.png",
        path : "posts.announcement"
      },
      {
        title : "分享",
        imgUrl : "/asset/img/icon/分享.png",
        path : "posts.share"
      },
      {
        title : "布告栏",
        imgUrl : "/asset/img/icon/布告栏 拷贝.png",
        path : "posts.bulletinboard"
      },
      {
        title : "考勤",
        imgUrl : "/asset/img/icon/考勤.png",
        path : "something"
      },
      {
        title : "作业",
        imgUrl : "/asset/img/icon/作业 拷贝.png",
        path : "something"
      },
      {
        title : "习题",
        imgUrl : "/asset/img/icon/习题.png",
        path : "something"
      },
      {
        title : "家访",
        imgUrl : "/asset/img/icon/家访 拷贝.png",
        path : "posts.homevisit"
      },
      {
        title : "报名",
        imgUrl : "/asset/img/icon/报名 拷贝.png",
        path : "posts.regname"
      },
      {
        title : "请假",
        imgUrl : "/asset/img/icon/请假.png",
        path : "posts.vocation"
      },
    ],
    classSpaceItems:[
      {
        title : "问卷",
        imgUrl : "/asset/img/icon/问卷 拷贝.png",
        path : "posts.Cquestionnaire"
      },
      {
        title : "投票",
        imgUrl : "/asset/img/icon/投票.png",
        path : "posts.Cvoting"
      },
      {
        title : "作业",
        imgUrl : "/asset/img/icon/作业 拷贝.png",
        path : "something"
      },
      {
        title : "习题",
        imgUrl : "/asset/img/icon/习题.png",
        path : "something"
      },
      {
        title : "家访",
        imgUrl : "/asset/img/icon/家访 拷贝.png",
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
        imgUrl : "/asset/img/icon/组 29.png",
        path : "something"
      },
      {
        title : "相册",
        imgUrl : "/asset/img/icon/相册.png",
        path : "posts.Calbum"
      },
      {
        title : "文件",
        imgUrl : "/asset/img/icon/文件.png",
        path : "file"
      },
    ]
  }),

  computed:{
    ...mapGetters({
      user : 'auth/user',
      schoolTree : 'schooltree/schoolData',
      selectedSchoolItem : 'mo/selectedSchoolItem',
      selectedItemSchoolGroupStore : 'mo/selectedItemSchoolGroupStore',
      selectedItemClassGroupStore : 'mo/selectedItemClassGroupStore',
      selectedItemGroupForSchoolDiaStore : 'mo/selectedItemGroupForSchoolDiaStore',
      selectedItemGroupForClassDiaStore : 'mo/selectedItemGroupForClassDiaStore',
    })
  },

  async created(){
    this.listen();
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
      await getPostItem()
      .then((res) => {
        console.log("^^^");
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
      this.selectedItemGroup = this.selectedItemGroupForSchoolDia;
      console.log("this.schoolTree", this.schoolTree, this.selectedItemGroup);
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
              this.selectedTypeItemGroup = this.schoolSpaceItems;
              this.selectedItemGroup = this.selectedItemGroupForSchoolDiaStore;
              this.chooseableItemGroup = this.selectedItemSchoolGroupStore;
            }
            else{
              this.isSchoolSpace = false;
              this.selectedTypeItemGroup = this.classSpaceItems;
              this.selectedItemGroup = this.selectedItemGroupForClassDiaStore;
              this.chooseableItemGroup  = this.selectedItemClassGroupStore;
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
      //selectedItemGroup
      if(this.selectedItem.type == "school"){
        this.selectedItemGroup = this.selectedItemGroupForSchoolDia
      }
      else{
        this.selectedItemGroup = this.selectedItemGroupForClassDia
      }
      this.addItemDialog = true;
    },
    closeAddItemDialog(){
      this.selectedItemGroup = [];
      this.addItemDialog = false
    },
    saveSelectedItemGroup(){
      console.log(this.selectedItemGroup);
      if(this.selectedItem.type == "school"){
        this.selectedItemGroupForSchoolDia = this.selectedItemGroup;
        this.selectedItemGroupForSchoolDia.map(namedItem =>{
          let found = this.chooseableItemGroup.some(el=>el.title == namedItem)
          if(!found) {
            this.schoolSpaceItems.map(schoolItem=>{
              if(schoolItem.title == namedItem){
                this.chooseableItemGroup.push(schoolItem);
              }
            })
          }
        })
        console.log(this.chooseableItemGroup, this.selectedItemGroupForSchoolDia)
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
              }
            })
          }
        })
        console.log(this.chooseableItemGroup, this.selectedItemGroupForClassDia)
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
    listen(){
      Echo.private('newguest.'+ this.user.id)
        .listen('NewGuest', (e) => {
          console.log("@@@@@@@@@@@@@", e);
        });
    }
  }
}
</script>
