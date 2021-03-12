import axios from 'axios'


//school API
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

//school Manager API
function createSchoolManager(payload){
    return axios.post('/api/v1/school/manager', payload);
}
function updateSchoolManager(payload){
    return axios.put('/api/v1/school/manager', payload);
}
function getSchoolManager(payload){
    return axios.get('/api/v1/school/manager', payload);
}
function deleteSchoolManager(payload){
    return axios.delete('/api/v1/school/manager', {data : payload});
}

function getSchoolTree(){
    return axios.get('/api/v1/school/tree');
}


export{
    createSchool,
    updateSchool,
    getSchool,
    deleteSchool,
    createSchoolManager,
    updateSchoolManager,
    getSchoolManager,
    deleteSchoolManager,
    getSchoolTree,
    
}