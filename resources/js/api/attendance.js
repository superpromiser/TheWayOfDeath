import axios from 'axios';

function getAttendaceData(payload){
    return axios.get('/api/v1/attendance',{params:payload})
}

export{
    getAttendaceData,
}