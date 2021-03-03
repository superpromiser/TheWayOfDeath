import * as types from '../mutation-types'
// state
export const state = {
  mini: false,
  drawer: true
}

// getters
export const getters = {
  mini: state => state.mini,
  drawer: state => state.drawer,
}

// mutations
export const mutations = {
    [types.TOGGLE_MINI_DRAWER] (state, { mini }) {
        state.mini = mini
    },
    [types.TURN_DRAWER] (state, { drawer }) {
        state.drawer = drawer
    },
}

// actions
export const actions = {
    toggleMiniDrawer ({ commit }, payload) {
        commit(types.TOGGLE_MINI_DRAWER, payload)
    },
    turnDrawer ({ commit }, payload) {
        commit(types.TURN_DRAWER, payload)
    },
}
