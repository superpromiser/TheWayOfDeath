import axios from 'axios';

function getBanziName(){
    return axios.get('/api/v1/banziName');
}

export{
    getBanziName,
}