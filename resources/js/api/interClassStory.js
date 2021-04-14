import axios from 'axios'

function getInterClassStory(payload){
    return axios.get('/api/v1/interClassStory',{params:payload})
}

function createInterClassStory(payload){
    return axios.post('/api/v1/interClassStory',payload)
}

function updateInterClassStory(payload){
    return axios.put('/api/v1/interClassStory',payload)
}

function deleteInterClassStory(payload){
    return axios.delete('/api/v1/interClassStory',{data:payload})
}

export{
    getInterClassStory,
    createInterClassStory,
    updateInterClassStory,
    deleteInterClassStory,
}