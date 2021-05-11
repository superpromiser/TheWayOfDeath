import axios from 'axios';

function getAttendanceData(payload){
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

function getStatData(payload){
    return axios.get('/api/v1/statAttendance',{params:payload})
}

function getStatLessonAttData(payload){
    return axios.get('/api/v1/statLessonAttData',{params:payload});
}

function getStatDetailAttData(payload){
    return axios.get('/api/v1/statDetailAttData',{params:payload});
}

function getLessonItem(payload){
    return axios.get('/api/v1/lessonItem',{params:payload})
}

export{
    getAttendanceData,
    getLessonAttendanceData,
    createLessonAttendanceData,
    updateLessonAttendanceData,
    deleteLessonAttendanceData,
    getStatData,
    getStatLessonAttData,
    getStatDetailAttData,
    getLessonItem,
}