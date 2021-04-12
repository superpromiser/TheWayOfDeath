import axios from 'axios';

function getShiftMng(payload){
    return axios.get('/api/v1/shiftMng',{params:payload})
}

function createShiftMng(payload){
    return axios.post('/api/v1/shiftMng',payload)
}

function updateShiftMng(payload){
    return axios.put('/api/v1/shiftMng',payload)
}

function deleteShifMng(payload){
    return axios.delete('/api/v1/shiftMng',payload)
}

export{
    getShiftMng,
    createShiftMng,
    updateShiftMng,
    deleteShifMng,
}