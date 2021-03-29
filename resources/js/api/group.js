import axios from 'axios'

function getGroup(payload){
    return axios.get('/api/v1/group',{params:payload})
}

function createGroup(payload){
    return axios.post('/api/v1/group',payload)
}

function deleteGroup(payload){
    return axios.delete('/api/v1/group',{data:payload})
}

export{
    getGroup,
    createGroup,
    deleteGroup,
}