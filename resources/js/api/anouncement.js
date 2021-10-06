import axios from "axios";

function getAnouncement(payload) {
  return axios.get("/api/v1/anouncement", { params: payload });
}

function createAnouncement(payload) {
  return axios.post("/api/v1/anouncement", payload);
}

function updateAnouncement(payload) {
  return axios.put("/api/v1/anouncement", payload);
}

function deleteAnouncement(payload) {
  return axios.delete("/api/v1/anouncement", { data: payload });
}

function getTemplateCnt(payload) {
  return axios.get("/api/v1/anouncement/templateCnt", { params: payload });
}

function getTemplateList(payload) {
  return axios.get("/api/v1/anouncement/template", { params: payload });
}

function createTemplate(payload) {
  return axios.post("/api/v1/anouncement/template", payload);
}

function deleteTemplate(payload) {
  return axios.delete("/api/v1/anouncement/template", { data: payload });
}

function getSchoolUsers(payload) {
  return axios.get("/api/v1/schoolUsers", { params: payload });
}

function getLessonUsers(payload) {
  return axios.get("/api/v1/lessonUsers", { params: payload });
}

export {
  getAnouncement,
  createAnouncement,
  updateAnouncement,
  deleteAnouncement,
  getTemplateCnt,
  getTemplateList,
  createTemplate,
  deleteTemplate,
  getSchoolUsers,
  getLessonUsers
};
