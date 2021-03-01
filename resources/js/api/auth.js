import axios from 'axios'

function loginApi(payload){
    return axios.post('/api/v1/login',payload);
}

export{
    loginApi,
}