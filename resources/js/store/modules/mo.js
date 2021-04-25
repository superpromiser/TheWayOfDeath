import * as types from '../mutation-types'
// state
export const state = {
  isSchoolSpace: true,
  selectedSchoolItem: null,
  selectedItemSchoolGroupStore: null,
  selectedItemClassGroupStore: null,
  selectedItemGroupForSchoolDiaStore: null,
  selectedItemGroupForClassDiaStore: null,

  schoolStoryList : null,
  classStoryList : null,

  //moBottomNav
  value: 0,
  isNewPost: false,

  //preview
  previewData: null,
}

// getters
export const getters = {
  isSchoolSpace: state => state.isSchoolSpace,
  selectedSchoolItem: state => state.selectedSchoolItem,
  selectedItemSchoolGroupStore: state => state.selectedItemSchoolGroupStore,
  selectedItemClassGroupStore: state => state.selectedItemClassGroupStore,
  selectedItemGroupForSchoolDiaStore: state => state.selectedItemGroupForSchoolDiaStore,
  selectedItemGroupForClassDiaStore: state => state.selectedItemGroupForClassDiaStore,

  schoolStoryList: state => state.schoolStoryList,
  classStoryList: state => state.classStoryList,

  value: state => state.value,
  isNewPost: state => state.isNewPost,

  previewData: state => state.previewData,
}

// mutations
export const mutations = {
    [types.IS_SCHOOLSPACE] (state,  isSchoolSpace ) {
        state.isSchoolSpace = isSchoolSpace
    },
    [types.SELECT_SCHOOL_ITEM] (state,  selectedSchoolItem ) {
        state.selectedSchoolItem = selectedSchoolItem
    },
    [types.SCHOOL_ITEM_GROUP] (state,  selectedItemSchoolGroupStore ) {
        state.selectedItemSchoolGroupStore = selectedItemSchoolGroupStore
    },
    [types.CLASS_ITEM_GROUP] (state,  selectedItemClassGroupStore ) {
        state.selectedItemClassGroupStore = selectedItemClassGroupStore
    },
    [types.SCHOOL_ITEM_GROUP_FOR_DIA] (state,  selectedItemGroupForSchoolDiaStore ) {
        state.selectedItemGroupForSchoolDiaStore = selectedItemGroupForSchoolDiaStore
    },
    [types.CLASS_ITEM_GROUP_FOR_DIA] (state,  selectedItemGroupForClassDiaStore ) {
        state.selectedItemGroupForClassDiaStore = selectedItemGroupForClassDiaStore
    },
    [types.SCHOOL_STORY_LIST] (state,  schoolStoryList ) {
        state.schoolStoryList = schoolStoryList
    },
    [types.CLASS_STORY_LIST] (state,  classStoryList ) {
        state.classStoryList = classStoryList
    },
    [types.MO_BOTTOM_NAV_VALUE] (state,  value ) {
        state.value = value
    },
    [types.IS_NEW_POST] (state,  isNewPost ) {
        state.isNewPost = isNewPost
    },
    [types.PREVIEW_DATA] (state,  previewData ) {
        state.previewData = previewData
    },
}

// actions
export const actions = {
    onIsSchoolSpace ({ commit }, payload) {
        commit(types.IS_SCHOOLSPACE, payload)
    },
    onSelectedSchoolItem ({ commit }, payload) {
        commit(types.SELECT_SCHOOL_ITEM, payload)
    },
    onSelectedItemSchoolGroupStore ({ commit }, payload) {
        commit(types.SCHOOL_ITEM_GROUP, payload)
    },
    onSelectedItemClassGroupStore ({ commit }, payload) {
        commit(types.CLASS_ITEM_GROUP, payload)
    },
    onSelectedItemGroupForSchoolDiaStore ({ commit }, payload) {
        commit(types.SCHOOL_ITEM_GROUP_FOR_DIA, payload)
    },
    onSelectedItemGroupForClassDiaStore ({ commit }, payload) {
        commit(types.CLASS_ITEM_GROUP_FOR_DIA, payload)
    },
    onSchoolStoryList ({ commit }, payload) {
        commit(types.SCHOOL_STORY_LIST, payload)
    },
    onClassStoryList ({ commit }, payload) {
        commit(types.CLASS_STORY_LIST, payload)
    },
    onMoBottomNavValue ({ commit }, payload) {
        commit(types.MO_BOTTOM_NAV_VALUE, payload)
    },
    onMoBottomNavIsNewPost ({ commit }, payload) {
        commit(types.IS_NEW_POST, payload)
    },
    onPreviewData ({ commit }, payload) {
        commit(types.PREVIEW_DATA, payload)
    },
}
