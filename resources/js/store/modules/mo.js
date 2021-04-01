import * as types from '../mutation-types'
// state
export const state = {
  isSchoolSpace: true,
  selectedSchoolItem: null,

}

// getters
export const getters = {
  isSchoolSpace: state => state.isSchoolSpace,
  selectedSchoolItem: state => state.selectedSchoolItem,
}

// mutations
export const mutations = {
    [types.IS_SCHOOLSPACE] (state,  isSchoolSpace ) {
        state.isSchoolSpace = isSchoolSpace
    },
    [types.SELECT_SCHOOL_ITEM] (state,  selectedSchoolItem ) {
        state.selectedSchoolItem = selectedSchoolItem
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
}
