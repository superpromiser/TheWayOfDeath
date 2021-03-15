import axios from 'axios'

function getQuestionnaire(){
    return axios.get('api/v1/questionnaire');
}

function createQuestionnaire(payload){
    return axios.post('api/v1/questionnaire',payload)
}

function updateQuestionnaire(payload){
    return axios.put('api/v1/questionnaire',payload);
}

function deleteQuestionnaire(payload){
    return axios.delete('/api/v1/questionnaire',{data: payload})
}

export{
    getQuestionnaire,
    createQuestionnaire,
    updateQuestionnaire,
    deleteQuestionnaire,
}