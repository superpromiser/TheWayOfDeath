import axios from 'axios';

function getAllPost(){
    return axios.get('/api/v1/allPost');
}

export{
    getAllPost,
}