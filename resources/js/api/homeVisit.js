import axios from 'axios'

function getHomeVisit(){
    return axios.get('/api/v1/homeVisit');
}

function createHomeVisit(payload){
    return axios.post('/api/v1/homeVisit',payload);
}

function updateHomeVisit(payload){
    return axios.put('/api/v1/homeVisit',payload);
}

function deleteHomeVisit(payload){
    return axios.delete('/api/v1/homeVisit',{data:payload});
}

export{
    getHomeVisit,
    createHomeVisit,
    updateHomeVisit,
    deleteHomeVisit
}