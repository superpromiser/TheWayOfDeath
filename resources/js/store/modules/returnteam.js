import * as types from '../mutation-types'
// state
export const state = {
  name: '',
  avatar: null,
  leader: null,
  remainTeamArr: null,
  todayReturnTeamArr: null,
  isDetail: false,
  detailData: null,
  updatedDetailData: null,
  isDetailView: false,
  isCreateNewRemain: false,
}

// getters
export const getters = {
  name: state => state.name,
  avatar: state => state.avatar,
  leader: state => state.leader,
  remainTeamArr: state => state.remainTeamArr,
  todayReturnTeamArr: state => state.todayReturnTeamArr,
  isDetail: state => state.isDetail,
  detailData: state => state.detailData,
  updatedDetailData: state => state.updatedDetailData,
  isDetailView: state => state.isDetailView,
  isCreateNewRemain: state => state.isCreateNewRemain,
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
    [types.STORE_IS_DETAIL] (state, isDetail ) {
        state.isDetail = isDetail
    },
    [types.STORE_DETAIL_DATA] (state, detailData ) {
        state.detailData = detailData
    },
    [types.STORE_UPDATED_DETAIL_DATA] (state, updatedDetailData ) {
        state.updatedDetailData = updatedDetailData
    },
    [types.STORE_IS_DETAIL_VIEW] (state, isDetailView ) {
        state.isDetailView = isDetailView
    },
    [types.STORE_IS_CREATE_NEW_REMAIN] (state, isCreateNewRemain ) {
        state.isCreateNewRemain = isCreateNewRemain
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
    storeIsDetail ({ commit }, payload) {
        commit(types.STORE_IS_DETAIL, payload)
    },
    storeDetailData ({ commit }, payload) {
        commit(types.STORE_DETAIL_DATA, payload)
    },
    storeUpdatedDetailData ({ commit }, payload) {
        commit(types.STORE_UPDATED_DETAIL_DATA, payload)
    },
    storeIsDetailView ({ commit }, payload) {
        commit(types.STORE_IS_DETAIL_VIEW, payload)
    },
    storeIsCreateNewRemain ({ commit }, payload) {
        commit(types.STORE_IS_CREATE_NEW_REMAIN, payload)
    },
}
