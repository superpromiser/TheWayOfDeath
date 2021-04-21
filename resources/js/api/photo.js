import axios from 'axios';

function getClassPhoto(payload){
    return axios.get('/api/v1/class/photos',{params:{classId:payload}})
}

function getClassFile(payload){
    return axios.get('/api/v1/class/files',{params:{classId:payload}})
}

export{
    getClassPhoto,
    getClassFile,
}