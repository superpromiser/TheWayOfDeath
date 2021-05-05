import axios from 'axios';

function getRegname(payload){
    return axios.get('/api/v1/regname',{params:payload});
}

function getAnswerDataOne(payload){
    return axios.get('/api/v1/regname/answer/one', {params: payload});
}

function getAnswerList(payload){
    return axios.get('/api/v1/regname/answer', {params: payload});
}

function createRegname(payload){
    return axios.post('/api/v1/regname',payload)
}

function answerRegname(payload){
    return axios.post('/api/v1/regname/answer',payload)
}

function updateAnswerRegname(payload){
    return axios.put('/api/v1/regname/answer',payload)
}

function updateRegname(payload){
    return axios.put('/api/v1/regname',payload)
}

function deleteRegname(payload){
    return axios.delete('/api/v1/regname',{data:payload})
}

function getTemplateCnt(payload){
    return axios.get('/api/v1/regname/templateCnt',{params:payload})
}

function getTemplateList(payload){
    return axios.get('/api/v1/regname/template',{params:payload})
}

function createTemplate(payload){
    return axios.post('/api/v1/regname/template',payload)
}

function deleteTemplate(payload){
    return axios.delete('/api/v1/regname/template',{data:payload})
}

export{
    getRegname,
    createRegname,
    updateRegname,
    deleteRegname,
    answerRegname,
    getAnswerDataOne,
    updateAnswerRegname,
    getAnswerList,
    getTemplateCnt,
    getTemplateList,
    createTemplate,
    deleteTemplate,
}