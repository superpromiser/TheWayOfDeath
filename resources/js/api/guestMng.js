import axios from 'axios';

function createGuestRequest(payload){
    return axios.post('/api/v1/guest',payload)
}

function getGuestRequest(){
    return axios.get('/api/v1/guest');
}

function updateGuestRequest(payload){
    return axios.put('/api/v1/guest',payload);
}

function deleteGuestRequest(payload){
    return axios.delete('/api/v1/guest',{data:payload});
}
export{
    createGuestRequest,
    getGuestRequest,
    updateGuestRequest,
    deleteGuestRequest,
}