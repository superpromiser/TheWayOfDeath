import axios from 'axios'

let apiUrl = 'https://cors-anywhere.herokuapp.com/http://open.aichezaixian.com/route/rest';

function authTokenGet(payload){
    return axios.get(apiUrl,{params:payload})
}

function getData(payload){
    return axios.get(apiUrl,{params:payload})
}

export{
    authTokenGet,
    getData,
}