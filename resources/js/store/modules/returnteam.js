import * as types from '../mutation-types'
// state
export const state = {
  name: '',
  avatar: null,
  leader: null,
}

// getters
export const getters = {
  name: state => state.name,
  avatar: state => state.avatar,
  leader: state => state.leader,
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
}
