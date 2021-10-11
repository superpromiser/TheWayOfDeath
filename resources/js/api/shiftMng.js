import axios from "axios";

function getShiftMng(payload) {
  return axios.get("/api/v1/shiftMng", { params: payload });
}

function createShiftMng(payload) {
  return axios.post("/api/v1/shiftMng", payload);
}

function updateShiftMng(payload) {
  return axios.put("/api/v1/shiftMng", payload);
}

function deleteShifMng(payload) {
  return axios.delete("/api/v1/shiftMng", payload);
}

function getTemplateCnt(payload) {
  return axios.get("/api/v1/shiftMng/templateCnt", { params: payload });
}

function getTemplateList(payload) {
  return axios.get("/api/v1/shifMng/template", { params: payload });
}

function createTemplate(payload) {
  return axios.post("/api/v1/shiftMng/template", payload);
}

function deleteTemplate(payload) {
  return axios.delete("/api/v1/shiftMng/template", { data: payload });
}

export {
  getShiftMng,
  createShiftMng,
  updateShiftMng,
  deleteShifMng,
  getTemplateCnt,
  getTemplateList,
  createTemplate,
  deleteTemplate
};
