import axios from 'axios'

function getHomeworkData(payload){
    return axios.get('/api/v1/homeworkData',{params:payload})
}

function createHomeworkData(payload){
    return axios.post('/api/v1/homeworkData',payload)
}

function getHomeworkResult(payload){
    return axios.get('/api/v1/homeworkResult',{params:payload})
}

function createHomeworkResult(payload){
    return axios.post('/api/v1/homeworkResult',payload)
}

export{
    getHomeworkData,
    createHomeworkData,
    getHomeworkResult,
    createHomeworkResult
}