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


export{
    uploadImage,
    uploadVideo,
    uploadOther,

}