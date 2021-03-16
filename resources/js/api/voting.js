import axios from 'axios';

function getVoting(){
    return axios.get('/api/v1/voting')
}

function createVoting(payload){
    return axios.post('/api/v1/voting',payload);
}

function updateVoting(payload){
    return axios.put('/api/v1/voting',payload);
}

function deleteVoting(payload){
    return axios.delete('/api/v1/voting',{data:payload})
}

export{
    getVoting,
    createVoting,
    updateVoting,
    deleteVoting
}