import axios from 'axios';

function getAllPost(){
    return axios.get('/api/v1/allPost');
}

function likeAction(payload){
    return axios.post('/api/v1/likeAction',payload);
}

export{
    getAllPost,
    likeAction,
}