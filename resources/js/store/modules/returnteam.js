import * as types from '../mutation-types'
// state
export const state = {
  name: '',
  avatar: null,
  leader: null,
  remainTeamArr: null,
  todayReturnTeamArr: null,
}

// getters
export const getters = {
  name: state => state.name,
  avatar: state => state.avatar,
  leader: state => state.leader,
  remainTeamArr: state => state.remainTeamArr,
  todayReturnTeamArr: state => state.todayReturnTeamArr,
}

// mutations
export const mutations = {
    [types.STORE_RETURN_TEAM_NAME] (state, name ) {
        state.name = name
    },
    [types.STORE_RETURN_TEAM_AVATAR] (state, avatar ) {
        state.avatar = avatar
    },
    [types.STORE_RETURN_TEAM_LEADER] (state, leader ) {
        state.leader = leader
    },
    [types.STORE_REMAIN_TEAM_ARR] (state, remainTeamArr ) {
        state.remainTeamArr = remainTeamArr
    },
    [types.STORE_TODAY_RETURN_TEAM_ARR] (state, todayReturnTeamArr ) {
        state.todayReturnTeamArr = todayReturnTeamArr
    },
}

// actions
export const actions = {
    storeReturnTeamName ({ commit }, payload) {
        commit(types.STORE_RETURN_TEAM_NAME, payload)
    },
    storeReturnTeamAvatar ({ commit }, payload) {
        commit(types.STORE_RETURN_TEAM_AVATAR, payload)
    },
    storeReturnTeamLeader ({ commit }, payload) {
        commit(types.STORE_RETURN_TEAM_LEADER, payload)
    },
    storeRemainTeamArr ({ commit }, payload) {
        commit(types.STORE_REMAIN_TEAM_ARR, payload)
    },
    storeTodayReturnTeamArr ({ commit }, payload) {
        commit(types.STORE_TODAY_RETURN_TEAM_ARR, payload)
    },
}