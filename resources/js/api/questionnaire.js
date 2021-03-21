import axios from 'axios'

function getQuestionnaire(){
    return axios.get('/api/v1/questionnaire');
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

function getQuestionnaireTemp(){
    return axios.get('/api/v1/questionnaireTemp');
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


export{
    getQuestionnaire,
    createQuestionnaire,
    updateQuestionnaire,
    deleteQuestionnaire,
    getQuestionnaireTemp,
    createQuestionnaireTemp,
    updateQuestionnaireTemp,
    deleteQuestionnaireTemp
}