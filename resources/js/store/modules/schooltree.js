import * as types from '../mutation-types'
import Cookies from 'js-cookie'
// state
export const state = {
    schoolTree:  Cookies.get('schoolTree') ? JSON.parse(Cookies.get('schoolTree')) : null,
    schoolData:  Cookies.get('schoolData') ? JSON.parse(Cookies.get('schoolData')) : null,
    memberData:  Cookies.get('memberData') ? JSON.parse(Cookies.get('memberData')) : null,
    chooseableSchoolTree: null,
}

// getters
export const getters = {
    schoolTree: state => state.schoolTree,
    schoolData: state => state.schoolData,
    memberData: state => state.memberData,
    chooseableSchoolTree: state => state.chooseableSchoolTree,
}

// mutations
export const mutations = {
    [types.STORE_SCHOOL_TREE] (state,  schoolTree ) {
        state.schoolTree = schoolTree
        Cookies.set('schoolTree', schoolTree, { expires:  365 })
    },
    [types.STORE_SCHOOL_DATA] (state,  schoolData ) {
        state.schoolData = schoolData
        console.log('mutations',schoolData)
        Cookies.set('schoolData', schoolData, { expires:  365000 })
    },  
    [types.STORE_MEMBER_DATA] (state,  memberData ) {
        state.memberData = memberData
        Cookies.set('memberData', memberData, { expires:  365 })
    },
    [types.STORE_CHOOSEABLE_SCHOOL_TREE] (state,  chooseableSchoolTree ) {
        state.chooseableSchoolTree = chooseableSchoolTree
    },
}

// actions
export const actions = {
    storeSchoolTree ({ commit }, payload) {
        commit(types.STORE_SCHOOL_TREE, payload)
    },
    storeSchoolData ({ commit }, payload) {
        commit(types.STORE_SCHOOL_DATA, payload)
    },
    storeMemberData ({ commit }, payload) {
        commit(types.STORE_MEMBER_DATA, payload)
    },
    storeChooseableSchoolTree ({ commit }, payload) {
        commit(types.STORE_CHOOSEABLE_SCHOOL_TREE, payload)
    },
}