import axios from "axios";

function getClass() {
  return axios.get("/api/v1/class");
}

function createClass(payload) {
  return axios.post("/api/v1/class", payload);
}

function updateClass(payload) {
  return axios.put("/api/v1/class", payload);
}

function deleteClass(payload) {
  return axios.delete("/api/v1/class", { data: payload });
}

function getGradeInfo(payload) {
  return axios.get("/api/v1/gradeName", { params: payload });
}

export { getClass, createClass, updateClass, deleteClass, getGradeInfo };
