import axios from 'axios'

function getHomeworkResult(){

}

function createTeacherAnswer(payload){
   return axios.put('/api/v1/homeworkTeacherAnswer',payload)
}

function getOfflineTeacherAnswer(payload){
    return axios.get('/api/v1/offlineTeacher',{params:payload});
}

function createOfflineTeacherAnswer(payload){
    return axios.post('/api/v1/offlineTeacher',payload)
}

function getOfflineStudent(payload){
    return axios.get('/api/v1/offlineStudent',{params:payload})
}

function getOnlineTeacherCheck(payload){
    return axios.get('/api/v1/onlineTeacherCheck',{params:payload})
}

export{
    getHomeworkResult,
    createTeacherAnswer,
    getOfflineTeacherAnswer,
    createOfflineTeacherAnswer,
    getOfflineStudent,
    getOnlineTeacherCheck,
}