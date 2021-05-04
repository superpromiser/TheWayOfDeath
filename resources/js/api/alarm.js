import axios from 'axios';

function getAlarm(){
    return axios.get('/api/v1/alarm');
}

function createAlarm(payload){
    return axios.post('/api/v1/alarm',payload);
}

function updateAlarm(payload){
    return axios.put('/api/v1/alarm',payload);
}

function deleteAlarm(payload){
    return axios.delete('/api/v1/alarm',{data:payload});
}

function getReadCnt(payload){
    return axios.get('/api/v1/readCnt',{params:payload})
}

function createReadCnt(payload){
    return axios.post('/api/v1/readCnt',payload)
}

export{
    getAlarm,
    createAlarm,
    updateAlarm,
    deleteAlarm,
    getReadCnt,
    createReadCnt
}