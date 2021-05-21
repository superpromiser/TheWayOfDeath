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

function getAppHomeworkData(payload){
    return axios.get('/api/v1/appHomeworkData',{params:payload})
}

function getMySubject(payload){
    return axios.get('/api/v1/mySubject',{params:payload})
}



export{
    getHomeworkData,
    createHomeworkData,
    getHomeworkResult,
    createHomeworkResult,
    getAppHomeworkData,
    getMySubject,
}