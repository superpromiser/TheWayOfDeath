import axios from 'axios';

function getAttendaceData(payload){
    return axios.get('/api/v1/attendance',{params:payload})
}

function getLessonAttendanceData(payload){
    return axios.get('/api/v1/lessonAttendance',{params:payload});
}

function createLessonAttendanceData(payload){
    return axios.post('/api/v1/lessonAttendance',payload)
}

function updateLessonAttendanceData(payload){
    return axios.put('/api/v1/lessonAttendance',payload)
}

function deleteLessonAttendanceData(payload){
    return axios.delete('/api/v1/lessonAttendance',{data:payload})
}

export{
    getAttendaceData,
    getLessonAttendanceData,
    createLessonAttendanceData,
    updateLessonAttendanceData,
    deleteLessonAttendanceData,
}