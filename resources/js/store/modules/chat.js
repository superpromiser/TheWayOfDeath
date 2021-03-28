import * as types from '../mutation-types';

// state
export const state = {
    usersStore: null,
    contactListStore: null,
    chatGroupListStore: null,
    totalNewMessageCountStore: -1,
}

// getters
export const getters = {
    usersStore: state => state.usersStore,
    contactListStore: state => state.contactListStore,
    chatGroupListStore: state => state.chatGroupListStore,
    totalNewMessageCountStore: state => state.totalNewMessageCountStore,
}

// mutations
export const mutations = {
    [types.STORE_USERS] (state,  payload ) {
        state.usersStore = payload;
    },
    [types.STORE_CONTACTLIST] (state,  payload ) {
        state.contactListStore = payload;
    },
    [types.STORE_GROUPLIST] (state,  payload ) {
        state.chatGroupListStore = payload;
    },
    [types.STORE_TOTALNEWMESSAGECOUNT] (state,  payload ) {
        state.totalNewMessageCountStore = payload;
    },
    
    
}

// actions
export const actions = {
    storeUsers ({ commit }, payload) {
        commit(types.STORE_USERS, payload)
    },
    storeContactList ({ commit }, payload) {
        commit(types.STORE_CONTACTLIST, payload)
    },
    storeGroupList ({ commit }, payload) {
        commit(types.STORE_GROUPLIST, payload)
    },
    storeTotalNewMsgCount ({ commit }, payload) {
        commit(types.STORE_TOTALNEWMESSAGECOUNT, payload)
    },
}
