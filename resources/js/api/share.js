import axios from 'axios';

function getShare(){
    return axios.get('/api/v1/share');
}

function createShare(payload){
    return axios.post('/api/v1/share',payload)
}

function updateShare(payload){
    return axios.put('/api/v1/share',payload)
}

function deleteShare(payload){
    return axios.delete('/api/v1/share',{data:payload})
}

export{
    getShare,
    createShare,
    updateShare,
    deleteShare
}