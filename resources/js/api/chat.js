import axios from 'axios';

function getUserList(){
    return axios.get('/api/v1/chat/userList');
}

function getContactList(){
    return axios.get('/api/v1/chat/contactList')
}

function addUserToContact(payload){
    return axios.post('/api/v1/contact', payload)
}

function postNewMsgCount(payload){
    return axios.post('/api/v1/chat/newMsgCount', payload)
}


export{
    getUserList,
    getContactList,
    addUserToContact,
    postNewMsgCount
}