import axios from 'axios'

function getBaseData(){
    return axios.get('/api/v1/manager/schedule');
}

function createSchedule(payload){
    return axios.post('/api/v1/manager/schedule',payload)
}

function updateSchedule(payload){
    return axios.put('/api/v1/manager/schedule',payload)
}

function deleteSchedule(payload){
    return axios.delete('/api/v1/manager/schedule',{data:payload})
}
export{
    getBaseData,
    createSchedule,
    updateSchedule,
    deleteSchedule
}