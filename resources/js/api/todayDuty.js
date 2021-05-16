import axios from 'axios'

function getTodayDutyData(){
    return axios.get('/api/v1/todayDuty',{params:payload})
}

function createTodayDutyData(){
    return axios.post('/api/v1/todayDuty',payload)
}

function updateTodayDutyData(){
    return axios.put('/api/v1/todayDuty',payload)
}

function deleteTodayDutyData(){
    return axios.delete('/api/v1/todayDuty',{params:payload})
}

export{
    getTodayDutyData,
    createTodayDutyData,
    updateTodayDutyData,
    deleteTodayDutyData
}