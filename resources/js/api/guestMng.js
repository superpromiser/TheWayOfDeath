import axios from 'axios';

function createGuestRequest(payload){
    return axios.post('/api/v1/guest',payload)
}

export{
    createGuestRequest,
}