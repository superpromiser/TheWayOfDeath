<template>
  <v-container class="ma-0 pa-0" v-if="$isMobile()">
      <v-container v-if="postNew == true">
        <v-row class="ma-0">
            <v-col cols="12" class="mo-glow d-flex align-center justify-center">
                <v-avatar class="" >
                    <v-img :src="`${baseUrl}/asset/img/icon/问卷 拷贝.png`" alt="postItem" width="48" height="48" ></v-img>
                </v-avatar>
                <h2 class="ml-3">{{lang.questionnaire}}</h2>
            </v-col>
        </v-row>
        <v-row class="ma-0 mo-glow">
              <v-col cols="12" sm="6" md="4">
                  <v-text-field
                      color="#7879ff"
                      v-model="newQuestionnaireData.title"
                      label="标题"
                      hide-details
                  ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                  <v-text-field
                      color="#7879ff"
                      v-model="newQuestionnaireData.description"
                      label="说明（选填）"
                      hide-details
                  ></v-text-field>
              </v-col>
              <v-col
                  cols="12"
                  sm="6"
                  md="4"
                  >
                  <v-menu
                      ref="menu"
                      v-model="menu"
                      :close-on-content-click="false"
                      :return-value.sync="newQuestionnaireData.deadline"
                      transition="scale-transition"
                      offset-y
                      min-width="auto"
                  >
                      <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                          color="#7879ff"
                          v-model="newQuestionnaireData.deadline"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                          hide-details
                      ></v-text-field>
                      </template>
                      <v-date-picker
                      v-model="newQuestionnaireData.deadline"
                      no-title
                      scrollable
                      locale="zh-cn"
                      >
                      <v-spacer></v-spacer>
                      <v-btn
                          text
                          color="primary"
                          @click="menu = false"
                      >
                          {{lang.cancel}}
                      </v-btn>
                      <v-btn
                          text
                          color="primary"
                          @click="$refs.menu.save(date)"
                      >
                          {{lang.ok}}
                      </v-btn>
                      </v-date-picker>
                  </v-menu>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                  <v-select
                      color="#7879ff"
                      multiple
                      small-chips
                      :items="returnSchoolTree(currentPath.params.schoolId)"
                      :menu-props="{ top: false, offsetY: true }"
                      item-text="lessonName"
                      item-value="lessonId"
                      @change="selectedLesson"
                      label="班级"
                      hide-details
                      v-model="newQuestionnaireData.viewList"
                  ></v-select>
              </v-col>
          </v-row>
          <v-row class="ma-0 mo-glow ">
              <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-between">
                  <span class="">匿名问卷</span>
                  <v-switch
                      v-model="newQuestionnaireData.questionnaireFlag"
                      color="#7879ff"
                      hide-details
                      class="pt-0 mt-0"
                  ></v-switch>
              </v-col>
              <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-between">
                  <span class="">答卷人可见结果</span>
                  <v-switch
                      v-model="newQuestionnaireData.resultFlag"
                      color="#7879ff"
                      hide-details
                      class="pt-0 mt-0"
                  ></v-switch>
              </v-col>
              <v-col cols="12" sm="6" md="4" class="d-flex align-center justify-space-between">
                  <span class="">外部人员可作答</span>
                  <v-switch
                      v-model="newQuestionnaireData.answerFlag"
                      color="#7879ff"
                      hide-details
                      class="pt-0 mt-0"
                  ></v-switch>
              </v-col>
          </v-row>
          <v-row class="ma-0 mo-glow position-sticky-top-0 bg-white" >
              <v-col cols="12" class="d-flex align-center justify-space-between">
                <v-btn text color="#7879ff" @click="selContent('single')">
                  <v-icon left color="#7879ff">mdi-plus</v-icon>单选题
                </v-btn>
                <v-btn text color="#7879ff" @click="selContent('multi')">
                  <v-icon left color="#7879ff">mdi-plus</v-icon>多选题
                </v-btn>
                <v-btn text color="#7879ff" @click="selContent('question')">
                  <v-icon left color="#7879ff">mdi-plus</v-icon>问答题
                </v-btn>
              </v-col>
              <v-col cols="12" class="d-flex align-center justify-space-between">
                <v-btn text color="#7879ff" @click="selContent('scoring')">
                  <v-icon left color="#7879ff">mdi-plus</v-icon>评分题
                </v-btn>
              </v-col>
          </v-row>
          <!--  View Datas  -->
          <v-row class="ma-0 mo-glow mt-5 mb-10 pb-16">
            <!--  View Divider  -->
            <v-col cols="12" class="text-center">
              <h2>预览</h2>
              <v-divider></v-divider>
            </v-col>
            <!--  View Datas  -->
            <v-col cols="12" v-for="(data, index) in newQuestionnaireData.content" :key="index">
              <!--  single Datas  -->
              <v-row v-if="data.type == 'single'">
                <v-col cols="12">
                  <p class="mb-0 d-flex align-center"> 
                    {{index + 1}}.  
                    <v-chip class="ma-2" color="success" outlined >
                      <strong>单选题</strong>
                    </v-chip>
                    <v-btn icon color="green" class="" @click="pushUp(index)" :disabled="index == 0"  >
                      <v-icon>mdi-arrow-up-bold</v-icon>
                    </v-btn>
                    <v-btn icon color="green" class="" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)" >
                      <v-icon>mdi-arrow-down-bold</v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)" >
                      <v-icon dark>
                        mdi-pencil
                      </v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)" >
                      <v-icon dark>
                        mdi-trash-can-outline
                      </v-icon>
                    </v-btn>
                  </p>
                  <p class="text-wrap pl-3 mb-0 pa-0 ">{{ data.singleContentDataArr[0].text }}</p>
                </v-col>
                <v-col v-if="checkIfAttachExist(data.singleContentDataArr[0])">
                  <AttachItemViewer :items="data.singleContentDataArr[0]" />
                </v-col>
                <v-col class="pl-6 pa-0" cols="12" v-for="(singleData, singleDataIndex) in data.singleContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                  <div> 
                    <strong>{{alphabet[singleDataIndex-1]}}</strong>
                    <p class="mb-0 text-wrap"> {{singleData.text}}</p>
                  </div>
                  <AttachItemViewer :items="singleData" v-if="checkIfAttachExist(singleData)" />
                </v-col>
              </v-row>
              <!--  multi Datas  -->
              <v-row v-if="data.type == 'multi'">
                <v-col cols="12">
                  <p class="mb-0 d-flex align-center"> 
                    {{index + 1}}.  
                    <v-chip class="ma-2" color="success" outlined >
                      <strong>多选题</strong>
                    </v-chip>
                    <v-btn icon color="green" class="" @click="pushUp(index)" :disabled="index == 0">
                      <v-icon>mdi-arrow-up-bold</v-icon>
                    </v-btn>
                    <v-btn icon color="green" class="" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)">
                      <v-icon>mdi-arrow-down-bold</v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)" >
                      <v-icon dark>
                        mdi-pencil
                      </v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)" >
                      <v-icon dark>
                        mdi-trash-can-outline
                      </v-icon>
                    </v-btn>
                  </p>
                  <p class="text-wrap pl-3 mb-0  ">{{ data.multiContentDataArr[0].text }}</p>
                </v-col>
                <v-col v-if="checkIfAttachExist(data.multiContentDataArr[0])">
                  <AttachItemViewer :items="data.multiContentDataArr[0]" />
                </v-col>
                <v-col class="pl-6 pa-0" cols="12" v-for="(multiData, singleDataIndex) in data.multiContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                  <div> 
                    <strong>{{alphabet[singleDataIndex-1]}}</strong>
                    <p class="mb-0 text-wrap "> {{multiData.text}}</p>
                  </div>
                  <AttachItemViewer :items="multiData" v-if="checkIfAttachExist(multiData)" />
                </v-col>
              </v-row>
              <!--  qa Datas  -->
              <v-row v-if="data.type == 'qa'">
                <v-col cols="12">
                  <p class="mb-0 d-flex align-center"> 
                    {{index + 1}}.  
                    <v-chip class="ma-2" color="success" outlined >
                      <strong>问答题</strong>
                    </v-chip>
                    <v-btn icon color="green" class="" @click="pushUp(index)" :disabled="index == 0">
                      <v-icon>mdi-arrow-up-bold</v-icon>
                    </v-btn>
                    <v-btn icon color="green" class="" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)">
                      <v-icon>mdi-arrow-down-bold</v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)">
                      <v-icon dark>
                        mdi-pencil
                      </v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)">
                      <v-icon dark>
                        mdi-trash-can-outline
                      </v-icon>
                    </v-btn>
                  </p>
                  <p class="text-wrap pl-3 mb-0">{{ data.qaContentDataArr[0].text }}</p>
                </v-col>
                <v-col v-if="checkIfAttachExist(data.qaContentDataArr[0])">
                  <AttachItemViewer :items="data.qaContentDataArr[0]" />
                </v-col>
              </v-row>
              <!--  statistics Datas  -->
              <v-row v-if="data.type == 'stat'">
                <v-col cols="12">
                  <p class="mb-0 d-flex align-center"> 
                    {{index + 1}}.  
                    <v-chip class="ma-2" color="success" outlined >
                      <strong>统计题</strong>
                    </v-chip>
                    <v-btn icon color="green" class="" @click="pushUp(index)" :disabled="index == 0">
                      <v-icon>mdi-arrow-up-bold</v-icon>
                    </v-btn>
                    <v-btn icon color="green" class="" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)" >
                      <v-icon>mdi-arrow-down-bold</v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)">
                      <v-icon dark>
                        mdi-pencil
                      </v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)">
                      <v-icon dark>
                        mdi-trash-can-outline
                      </v-icon>
                    </v-btn>
                  </p>
                  <p class="text-wrap pl-3 mb-0">{{ data.statDataArr[0].contentData[0].text }}</p>
                </v-col>
                <v-col v-if="checkIfAttachExist(data.statDataArr[0].contentData[0])">
                  <AttachItemViewer :items="data.statDataArr[0].contentData[0]" />
                </v-col>
              </v-row>
              <!--  score Datas  -->
              <v-row v-if="data.type == 'score'">
                <v-col cols="12">
                  <p class="mb-0 d-flex align-center"> 
                    {{index + 1}}.  
                    <v-chip class="ma-2" color="success" outlined >
                      <strong>评分题</strong>
                    </v-chip>
                    <v-btn icon color="green" class="" @click="pushUp(index)" :disabled="index == 0">
                      <v-icon>mdi-arrow-up-bold</v-icon>
                    </v-btn>
                    <v-btn icon color="green" class="" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)">
                      <v-icon>mdi-arrow-down-bold</v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)">
                      <v-icon dark>
                        mdi-pencil
                      </v-icon>
                    </v-btn>
                    <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)">
                      <v-icon dark>
                        mdi-trash-can-outline
                      </v-icon>
                    </v-btn>
                  </p>
                  <p class="text-wrap pl-3 mb-0 ">{{ data.scoringDataArr[0].contentData[0].text }}</p>
                </v-col>
                <v-col v-if="checkIfAttachExist(data.scoringDataArr[0].contentData[0])">
                  <AttachItemViewer :items="data.scoringDataArr[0].contentData[0]" />
                </v-col>
              </v-row>
            </v-col>
          </v-row>
          <quick-menu @clickDraft="something" @clickPublish="submit" :isPublishing="isSubmit"></quick-menu>
      </v-container>
      <div v-else>
        <keep-alive>
          <router-view @contentData="saveContent" :type="'post'"></router-view>
        </keep-alive>
      </div>
      <v-snackbar
        timeout="3000"
        v-model="isSuccessed"
        color="success"
        absolute
        top
        >
        {{lang.successText}}
    </v-snackbar>
  </v-container>
  <v-container class="pa-0" v-else>
      <div v-if="postNew == true">
        <v-banner class=" mb-10 z-index-2" color="white" sticky elevation="20">
            <div class="d-flex align-center">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <v-avatar
                    class="ma-3 ml-3"
                    size="50"
                    tile
                >
                    <v-img :src="`${baseUrl}/asset/img/newIcon/问卷.png`" alt="postItem" ></v-img>
                </v-avatar>
                <h2>{{lang.questionnaire}}</h2>
            </div>
            <template v-slot:actions>
            <v-btn
                text
                color="primary"
                @click="selContent('template')"
            >
                可用模板 {{tempCnt}}， 草稿 {{draftCnt}}
            </v-btn>
            
            <v-btn
                tile
                dark
                color="#F19861"
                class="mx-2"
                :loading="isDraft"
                @click="saveDraft"
            >
                {{lang.saveDraft}}
            </v-btn>
            <v-btn
                tile
                dark
                color="#49d29e"
                class="mr-8"
                :loading="isSubmit"
                @click="submit"
            >
                {{lang.submit}}
            </v-btn>
            </template>
        </v-banner>
        <v-container class="pa-10">
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newQuestionnaireData.title"
                        label="标题"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field
                        solo
                        v-model="newQuestionnaireData.description"
                        label="说明（选填）"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-datetime-picker 
                      label="最后期限" 
                      v-model="newQuestionnaireData.deadline"
                      :okText='lang.ok'
                      :clearText='lang.cancel'
                    > </v-datetime-picker>
                    <!-- <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="newQuestionnaireData.deadline"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            solo
                            v-model="newQuestionnaireData.deadline"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            hide-details
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="newQuestionnaireData.deadline"
                        no-title
                        scrollable
                        locale="zh-cn"
                        >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                            @click="menu = false"
                        >
                            {{lang.cancel}}
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$refs.menu.save(date)"
                        >
                            {{lang.ok}}
                        </v-btn>
                        </v-date-picker>
                    </v-menu> -->
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-select
                        solo
                        multiple
                        chips
                        :items="returnSchoolTree(currentPath.params.schoolId)"
                        :menu-props="{ top: false, offsetY: true }"
                        item-text="lessonName"
                        item-value="lessonId"
                        @change="selectedLesson"
                        label="班级"
                        hide-details
                        v-model="newQuestionnaireData.viewList"
                    >
                    <template v-slot:prepend-item>
                        <v-list-item
                          ripple
                          @click="toggleSelectAll"
                        >
                          <v-list-item-action>
                            <v-icon :color="newQuestionnaireData.viewList.length > 0 ? '#3989fc' : ''">
                              {{ selectAllIcon }}
                            </v-icon>
                          </v-list-item-action>
                          <v-list-item-content>
                            <v-list-item-title>
                              全选
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-divider class="mt-2"></v-divider>
                      </template>  
                    </v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span>匿名问卷</span>
                    <v-switch
                        v-model="newQuestionnaireData.questionnaireFlag"
                        color="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span>答卷人可见结果</span>
                    <v-switch
                        v-model="newQuestionnaireData.resultFlag"
                        color="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
                <v-col cols="6" sm="6" md="4" class="d-flex align-center justify-space-around">
                    <span>外部人员可作答</span>
                    <v-switch
                        v-model="newQuestionnaireData.answerFlag"
                        color="primary"
                        hide-details
                        inset
                        class="pt-0 mt-0"
                    ></v-switch>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="#3989fc" @click="selContent('single')">
                        <v-icon>
                            mdi-plus
                        </v-icon>单选题
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="#3989fc" @click="selContent('multi')">
                        <v-icon>
                            mdi-plus
                        </v-icon>多选题
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="#3989fc" @click="selContent('question')">
                        <v-icon>
                            mdi-plus
                        </v-icon>问答题
                    </v-btn>
                </v-col>
                <!-- <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="#3989fc" @click="selContent('stat')">
                        <v-icon>
                            mdi-plus
                        </v-icon>统计题
                    </v-btn>
                </v-col> -->
                <v-col cols="12" sm="6" md="4">
                    <v-btn block dark large color="#3989fc" @click="selContent('scoring')">
                        <v-icon>
                            mdi-plus
                        </v-icon>评分题
                    </v-btn>
                </v-col>
            </v-row>
            <!--  View Datas  -->
            <v-row class="mt-10">
              <!--  View Divider  -->
              <v-col cols="12">
                <v-divider></v-divider>
              </v-col>
              <!--  View Datas  -->
              <v-col cols="12" v-for="(data, index) in newQuestionnaireData.content" :key="index" v-if="newQuestionnaireData.content.length > 0">
                <!--  single Datas  -->
                <v-row v-if="data.type == 'single'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>单选题</strong>
                      </v-chip>
                      <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0"  >
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)" >
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)" >
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)" >
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.singleContentDataArr[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.singleContentDataArr[0])">
                    <AttachItemViewer :items="data.singleContentDataArr[0]" />
                  </v-col>
                  <v-col class="pl-6" cols="12" v-for="(singleData, singleDataIndex) in data.singleContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                    <div> 
                      <v-chip
                        class="mr-2"
                        color="success"
                        outlined
                      >
                        <strong>{{alphabet[singleDataIndex-1]}}</strong>
                      </v-chip>
                      <p class="mb-0 text-wrap"> {{singleData.text}}</p>
                    </div>
                    <AttachItemViewer :items="singleData" v-if="checkIfAttachExist(singleData)" />
                  </v-col>
                </v-row>
                <!--  multi Datas  -->
                <v-row v-if="data.type == 'multi'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>多选题</strong>
                      </v-chip>
                      <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0">
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)">
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)" >
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)" >
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.multiContentDataArr[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.multiContentDataArr[0])">
                    <AttachItemViewer :items="data.multiContentDataArr[0]" />
                  </v-col>
                  <v-col class="pl-6" cols="12" v-for="(multiData, singleDataIndex) in data.multiContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                    <div> 
                      <v-chip
                        class="mr-2"
                        color="success"
                        outlined
                      >
                        <strong>{{alphabet[singleDataIndex-1]}}</strong>
                      </v-chip>
                      <p class="mb-0 text-wrap"> {{multiData.text}}</p>
                    </div>
                    <AttachItemViewer :items="multiData" v-if="checkIfAttachExist(multiData)" />
                  </v-col>
                </v-row>
                <!--  qa Datas  -->
                <v-row v-if="data.type == 'qa'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>问答题</strong>
                      </v-chip>
                     <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0">
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)">
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)">
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)">
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.qaContentDataArr[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.qaContentDataArr[0])">
                    <AttachItemViewer :items="data.qaContentDataArr[0]" />
                  </v-col>
                </v-row>
                <!--  statistics Datas  -->
                <v-row v-if="data.type == 'stat'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>统计题</strong>
                      </v-chip>
                     <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0">
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)" >
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)">
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)">
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.statDataArr[0].contentData[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.statDataArr[0].contentData[0])">
                    <AttachItemViewer :items="data.statDataArr[0].contentData[0]" />
                  </v-col>
                </v-row>
                <!--  score Datas  -->
                <v-row v-if="data.type == 'score'">
                  <v-col cols="12">
                    <p class="mb-0 d-flex align-center"> 
                      {{index + 1}}.  
                      <v-chip class="ma-2" color="success" outlined >
                        <strong>评分题</strong>
                      </v-chip>
                     <v-btn icon color="green" class="ml-2" @click="pushUp(index)" :disabled="index == 0">
                        <v-icon>mdi-arrow-up-bold</v-icon>
                      </v-btn>
                      <v-btn icon color="green" class="mr-2" @click="pushDown(index)" :disabled="index == (newQuestionnaireData.content.length-1)">
                        <v-icon>mdi-arrow-down-bold</v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="primary" class="mx-2" @click="editContent(data, index)">
                        <v-icon dark>
                          mdi-pencil
                        </v-icon>
                      </v-btn>
                      <v-btn fab dark x-small color="error" class="mx-2" @click="deleteContent( index)">
                        <v-icon dark>
                          mdi-trash-can-outline
                        </v-icon>
                      </v-btn>
                    </p>
                    <p class="text-wrap pl-3 mb-0">{{ data.scoringDataArr[0].contentData[0].text }}</p>
                  </v-col>
                  <v-col v-if="checkIfAttachExist(data.scoringDataArr[0].contentData[0])">
                    <AttachItemViewer :items="data.scoringDataArr[0].contentData[0]" />
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
        </v-container>
      </div>
      <div v-else>
        <keep-alive>
          <router-view @contentData="saveContent" :type="'post'"></router-view>
        </keep-alive>
      </div>
      <v-snackbar
        timeout="3000"
        v-model="isSuccessed"
        color="success"
        absolute
        top
        >
        {{lang.successText}}
    </v-snackbar>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import lang from '~/helper/lang.json';
