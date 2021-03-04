import axios from 'axios';

function getUserRole(){
    return axios.get('/api/v1/userRole');
}

export{
    getUserRole,
}