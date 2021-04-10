import * as types from '../mutation-types'
// state
export const state = {
  alarmData: null,
}

// getters
export const getters = {
  alarmData: state => state.alarmData,
}

// mutations
export const mutations = {
    [types.STORE_ALARM_DATA] (state, alarmData ) {
        state.alarmData = alarmData
    },
}

// actions
export const actions = {
    storeAlarm ({ commit }, payload) {
        commit(types.STORE_ALARM_DATA, payload)
    },
}
