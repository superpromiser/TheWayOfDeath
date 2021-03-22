import axios from 'axios';

function getEvaluation(){
    return axios.get('/api/v1/class/evaluation')
}

function createEvaluation(payload){
    return axios.post('/api/v1/class/evaluation',payload)
}

function updateEvaluation(payload){
    return axios.put('/api/v1/class/evaluation',payload)
}

function deleteEvaluation(){
    return axios.delete('/api/v1/class/evaluation',{data:payload})
}

export{
    getEvaluation,
    createEvaluation,
    updateEvaluation,
    deleteEvaluation
}