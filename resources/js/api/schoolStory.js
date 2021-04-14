import axios from 'axios'

function getSchoolStory(payload){
    return axios.get('/api/v1/schoolStory',{params:payload})
}

function createSchoolStory(payload){
    return axios.post('/api/v1/schoolStory',payload)
}

function updateSchoolStory(payload){
    return axios.put('/api/v1/schoolStory',payload)
}

function deleteSchoolStory(payload){
    return axios.delete('/api/v1/schoolStory',{data:payload})
}

export{
    getSchoolStory,
    createSchoolStory,
    updateSchoolStory,
    deleteSchoolStory,
}