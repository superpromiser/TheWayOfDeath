import * as types from '../mutation-types'
// state
export const state = {
    schoolTree: [],
    chooseableSchoolTree: [],
}

// getters
export const getters = {
    schoolTree: state => state.schoolTree,
    chooseableSchoolTree: state => state.chooseableSchoolTree,
}

// mutations
export const mutations = {
    [types.STORE_SCHOOL_TREE] (state, { schoolTree }) {
        state.schoolTree = schoolTree
    },
    [types.STORE_CHOOSEABLE_SCHOOL_TREE] (state, { chooseableSchoolTree }) {
        state.chooseableSchoolTree = chooseableSchoolTree
    },
}

// actions
export const actions = {
    storeSchoolTree ({ commit }, payload) {
        console.log("!!!", payload)
        commit(types.STORE_SCHOOL_TREE, payload)
    },
    storeChooseableSchoolTree ({ commit }, payload) {
        console.log("###", payload)
        commit(types.STORE_CHOOSEABLE_SCHOOL_TREE, payload)
    },
}
