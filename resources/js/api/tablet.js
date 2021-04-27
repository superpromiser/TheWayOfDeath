import axios from 'axios'

function getDashboardData(payload){
    return axios.get('/api/v1/tablet/dashboard',{params:payload})
}

function getLessonSchedule(payload){
    return axios.get('/api/v1/table/getLessonSchedule',{params:payload})
}

export{
    getDashboardData,
    getLessonSchedule,
}