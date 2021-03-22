import axios from 'axios';

function createAnswerQuestionnaire(payload){
    return axios.post('/api/v1/answerQuestionnaire',payload)
}

function getAnswerQuestionnaire(payload){
    return axios.get('/api/v1/answerQuestionnaire',{params:payload})
}

function createAnswerVoting(payload){
    return axios.post('/api/v1/answerVoting',payload)
}

function getAnswerVoting(payload){
    return axios.get('/api/v1/answerVoting',{params:payload})
}

export{
    createAnswerQuestionnaire,
    getAnswerQuestionnaire,
    createAnswerVoting,
    getAnswerVoting,
}