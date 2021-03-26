import axios from 'axios';

function getCheckInData(){
    return axios.get('/api/v1/checkIn');
}

function createCheckInData(payload){
    return axios.post('/api/v1/checkIn',payload)
}

function updateCheckInData(){
    return axios.put('/api/v1/checkIn',payload)
}

function deleteCheckInData(payload){
    return axios.delete('/api/v1/checkIn',{data:payload})
}

export{
    getCheckInData,
    createCheckInData,
    updateCheckInData,
    deleteCheckInData
}