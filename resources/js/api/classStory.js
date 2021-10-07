import axios from "axios";

function getClassStory(payload) {
  return axios.get("/api/v1/classStory", { params: payload });
}

function createClassStory(payload) {
  return axios.post("/api/v1/classStory", payload);
}

function updateClassStory(payload) {
  return axios.put("/api/v1/classStory", payload);
}

function deleteClassStory(payload) {
  return axios.delete("/api/v1/classStory", { data: payload });
}

function getTemplateCnt(payload) {
  return axios.get("/api/v1/classStory/templateCnt", { params: payload });
}

function getTemplateList(payload) {
  return axios.get("/api/v1/classStory/template", { params: payload });
}

function createTemplate(payload) {
  return axios.post("/api/v1/classStory/template", payload);
}

function updateTemplate(payload) {
  return axios.put("/api/v1/classStory/template", payload);
}

function deleteTemplate(payload) {
  return axios.delete("/api/v1/classStory/template", { data: payload });
}

export {
  getClassStory,
  createClassStory,
  updateClassStory,
  deleteClassStory,
  getTemplateCnt,
  getTemplateList,
  createTemplate,
  updateTemplate,
  deleteTemplate
};
