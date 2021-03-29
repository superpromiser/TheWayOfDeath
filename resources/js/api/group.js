import axios from 'axios'

function getGroup(payload){
    return axios.get('/api/v1/group',{params:payload})
}

export{
    getGroup,
}