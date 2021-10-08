import axios from "axios";

function getHomeworkData(payload) {
  return axios.get("/api/v1/homeworkData", { params: payload });
}

function createHomeworkData(payload) {
  return axios.post("/api/v1/homeworkData", payload);
}

function getHomeworkResult(payload) {
  return axios.get("/api/v1/homeworkResult", { params: payload });
}

function createHomeworkResult(payload) {
  return axios.post("/api/v1/homeworkResult", payload);
}

function getAppHomeworkData(payload) {
  return axios.get("/api/v1/appHomeworkData", { params: payload });
}

function getMySubject(payload) {
  return axios.get("/api/v1/mySubject", { params: payload });
}

function getTemplateCnt(payload) {
  return axios.get("/api/v1/homeworkData/templateCnt", { params: payload });
}

function getTemplateList(payload) {
  return axios.get("/api/v1/homeworkData/template", { params: payload });
}

function createTemplate(payload) {
  return axios.post("/api/v1/homeworkData/template", payload);
}

function updateTemplate(payload) {
  return axios.put("/api/v1/homeworkData/template", payload);
}

function deleteTemplate(payload) {
  return axios.delete("/api/v1/homeworkData/template", { data: payload });
}

export {
  getHomeworkData,
  createHomeworkData,
  getHomeworkResult,
  createHomeworkResult,
  getAppHomeworkData,
  getMySubject,
  getTemplateCnt,
  getTemplateList,
  createTemplate,
  updateTemplate,
  deleteTemplate
};
