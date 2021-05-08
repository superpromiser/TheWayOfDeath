import axios from 'axios'

function getClub(payload){
    return axios.get('/api/v1/club',{params:payload})
}

function createClub(payload){
    return axios.post('/api/v1/club',payload)
}

function deleteClub(payload){
    return axios.delete('/api/v1/club',{data:payload})
}


function getPendingGroupMember(payload){
    return axios.get('/api/v1/pendingGroupMember',{params:payload});
}

function getAllowGroupMember(payload){
    return axios.get('/api/v1/allowGroupMember',{params:payload});
}

function getAllGroupMember(payload){
    return axios.get('/api/v1/allGroupMember',{params:payload});
}

function getGroupMember(payload){
    return axios.get('/api/v1/groupMember',{params:payload})
}

function getCanGroupMember(payload){
    return axios.get('/api/v1/canGroupMember',{params:payload})
}

function addGroupMember(payload){
    return axios.post('/api/v1/groupMember',payload);
}

function updateGroupMember(payload){
    return axios.put('/api/v1/groupMember',payload)
}

function deleteGroupMember(payload){
    return axios.delete('/api/v1/groupMember',{data:payload})
}

function denyGroupMember(payload){
    return axios.delete('/api/v1/denyGroupMember',{data:payload});
}

function getStudentIdUser(payload){
    return axios.get('/api/v1/studentIdUser',{params:payload});
}

function createStudentIdUser(payload){
    return axios.post('/api/v1/studentIdUser',payload)
}

function getSeatData(payload){
    return axios.get('/api/v1/seat',{params:payload})
}

function createSeatData(payload){
    return axios.post('/api/v1/seat',payload)
}

function updateSeatData(payload){
    return axios.put('/api/v1/seat',payload)
}

function updateClub(payload){
    return axios.put('/api/v1/club',payload)
}

export{
    getClub,
    createClub,
    deleteClub,
    getPendingGroupMember,
    getAllowGroupMember,
    getAllGroupMember,
    getGroupMember,
    getCanGroupMember,
    addGroupMember,
    updateGroupMember,
    deleteGroupMember,
    denyGroupMember,
    getSeatData,
    createSeatData,
    updateSeatData,
    getStudentIdUser,
    createStudentIdUser,
    updateClub,
}