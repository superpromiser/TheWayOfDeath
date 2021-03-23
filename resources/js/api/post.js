import axios from 'axios';

function getSchoolPost(page){
    return axios.get(`/api/v1/schoolPost?page=${page}`);
}

function getClassPost(classId){
    return axios.get('/api/v1/classPost',{params:{classId:classId}});
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
    getSchoolPost,
    getClassPost,
    addLike,
    removeLike,
    addViewUsers,
    addComment
}