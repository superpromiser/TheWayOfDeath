import axios from 'axios'

function getQuestionnaire(payload){
    return axios.get('/api/v1/questionnaire',{params:payload});
}

function createQuestionnaire(payload){
    return axios.post('/api/v1/questionnaire',payload)
}

function updateQuestionnaire(payload){
    return axios.put('/api/v1/questionnaire',payload);
}

function deleteQuestionnaire(payload){
    return axios.delete('/api/v1/questionnaire',{data: payload})
}

function getQuestionnaireTemp(payload){
    return axios.get('/api/v1/questionnaireTemp',{params:payload});
}

function createQuestionnaireTemp(payload){
    return axios.post('/api/v1/questionnaireTemp',payload);
}

function updateQuestionnaireTemp(payload){
    return axios.put('/api/v1/questionnaireTemp',payload);
}

function deleteQuestionnaireTemp(payload){
    return axios.delete('/api/v1/questionnaireTemp',{data:payload})
}

function getQuestionnaireTempCnt(payload){
    return axios.get('/api/v1/questionnaireTempCnt',{params:payload});
}

export{
    getQuestionnaire,
    createQuestionnaire,
    updateQuestionnaire,
    deleteQuestionnaire,
    getQuestionnaireTemp,
    createQuestionnaireTemp,
    updateQuestionnaireTemp,
    deleteQuestionnaireTemp,
    getQuestionnaireTempCnt,
}