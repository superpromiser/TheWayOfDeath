import axios from "axios";

function getRepairData(payload) {
  return axios.get("/api/v1/repairData", { params: payload });
}

function createRepairData(payload) {
  return axios.post("/api/v1/repairData", payload);
}

function updateRepairData(payload) {
  return axios.put("/api/v1/repairData", payload);
}

function deleteRepairData(payload) {
  return axios.delete("/api/v1/repairData", { data: payload });
}
function getTemplateCnt(payload) {
  return axios.get("/api/v1/repairData/templateCnt", { params: payload });
}

function getTemplateList(payload) {
  return axios.get("/api/v1/repairData/template", { params: payload });
}

function createTemplate(payload) {
  return axios.post("/api/v1/repairData/template", payload);
}

function updateTemplate(payload) {
  return axios.put("/api/v1/repairData/template", payload);
}

function deleteTemplate(payload) {
  return axios.delete("/api/v1/repairData/template", { data: payload });
}
export {
  getRepairData,
  createRepairData,
  updateRepairData,
  deleteRepairData,
  getTemplateList,
  getTemplateCnt,
  createTemplate,
  updateTemplate,
  deleteTemplate
};
