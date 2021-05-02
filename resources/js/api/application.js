import axios from 'axios'

function getScheduleData(){
    return axios.get('/api/v1/schoolSchedule');
}

export{
    getScheduleData,
}