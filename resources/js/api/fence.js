import axios from 'axios'

let apiUrl = 'https://cors-anywhere.herokuapp.com/http://open.aichezaixian.com/route/rest';

function authTokenGet(payload){
    return axios.get(apiUrl,{params:payload})
}

function getData(payload){
    return axios.get(apiUrl,{params:payload})
}

function getFence(payload){
    return axios.get('/api/v1/fence',{params:payload})
}

function createFence(payload){
    return axios.post('/api/v1/fence',payload)
}

function updateFence(payload){
    return axios.put('/api/v1/fence',payload)
}

function deleteFence(payload){
    return axios.delete('/api/v1/fence',{data:payload})
}

export{
    authTokenGet,
    getData,
    getFence,
    createFence,
    updateFence,
    deleteFence,
}