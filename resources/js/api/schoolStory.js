import axios from "axios";

function getSchoolStory(payload) {
  return axios.get("/api/v1/schoolStory", { params: payload });
}

function getSchoolStoryMo(payload) {
  return axios.get("/api/v1/SchoolStoryMo", { params: payload });
}

function createSchoolStory(payload) {
  return axios.post("/api/v1/schoolStory", payload);
}

function updateSchoolStory(payload) {
  return axios.put("/api/v1/schoolStory", payload);
}

function deleteSchoolStory(payload) {
  return axios.delete("/api/v1/schoolStory", { data: payload });
}

function getTemplateCnt(payload) {
  return axios.get("/api/v1/schoolStory/templateCnt", { params: payload });
}

function getTemplateList(payload) {
  return axios.get("/api/v1/schoolStory/template", { params: payload });
}

function createTemplate(payload) {
  return axios.post("/api/v1/schoolStory/template", payload);
}

function updateTemplate(payload) {
  return axios.put("/api/v1/schoolStory/template", payload);
}

function deleteTemplate(payload) {
  return axios.delete("/api/v1/schoolStory/template", { data: payload });
}

export {
  getSchoolStory,
  createSchoolStory,
  updateSchoolStory,
  deleteSchoolStory,
  getSchoolStoryMo,
  getTemplateList,
  getTemplateCnt,
  createTemplate,
  updateTemplate,
  deleteTemplate
};
