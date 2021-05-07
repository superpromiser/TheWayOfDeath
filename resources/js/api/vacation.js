import axios from 'axios';

function getBanziName(){
    return axios.get('/api/v1/banziName');
}

function getVacationData(){
    return axios.get('/api/v1/vacation');
}

function getCurrentData(payload){
    return axios.get('/api/v1/currentVacation',{params:payload});
}
function allVacationData(payload){
    return axios.get('/api/v1/allVacation',{params:payload});
}
function createVacationData(payload){
    return axios.post('/api/v1/vacation',payload)
}

function updateVacationData(payload){
    return axios.put('/api/v1/vacation',payload)
}

function deleteVacationData(payload){
    return axios.delete('/api/v1/vacation',{data:payload})
}
export{
    getBanziName,
    getVacationData,
    getCurrentData,
    allVacationData,
    createVacationData,
    updateVacationData,
    deleteVacationData,
}