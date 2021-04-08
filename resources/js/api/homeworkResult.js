import axios from 'axios'

function getHomeworkResult(){

}

function createTeacherAnswer(payload){
   return axios.put('/api/v1/homeworkTeacherAnswer',payload)
}

export{
    getHomeworkResult,
    createTeacherAnswer,
}