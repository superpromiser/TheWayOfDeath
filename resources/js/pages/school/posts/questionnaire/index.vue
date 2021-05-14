<template>
  <v-container class="ma-0 pa-0 h-100" v-if="$isMobile()">
      <v-container v-if="postNew == true" class="pt-0 px-0 h-100 bg-gray-light-dark mb-16 pb-10-px">
        <v-row class="ma-0 bg-white justify-center position-sticky-top-0" >
            <v-icon @click="$router.go(-1)" size="35" class="position-absolute put-align-center" style="left: 0px; top:50%" >
                mdi-chevron-left
            </v-icon>
            <p class="mb-0 font-size-0-95 font-weight-bold pa-3" >{{lang.questionnaire}}</p>
            <v-btn @click="navToPreview" text color="#7879ff" class="position-absolute put-align-center" style="right: 0px; top:50%">
                保存
            </v-btn>
        </v-row>
        <div class="cus-divider"></div>
        <v-row class="ma-0 mo-glow bg-white">
              <v-col cols="12" sm="6" md="4">
                  <v-text-field
                      color="#7879ff"
                      v-model="newQuestionnaireData.title"
                      label="标题"
                      hide-details
                      class="mt-0 pt-0"
                  ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                  <v-text-field
                      color="#7879ff"
                      v-model="newQuestionnaireData.description"
                      label="说明"
                      hide-details
                      class="mt-0 pt-0"
                  ></v-text-field>
              </v-col>
              <v-col
                  cols="12"
                  sm="6"
                  md="4"
                  >
                  <v-datetime-picker 
                      label="截止时间" 
                      v-model="newQuestionnaireData.deadline"
                      :okText='lang.ok'
                      :clearText='lang.cancel'
                  > </v-datetime-picker>
              </v-col>
              <v-col cols="12" sm="6" md="4" class="pb-0">
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
                      class="mt-0 pt-0"
                      v-model="newQuestionnaireData.viewList"
                  ></v-select>
              </v-col>
          </v-row>
        <div class="cus-divider"></div>
        <v-row class="ma-0 mo-glow bg-white">
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
        <div class="cus-divider"></div>
        <v-row class="ma-0 mo-glow bg-white" >
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
        <div class="cus-divider"></div>
        <!--  View Datas  -->
        <v-row class="ma-0 mo-glow bg-white">
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
                <v-col class="pl-6 pt-0" cols="12" v-for="(singleData, singleDataIndex) in data.singleContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                  <div class="d-flex align-center cursor-pointer"> 
                    <v-chip
                      class="mr-2"
                      color="success"
                      outlined
                      small
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
                <v-col class="pl-6 pt-0" cols="12" v-for="(multiData, singleDataIndex) in data.multiContentDataArr" :key="singleDataIndex" v-if="singleDataIndex !== 0">
                <div class="d-flex align-center cursor-pointer"> 
                  <v-chip
                    class="mr-2"
                    color="success"
                    outlined
                    small
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
        <div class="cus-divider"></div>
        <v-row class="ma-0 position-fixed-bottom-0 w-100 bg-white pa-3 ">
          <v-col cols="12" class="d-flex justify-space-between align-center pa-0">
            <div class="text-center px-2">
              <v-icon>mdi-buffer</v-icon>
              <p class="mb-0 font-color-gray-dark">模板</p>
            </div>
            <v-btn color="#7879ff" class="submit-mo-post-btn" dark large @click="submit" :loading="isSubmit"> 确认发布 </v-btn>
          </v-col>
        </v-row>
      </v-container>
      <div v-else class="h-100">
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
                 <h2>{{lang.questionnaire}}</h2>
              </v-col>
              <v-col cols="12" md="4" class="d-flex align-center justify-end">
                <v-btn
                  text
                  color="#999999"
                  @click="selContent('template')"
                >
                    可用模板 {{tempCnt}}， 草稿 {{draftCnt}}
                </v-btn>
                <v-btn
                    tile
                    dark
                    color="#F19861"
                    :loading="isDraft"
                    @click="saveDraft"
                >
                    {{lang.saveDraft}}
                </v-btn>
                <v-btn
                    tile
                    dark
                    color="#7879ff"
                    class="mx-2"
                    :loading="isSubmit"
                    @click="submit"
                >
                    {{lang.submit}}
                </v-btn>
              </v-col>
            </v-row>
            <!-- <div class="d-flex align-center justify-space-between">
                <a @click="$router.go(-1)">
                    <v-icon size="70">
                        mdi-chevron-left
                    </v-icon>
                </a>
                <div class="">
                 <h2>{{lang.questionnaire}}</h2>
                </div>
                <div>
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
                      color="#7879ff"
                      class="mx-2"
                      :loading="isSubmit"
                      @click="submit"
                  >
                      {{lang.submit}}
                  </v-btn>
                  <v-btn
                      tile
                      dark
                      color="#F19861"
                      class="mr-8"
                      :loading="isDraft"
                      @click="saveDraft"
                  >
                      {{lang.saveDraft}}
                  </v-btn>
                </div>
            </div> -->
            <!-- <div class="d-flex align-center justify-center">
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
                  color="#7879ff"
                  class="mx-2"
                  :loading="isSubmit"
                  @click="submit"
              >
                  {{lang.submit}}
              </v-btn>
              <v-btn
                  tile
                  dark
                  color="#F19861"
                  class="mr-8"
                  :loading="isDraft"
                  @click="saveDraft"
              >
                  {{lang.saveDraft}}
              </v-btn>
              
            </div> -->
            
            <!-- <template v-slot:actions>
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
                color="#7879ff"
                class="mr-8"
                :loading="isSubmit"
                @click="submit"
            >
                {{lang.submit}}
            </v-btn>
            </template> -->
        </v-container>
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
                        label="说明"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-datetime-picker 
                      label="截止时间" 
                      v-model="newQuestionnaireData.deadline"
                      :okText='lang.ok'
                      :clearText='lang.cancel'
                    > </v-datetime-picker>
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
        user: 'auth/user',
        selectedSchoolItem: 'mo/selectedSchoolItem',
        previewData: 'mo/previewData',
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
      deeper:true
    }
  },

  created(){
    if( this.$isMobile() && this.selectedSchoolItem == null){
      return this.$router.push({name: 'home'});
    }
    if(this.previewData !== null){
      this.newQuestionnaireData = this.previewData.data
    }
    console.log("222", this.user);
    this.newQuestionnaireData.schoolId = this.currentPath.params.schoolId;
    if(this.currentPath.name == 'posts.questionnaire'){
      this.postNew = true
    }
    getQuestionnaireTempCnt({schoolId:this.currentPath.params.schoolId}).then(res=>{
      console.log("++++++++++",res.data)
      this.tempCnt = res.data.templateCnt
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
        return this.$snackbar.showMessage({content: this.lang.questionnaire+this.lang.requireTitle, color: "error"})
      }
      if(this.newQuestionnaireData.description.trim() == ''){
        return this.$snackbar.showMessage({content: this.lang.questionnaire+this.lang.requireDescription, color: "error"})
      }
      if(this.newQuestionnaireData.deadline == ""){
        return this.$snackbar.showMessage({content: this.lang.requireDeadline, color: "error"})
      }
      if( dateNow > this.newQuestionnaireData.deadline){
        return this.$snackbar.showMessage({content: this.lang.requireDeadlineOrder, color: "error"})
      }
      if(this.newQuestionnaireData.viewList.length == 0){
        return this.$snackbar.showMessage({content: this.lang.requireMember, color: "error"})
      }
      if(this.newQuestionnaireData.content.length == 0){
        return this.$snackbar.showMessage({content: this.lang.questionnaire+this.lang.requireContent, color: "error"})
      }
      
      
      this.newQuestionnaireData.deadline = this.TimeView(this.newQuestionnaireData.deadline)
      this.isSubmit = true
      await createQuestionnaire(this.newQuestionnaireData).then(res => {
        this.$store.dispatch('mo/onPreviewData', null);
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


    async saveDraft(){
      let draftData = {}
      draftData.tempType = 2
      draftData.content = this.newQuestionnaireData.content
      draftData.schoolId = this.currentPath.params.schoolId
      if(this.currentPath.params.lessonId){
          draftData.lessonId = this.currentPath.params.lessonId
      }
      let currentTime = Date.now();
      draftData.title = 'title-' + currentTime
      draftData.description = 'description-' + currentTime
      console.log(draftData)
      if(this.newQuestionnaireData.content.length == 0){
          return this.$snackbar.showMessage({content: this.lang.requireName, color: "error"})
      }
      this.isDraft = true
      await createQuestionnaireTemp(draftData).then(res=>{
          console.log(res.data)
          this.isDraft = false
          this.draftCnt ++ 
      }).catch(err=>{
          console.log(err.response)
          this.isDraft = false
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
    },

    navToPreview(){
      let dateNow = new Date();
      if(this.newQuestionnaireData.title.trim() == ''){
        return this.$snackbar.showMessage({content: this.lang.questionnaire+this.lang.requireTitle, color: "error"})
      }
      if(this.newQuestionnaireData.description.trim() == ''){
        return this.$snackbar.showMessage({content: this.lang.questionnaire+this.lang.requireDescription, color: "error"})
      }
      if(this.newQuestionnaireData.deadline == ""){
        return this.$snackbar.showMessage({content: this.lang.requireDeadline, color: "error"})
      }
      if( dateNow > this.newQuestionnaireData.deadline){
        return this.$snackbar.showMessage({content: this.lang.requireDeadlineOrder, color: "error"})
      }
      if(this.newQuestionnaireData.viewList.length == 0){
        return this.$snackbar.showMessage({content: this.lang.requireMember, color: "error"})
      }
      if(this.newQuestionnaireData.content.length == 0){
        return this.$snackbar.showMessage({content: this.lang.questionnaire+this.lang.requireContent, color: "error"})
      }
      let previewData = {
        title: this.lang.questionnaire,
        data: this.newQuestionnaireData,
        type: 'questionnaire'
      }
      this.$store.dispatch('mo/onPreviewData', previewData);
      console.log("this.selectedSchoolItem", this.selectedSchoolItem)
      this.$router.push({name: 'schoolPost.preview', params: {schoolId: this.selectedSchoolItem.schoolId, contentType: 'questionnaire'}});
    },

  }
}
</script>

<style>

</style>