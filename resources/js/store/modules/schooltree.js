import * as types from '../mutation-types'
// state
export const state = {
    schoolTree: [],
}

// getters
export const getters = {
    schoolTree: state => state.schoolTree,
}

// mutations
export const mutations = {
    [types.STORE_SCHOOL_TREE] (state, { schoolTree }) {
        state.schoolTree = schoolTree
    },
}

// actions
export const actions = {
    storeSchoolTree ({ commit }, payload) {
        console.log("!!!", payload)
        commit(types.STORE_SCHOOL_TREE, payload)
    },
}