import QuestionItem from '~/components/questionItem';
import AttachItemViewer from '~/components/attachItemViewer';
import {getQuestionnaireTempCnt,createQuestionnaireTemp,createQuestionnaire,updateQuestionnaire,deleteQuestionnaire} from '~/api/questionnaire';
// import {createTemplate} from '~/api/template';
import quickMenu from '~/components/quickMenu'
export default {
  middleware:['auth','post'],
  data: () => ({
      lang,
      baseUrl: window.Laravel.base_url,
      newQuestionnaireData : {
          title:'',
          description:'',
          viewList:[],
          deadline:'',
          questionnaireFlag:true,
          resultFlag:true,
          answerFlag:false,
          content:[],
          schoolId:null,
      },
      postNew:false,
      selType:'',
      dialog:false,
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      alphabet:['A','B','C','D','E','F','G','H','J','K','L','M','N',
                'O','P','Q','R','S','T','U','V','W','X','Y','Z' ],
      isSubmit:false,
      isDraft:false,
      isSuccessed:false,
      tempCnt:0,
      draftCnt:0,
      
  }),

  components: {
      QuestionItem,
      AttachItemViewer,
      quickMenu
  },

  computed: {
      
      currentPath(){
        return this.$route;
      },
      ...mapGetters({
        user: 'auth/user'
      }),

      selectAllItems () {
        return this.newQuestionnaireData.viewList.length === this.returnSchoolTree(this.currentPath.params.schoolId).filter(function(el){return el.lessonId !== undefined && el.lessonId !== null}).length
      },
      selectSomeItems () {
        return this.newQuestionnaireData.viewList.length > 0 && !this.selectAllItems
      },
      selectAllIcon(){
        if (this.selectAllItems) return 'mdi-close-box'
        if (this.selectSomeItems) return 'mdi-minus-box'
        return 'mdi-checkbox-blank-outline'
      }
  },
  watch:{
    currentPath:{
      handler(val){
        console.log('posts.questionnaire',val)
        if(val.name == 'posts.questionnaire'){
          this.postNew = true
        }
        if(val.query.tempData){
          this.newQuestionnaireData.content = JSON.parse(val.query.tempData)
          console.log("this.newQuestionnaireData.content",this.newQuestionnaireData.content)
        }
      },
      deep:true
    }
  },

  created(){
    console.log("222", this.user);
    this.newQuestionnaireData.schoolId = this.currentPath.params.schoolId;
    if(this.currentPath.name == 'posts.questionnaire'){
      this.postNew = true
    }
    getQuestionnaireTempCnt().then(res=>{
      console.log(res.data)
      this.tempCnt = res.data.tempCnt
      this.draftCnt = res.data.draftCnt
    })
  },

  methods:{
    updateImageFile(imageFile){
        //console.log(imageFile)
    },
    selectedLesson(val){
        //console.log(val)
    },
    selContent(type){
        this.postNew = false;
        this.selType = type;
        switch(type){
            case 'single':
                this.$router.push({name:"questionnaire.single"});
                break;
            case 'multi':
                this.$router.push({name:"questionnaire.multi"});
                break;
            case 'question':
                this.$router.push({name:"questionnaire.questionAnswer"});
                break;
            case 'stat':
                this.$router.push({name:"questionnaire.statistics"});
                break;
            case 'scoring':
                this.$router.push({name:"questionnaire.scoring"});
                break;
            case 'template':
                this.$router.push({name:"questionnaire.templateList"});
                break;
            default:
                break;
        }
    },
    saveContent(data){
      console.log('----------',data)
      this.postNew = true;
      if(data.index == null){
        this.newQuestionnaireData.content.push(data)
      }
      else{
        this.newQuestionnaireData.content[data.index] = data
      }
      console.log('++++++++++',this.newQuestionnaireData)
    },
    async submit(){
      console.log("!", this.newQuestionnaireData)
      let dateNow = new Date();
      if(this.newQuestionnaireData.title.trim() == ''){
        return this.$snackbar.showMessage({content: "主题字段为空。", color: "error"})
      }
      if(this.newQuestionnaireData.description.trim() == ''){
        return this.$snackbar.showMessage({content: "说明（选填）字段为空。", color: "error"})
      }
      if(this.newQuestionnaireData.deadline == ""){
        return this.$snackbar.showMessage({content: "输入截止日期。", color: "error"})
      }
      if( dateNow > this.newQuestionnaireData.deadline){
        return this.$snackbar.showMessage({content: "截止日期应晚于当前时间。", color: "error"})
      }
      if(this.newQuestionnaireData.viewList.length == 0){
        return this.$snackbar.showMessage({content: "请选择一个班级。", color: "error"})
      }
      if(this.newQuestionnaireData.content.length == 0){
        return this.$snackbar.showMessage({content: "请输入问卷。", color: "error"})
      }
      
      
      this.newQuestionnaireData.deadline = this.TimeView(this.newQuestionnaireData.deadline)
      this.isSubmit = true
      await createQuestionnaire(this.newQuestionnaireData).then(res => {
        //console.log(res)
        this.isSuccessed = true;
        // this.newQuestionnaireData = null
        if(this.$isMobile()){
          this.$router.push({name:'home'})
        }
        else{
          this.$router.push({name:'schoolSpace.news'})
        }
      }).catch(err=>{
        //console.log(err.response)
         if(err.response.status === 422){
            for(let i in err.response.data.errors){
                //console.log(err.response.data.errors[i][0])
            }
        }
      })
      this.isSubmit = false
    },

    checkIfAttachExist(data){
      let count = 0;
      count = count + data.imgUrl.length + data.videoUrl.length + data.otherUrl.length;
      if( count == 0 ) {
        return false;
      }
      else{
        return true;
      }
    },

    pushUp(index){
      let temp = Object.assign({}, this.newQuestionnaireData.content[index-1]);
      Object.assign(this.newQuestionnaireData.content[index-1], this.newQuestionnaireData.content[index] ) ;
      Object.assign(this.newQuestionnaireData.content[index], temp);
    },

    pushDown(index){
      let temp = Object.assign({}, this.newQuestionnaireData.content[index+1]);
      Object.assign(this.newQuestionnaireData.content[index+1], this.newQuestionnaireData.content[index] ) ;
      Object.assign(this.newQuestionnaireData.content[index], temp);
    },

    editContent(data, index){
      console.log(data, index);
      this.postNew = false;
      if(data.type == "single"){
        this.$router.push({name: "questionnaire.single", params: {editDataArr: data.singleContentDataArr, editDataIndex: index}})
      }
    },

    deleteContent(index){
      this.newQuestionnaireData.content.splice(index, 1)
    },


    saveDraft(){
      //console.log(this.newQuestionnaireData)
      let saveTime = new Date();
      console.log(saveTime)
      // return
      this.isDraft = true;
      createQuestionnaireTemp({
        temTitle:saveTime,
        imgUrl:'/asset/img/coverImage/profile_bg2.jpg',
        title:saveTime,
        description:saveTime,
        content:this.newQuestionnaireData,
        temType:2,
      }).then(res=>{
        console.log(res)
        this.isDraft = false;
      }).catch(err=>{
        console.log(err.response)
        this.isDraft = false;
      })
    },

    something(){

    },

    toggleSelectAll(){
      this.$nextTick(() => {
        if (this.selectAllItems) {
          this.newQuestionnaireData.viewList = []
        } else {
          this.newQuestionnaireData.viewList = this.returnSchoolTree(this.currentPath.params.schoolId).filter(function(el){return el.lessonId !== undefined && el.lessonId !== null}).slice()
        }
      })
    }

  }
}
</script>

<style>

</style>