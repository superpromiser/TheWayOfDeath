import axios from 'axios'


//school API
function createStaff(payload){
    return axios.post('/api/v1/staff', payload);
}
function updateStaff(payload){
    return axios.put('/api/v1/staff', payload);
}
function getStaff(payload){
    return axios.get('/api/v1/staff', payload);
}


function deleteUser(payload){
    return axios.delete('/api/v1/users', {data : payload});
}



export{
    createStaff,
    updateStaff,
    getStaff,
    deleteUser,
    
}