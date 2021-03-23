import axios from 'axios';

function getClassPhoto(payload){
    return axios.get('/api/v1/class/photos',{params:{classId:payload}})
}

export{
    getClassPhoto,
}