import axios from 'axios';

function answerQuestionnaire(payload){
    return axios.post('/api/v1/answerQuestionnaire',payload)
}

export{
    answerQuestionnaire,
}