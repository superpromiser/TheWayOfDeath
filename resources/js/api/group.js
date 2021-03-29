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

function addGroupMember(payload){
    return axios.post('/api/v1/groupMember',payload);
}

export{
    getClub,
    createClub,
    deleteClub,
    addGroupMember,
}