import axios from 'axios';

function getRegname(){
    return axios.get('/api/v1/regname');
}

function createRegname(payload){
    return axios.post('/api/v1/regname',payload)
}

function updateRegname(payload){
    return axios.put('/api/v1/regname',payload)
}

function deleteRegname(payload){
    return axios.delete('/api/v1/regname',{data:payload})
}

export{
    getRegname,
    createRegname,
    updateRegname,
    deleteRegname
}