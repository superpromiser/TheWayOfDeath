import axios from 'axios';

function getShare(payload){
    return axios.get('/api/v1/share',{params:payload});
}

function createShare(payload){
    return axios.post('/api/v1/share',payload)
}

function updateShare(payload){
    return axios.put('/api/v1/share',payload)
}

function deleteShare(payload){
    return axios.delete('/api/v1/share',{data:payload})
}

function getTemplateCnt(payload){
    return axios.get('/api/v1/shareTempCnt',{params:payload})
}

function getTempList(payload){
    return axios.get('/api/v1/shareTemp',{params:payload})
}

function createTemp(payload){
    return axios.get('/api/v1/shareTemp',payload)
}

function deleteTemp(payload){
    return axios.delte('/api/v1/shareTemp',{data:payload})
}

export{
    getShare,
    createShare,
    updateShare,
    deleteShare,
    getTemplateCnt,
    getTempList,
    createTemp,
    deleteTemp,
}