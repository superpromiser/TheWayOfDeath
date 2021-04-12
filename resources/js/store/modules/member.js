import * as types from '../mutation-types'
// state
export const state = {
  classGroupList: null,
  selectedGroup: null,
  selectedOne: null,
}

// getters
export const getters = {
  classGroupList: state => state.classGroupList,
  selectedGroup: state => state.selectedGroup,
  selectedOne: state => state.selectedOne,
}

// mutations
export const mutations = {
    [types.STORE_CLASS_GROUP_LIST] (state, classGroupList ) {
        state.classGroupList = classGroupList
    },
    [types.STORE_SELECTED_GROUP] (state, selectedGroup ) {
        state.selectedGroup = selectedGroup
    },
    [types.STORE_SELECTED_ONE] (state, selectedOne ) {
        state.selectedOne = selectedOne
    },
}

// actions
export const actions = {
    storeClassGroupList ({ commit }, payload) {
        commit(types.STORE_CLASS_GROUP_LIST, payload)
    },
    storeSelectedGroup ({ commit }, payload) {
        commit(types.STORE_SELECTED_GROUP, payload)
    },
    storeSelectedOne ({ commit }, payload) {
        commit(types.STORE_SELECTED_ONE, payload)
    },
}
