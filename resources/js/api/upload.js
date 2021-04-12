import axios from 'axios'

function uploadImage(payload){
    return axios.post('/api/v1/file/image', payload);
}
function uploadVideo(payload){
    return axios.post('/api/v1/file/video', payload);
}
function uploadOther(payload){
    return axios.post('/api/v1/file/other', payload);
}
function deleteFile(payload){
    return axios.delete('/api/v1/file?fileName=' + payload);
    // return axios.delete( "/api/fileUpload/file?fileName=" + leagueImage, {headers: {"Authorization" : `Bearer ${token}`} },  )
}

export{
    uploadImage,
    uploadVideo,
    uploadOther,
    deleteFile,
  
}