import * as types from '../mutation-types';

// state
export const state = {
    usersStore: null,
    addressedUsersStore: null,
    contactListStore: null,
    chatGroupListStore: null,
    totalNewMessageCountStore: -1,
    bot: null,
}

// getters
export const getters = {
    usersStore: state => state.usersStore,
    contactListStore: state => state.contactListStore,
    chatGroupListStore: state => state.chatGroupListStore,
    addressedUsersStore: state => state.addressedUsersStore,
    totalNewMessageCountStore: state => state.totalNewMessageCountStore,
    bot: state => state.bot,
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
    [types.STORE_ADDRESSEDUSERS] (state,  payload ) {
        state.addressedUsersStore = payload;
    },
    [types.STORE_TOTALNEWMESSAGECOUNT] (state,  payload ) {
        state.totalNewMessageCountStore = payload;
    },
    [types.STORE_BOT] (state,  payload ) {
        state.bot = payload;
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
    storeAddressedUsers ({ commit }, payload) {
        commit(types.STORE_ADDRESSEDUSERS, payload)
    },
    storeTotalNewMsgCount ({ commit }, payload) {
        commit(types.STORE_TOTALNEWMESSAGECOUNT, payload)
    },
    storeBot ({ commit }, payload) {
        commit(types.STORE_BOT, payload)
    },
}
