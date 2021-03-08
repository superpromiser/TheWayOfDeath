import axios from 'axios'

function createSchool(payload){
    return axios.post('/api/v1/school', payload);
}
function updateSchool(payload){
    return axios.put('/api/v1/school', payload);
}
function getSchool(payload){
    return axios.get('/api/v1/school', payload);
}
function deleteSchool(payload){
    return axios.delete('/api/v1/school', {data : payload});
}

export{
    createSchool,
    updateSchool,
    getSchool,
    deleteSchool,
}