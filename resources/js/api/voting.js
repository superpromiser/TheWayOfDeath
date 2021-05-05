import axios from 'axios';

function getVoting(payload){
    return axios.get('/api/v1/voting',{params:payload})
}

function createVoting(payload){
    return axios.post('/api/v1/voting',payload);
}

function updateVoting(payload){
    return axios.put('/api/v1/voting',payload);
}

function deleteVoting(payload){
    return axios.delete('/api/v1/voting',{data:payload})
}

function getTemplateList(payload){
    return axios.get('/api/v1/voting/template',{params:payload});
}

function getTemplateCnt(payload){
    return axios.get('/api/v1/voting/templateCnt',{params:payload});
}

function createTemplate(payload){
    return axios.post('/api/v1/voting/template',payload)
}

function deleteTemplate(payload){
    return axios.delete('/api/v1/voting/template',{data:payload});
}


export{
    getVoting,
    createVoting,
    updateVoting,
    deleteVoting,
    getTemplateList,
    createTemplate,
    getTemplateCnt,
    deleteTemplate
}