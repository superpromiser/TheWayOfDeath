import axios from 'axios';

function getSafeStudy(payload){
    return axios.get('/api/v1/safeStudy',{params:payload})
}

function createSafeStudy(payload){
    return axios.post('/api/v1/safeStudy',payload)
}

function updateSafeStudy(payload){
    return axios.put('/api/v1/safeStudy',payload)
}

function deleteSafeStudy(payload){
    return axios.delete('/api/v1/safeStudy',{data:payload})
}

export{
    getSafeStudy,
    createSafeStudy,
    updateSafeStudy,
    deleteSafeStudy,
}
