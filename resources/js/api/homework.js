import axios from 'axios'

function getHomeworkData(payload){
    return axios.get('/api/v1/homeworkData',{params:payload})
}

function createHomeworkData(payload){
    return axios.post('/api/v1/homeworkData',payload)
}

export{
    getHomeworkData,
    createHomeworkData
}