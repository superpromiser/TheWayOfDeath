import axios from "axios";

function getSafeStudy(payload) {
  return axios.get("/api/v1/safeStudy", { params: payload });
}

function createSafeStudy(payload) {
  return axios.post("/api/v1/safeStudy", payload);
}

function updateSafeStudy(payload) {
  return axios.put("/api/v1/safeStudy", payload);
}

function deleteSafeStudy(payload) {
  return axios.delete("/api/v1/safeStudy", { data: payload });
}

function getTemplateCnt(payload) {
  return axios.get("/api/v1/safeStudy/templateCnt", { params: payload });
}

function getTemplateList(payload) {
  return axios.get("/api/v1/safeStudy/template", { params: payload });
}

function createTemplate(payload) {
  return axios.post("/api/v1/safeStudy/template", payload);
}

function updateTemplate(payload) {
  return axios.put("/api/v1/safeStudy/template", payload);
}

function deleteTemplate(payload) {
  return axios.delete("/api/v1/safeStudy/template", { data: payload });
}

export {
  getSafeStudy,
  createSafeStudy,
  updateSafeStudy,
  deleteSafeStudy,
  getTemplateCnt,
  getTemplateList,
  createTemplate,
  updateTemplate,
  deleteTemplate
};
