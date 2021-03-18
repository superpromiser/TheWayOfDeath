import axios from 'axios'


//manager subject API
function createSubject(payload){
    return axios.post('/api/v1/manager/subject', payload);
}
function updateSubject(payload){
    return axios.put('/api/v1/manager/subject', payload);
}
function getSubject(payload){
    return axios.get('/api/v1/manager/subject', payload);
}
function deleteSubject(payload){
    return axios.delete('/api/v1/manager/subject', {data : payload});
}

export{
    createSubject,
    updateSubject,
    getSubject,
    deleteSubject,
    
}