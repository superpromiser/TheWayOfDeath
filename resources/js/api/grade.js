import axios from 'axios'

function getGrade(){
    return axios.get('/api/v1/grade');
}

function createGrade(payload){
    return axios.post('/api/v1/grade',payload);
}

function updateGrade(payload){
    return axios.put('/api/v1/grade',payload);
}

function deleteGrade(payload){
    return axios.delete('/api/v1/grade',{data:payload});
}

export{
    getGrade,
    createGrade,
    updateGrade,
    deleteGrade,
}