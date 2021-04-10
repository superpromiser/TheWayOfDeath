import axios from 'axios'

function getDashboardData(payload){
    return axios.get('/api/v1/tablet/dashboard',{params:payload})
}

export{
    getDashboardData,
}