import axios from 'axios';

function getRecognition(){
    return axios.get('/api/v1/class/recognition');
}

function createRecognition(payload){
    return axios.post('/api/v1/class/recognition',payload);
}

function updateRecognition(payload){
    return axios.put('/api/v1/class/recognition',payload);
}

function deleteRecognition(payload){
    return axios.delete('/api/v1/class/recognition',{data:payload});
}

export{
    getRecognition,
    createRecognition,
    updateRecognition,
    deleteRecognition,
}