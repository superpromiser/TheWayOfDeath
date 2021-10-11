import axios from "axios";

function getTemplate(payload) {
  //console.log('getTemplate',payload)
  return axios.get("/api/v1/template", { params: payload });
}

function createTemplate(payload) {
  return axios.post("/api/v1/template", payload);
}

function updateTemplate(payload) {
  return axios.put("/api/v1/template", payload);
}

function deleteTemplate(payload) {
  return axios.delete("/api/v1/template", { data: payload });
}

export { getTemplate, createTemplate, updateTemplate, deleteTemplate };
