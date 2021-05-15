import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'
// import {state, getters, mutations, actions} from './mo'

// state
export const state = {
  user: null,
  token: Cookies.get('token')
}

// getters
export const getters = {
  user: state => state.user,
  token: state => state.token,
  check: state => state.user !== null
}

// mutations
export const mutations = {
  [types.SAVE_TOKEN] (state, { token, remember }) {
    state.token = token
    Cookies.set('token', token, { expires: remember ? 365 : null })
  },

  [types.FETCH_USER_SUCCESS] (state, { user }) {
    state.user = user
  },

  [types.FETCH_USER_FAILURE] (state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.LOGOUT] (state) {
    state.user = null
    state.token = null

    Cookies.remove('token')
  },

  [types.UPDATE_USER] (state, { user }) {
    state.user = user
  }
}

// actions
export const actions = {
  saveToken ({ commit, dispatch }, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser ({ commit }) {
    try {
      const { data } = await axios.get('/api/v1/user')
      commit(types.FETCH_USER_SUCCESS, { user: data })
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  saveUserState ({ commit }, payload) {
    //console.log('++++++++',payload)
    commit(types.FETCH_USER_SUCCESS, { user: payload } )
  },

  updateUser ({ commit }, payload) {
    commit(types.UPDATE_USER, payload)
  },

  async logout ({ commit }) {
    try {
      await axios.post('/api/v1/logout')
    } catch (e) { }


    //clear vuex for mobile data
    commit('mo/IS_SCHOOLSPACE', true, { root: true })
    commit('mo/SELECT_SCHOOL_ITEM', null, { root: true })
    commit('mo/SCHOOL_ITEM_GROUP', null, { root: true })
    commit('mo/CLASS_ITEM_GROUP', null, { root: true })
    commit('mo/SCHOOL_ITEM_GROUP_FOR_DIA', null, { root: true })
    commit('mo/CLASS_ITEM_GROUP_FOR_DIA', null, { root: true })
    commit('mo/SCHOOL_STORY_LIST', null, { root: true })
    commit('mo/CLASS_STORY_LIST', null, { root: true })
    commit('mo/MO_BOTTOM_NAV_VALUE', null, { root: true })
    commit('mo/IS_NEW_POST', null, { root: true })
    commit('mo/PREVIEW_DATA', null, { root: true })
    commit('mo/PUBLISH_CONTENT', null, { root: true })
    commit('mo/PUBLISH_SPEC_USER_LIST', null, { root: true })
    commit('mo/BACK_WITHOUT_SELECT', false, { root: true })
    commit('mo/CLICKED_CHANGE', false, { root: true })
    commit('mo/BACK_WITH_CHANGE', false, { root: true })

    //clear localstorage for schooldata

    commit('schooltree/STORE_SCHOOL_DATA', null, { root: true })

    
    commit(types.LOGOUT)

    
  },

  async fetchOauthUrl (ctx, { provider }) {
    const { data } = await axios.post(`/api/v1/oauth/${provider}`)

    return data.url
  }
}
