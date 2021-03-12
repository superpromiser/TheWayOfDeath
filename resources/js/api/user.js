import axios from 'axios'


//staff API
function createStaff(payload){
    return axios.post('/api/v1/staff', payload);
}
function updateStaff(payload){
    return axios.put('/api/v1/staff', payload);
}
function getStaff(payload){
    return axios.get('/api/v1/staff', payload);
}

//student API
function createStudent(payload){
    return axios.post('/api/v1/student', payload);
}
function updateStudent(payload){
    return axios.put('/api/v1/student', payload);
}
function getStudent(payload){
    return axios.get('/api/v1/student', payload);
}


function deleteUser(payload){
    return axios.delete('/api/v1/users', {data : payload});
}



export{
    createStaff,
    updateStaff,
    getStaff,
    createStudent,
    updateStudent,
    getStudent,
    deleteUser,
    
}