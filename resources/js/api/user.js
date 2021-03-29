import axios from 'axios'


//staff API
function createStaff(payload){
    return axios.post('/api/v1/staff', payload);
}
function updateStaff(payload){
    return axios.put('/api/v1/staff', payload);
}
function getStaff(payload){
    return axios.get('/api/v1/staff', payload);
}

//student API
function createStudent(payload){
    return axios.post('/api/v1/student', payload);
}
function updateStudent(payload){
    return axios.put('/api/v1/student', payload);
}
function getStudent(payload){
    return axios.get('/api/v1/student', payload);
}
function getStudentBylessonId(payload){
    return axios.get('/api/v1/studentBylessonId', {params: payload});
}


function deleteUser(payload){
    return axios.delete('/api/v1/users', {data : payload});
}

function getLessonUserList(){
    return axios.get('/api/v1/lessonUserList');
}

function getUserByRole(payload){
    return axios.get('/api/v1/userByRole',{params:payload});
}

function getSelUser(payload){
    return axios.get('/api/v1/selUser',{params:payload});
}

function getSchoolMemberList(payload){
    return axios.get('/api/v1/schoolMember',{params:payload});
}


export{
    createStaff,
    updateStaff,
    getStaff,
    createStudent,
    updateStudent,
    getStudent,
    getSelUser,
    deleteUser,
    getStudentBylessonId,
    getLessonUserList,
    getUserByRole,
    getSchoolMemberList
}