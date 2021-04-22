import * as types from '../mutation-types';
import Cookies from 'js-cookie'

//state
export const state = {
    authToken:Cookies.get('fenceToken')
}

//getters
export const getters = {
    authToken: state=>state.authToken,
}

//mutations
export const mutations = {
    [types.STORE_FENCE_AUTH_TOKEN] (state,authToken){
        state.authToken = authToken
        let expiredTime = new Date(new Date().getTime() + 105 * 60 * 1000);

        Cookies.set('fenceToken',authToken,{expires:expiredTime})
    }
}

//actions
export const actions = {
    storeAuthToken({commit},payload){
        commit(types.STORE_FENCE_AUTH_TOKEN,payload)
    }
}