import axios from 'axios';

function getUserList(){
    return axios.get('/api/v1/chat/userList');
}

function getContactList(){
    return axios.get('/api/v1/chat/contactList')
}

function getMessage(payload){
    return axios.get('/api/v1/messages', {params:payload})
}

function postMessage(payload){
    return axios.post('/api/v1/messages', payload)
}

function postMessageVoice(formdata){
    return axios.post('/api/v1/messages/voice', formdata, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
}

function postMessageImage(formdata){
    return axios.post('/api/v1/messages/image', formdata, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
}

function postMessageVideo(formdata){
    return axios.post('/api/v1/messages/video', formdata, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
}

function postMessageFile(formdata){
    return axios.post('/api/v1/messages/file', formdata, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
}

function addUserToContact(payload){
    return axios.post('/api/v1/contact', payload)
}

function postNewMsgCount(payload){
    return axios.post('/api/v1/chat/newMsgCount', payload)
}

function postNewGroup(payload){
    return axios.post('/api/v1/messages/newgroup', payload)
}

function leaveGroup(payload){
    return axios.post('/api/v1/messages/leavegroup', payload)
}

function getGroupChatMessage(payload){
    return axios.get('/api/v1/messages/group', {params:payload})
}

function removeContactUser(payload){
    return axios.delete('/api/v1/messages/removeUser', {data:payload})
}

function removeGroup(payload){
    return axios.delete('/api/v1/messages/removeGroup', {data:payload})
}





export{
    getUserList,
    getContactList,
    addUserToContact,
    postNewMsgCount,
    getMessage,
    postMessage,
    postMessageVoice,
    postMessageImage,
    postMessageVideo,
    postMessageFile,
    postNewGroup,
    getGroupChatMessage,
    removeContactUser,
    leaveGroup,
    removeGroup

}