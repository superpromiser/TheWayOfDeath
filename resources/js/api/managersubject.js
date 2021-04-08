import axios from 'axios'


//manager subject API
function createSubject(payload){
    return axios.post('/api/v1/manager/subject', payload);
}
function updateSubject(payload){
    return axios.put('/api/v1/manager/subject', payload);
}
function getSubject(payload){
    return axios.get('/api/v1/manager/subject', {params: payload});
}
function deleteSubject(payload){
    return axios.delete('/api/v1/manager/subject', {data : payload});
}
function createSession(payload){
    return axios.post('/api/v1/manager/session', payload);
}
function updateSession(payload){
    return axios.put('/api/v1/manager/session', payload);
}
function getSession(payload){
    return axios.get('/api/v1/manager/session', payload);
}
function deleteSession(payload){
    return axios.delete('/api/v1/manager/session', {data : payload});
}

function createScheduleTeacher(payload){
    return axios.post('/api/v1/manager/schedule/teacher', payload);
}
function updateScheduleTeacher(payload){
    return axios.put('/api/v1/manager/schedule/teacher', payload);
}
function getScheduleTeacher(payload){
    return axios.get('/api/v1/manager/schedule/teacher', {params: payload});
}
function deleteScheduleTeacher(payload){
    return axios.delete('/api/v1/manager/schedule/teacher', {data : payload});
}

export{
    createSubject,
    updateSubject,
    getSubject,
    deleteSubject,
    createSession,
    updateSession,
    getSession,
    deleteSession,
    createScheduleTeacher,
    updateScheduleTeacher,
    getScheduleTeacher,
    deleteScheduleTeacher
}