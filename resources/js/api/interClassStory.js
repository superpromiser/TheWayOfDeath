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

function getTemplateCnt(payload){
    return axios.get('/api/v1/interClassStory/templateCnt',{params:payload})
}

function getTemplateList(payload){
    return axios.get("/api/v1/interClassStory/template",{params:payload})
}

function createTemplate(payload){
    return axios.post('/api/v1/interClassStory/template',payload)
}

function updateTemplate(payload){
    return axios.put('/api/v1/interClassSotry/template',payload)
}


function deleteTemplate(payload){
    return axios.delete('/api/v1/interClassStory/template',{data:payload})
}


export{
    getInterClassStory,
    createInterClassStory,
    updateInterClassStory,
    deleteInterClassStory,
    getTemplateCnt,
    getTemplateList,
    createTemplate,
    updateTemplate,
    deleteTemplate,
}