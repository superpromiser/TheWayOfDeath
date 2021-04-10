import axios from 'axios';

function getAnouncement(payload){
    return axios.get('/api/v1/anouncement',{params:payload});
}

function createAnouncement(payload){
    return axios.post('/api/v1/anouncement',payload);
}

function updateAnouncement(payload){
    return axios.put('/api/v1/anouncement',payload);
}

function deleteAnouncement(payload){
    return axios.delete('/api/v1/anouncement',{data:payload})
}

export{
    getAnouncement,
    createAnouncement,
    updateAnouncement,
    deleteAnouncement
}