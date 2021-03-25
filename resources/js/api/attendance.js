import axios from 'axios';

function getAttendaceData(){
    return axios.get('/api/v1/attendace')
}

export{
    getAttendaceData,
}