import axios from 'axios';

function getAllPost(){
    return axios.get('/api/v1/allPost');
}

function addLike(payload){
    return axios.post('/api/v1/like',payload);
}

function removeLike(payload){
    return axios.delete('/api/v1/like',{data:payload});
}
function addViewUsers(payload){
    return axios.post('/api/v1/viewUser', payload);
}

function addComment(payload){
    return axios.post('/api/v1/comment',payload)
}

export{
    getAllPost,
    addLike,
    removeLike,
    addViewUsers,
    addComment
}