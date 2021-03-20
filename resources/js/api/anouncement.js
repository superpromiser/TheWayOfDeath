import axios from 'axios';

function getAnouncement(){
    return axios.get('/api/v1/anouncement');
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