import axios from "axios";

function getCampus(payload) {
  return axios.get("/api/v1/campus", { params: payload });
}

function createCampus(payload) {
  return axios.post("/api/v1/campus", payload);
}

function updateCampus(payload) {
  return axios.put("/api/v1/campus", payload);
}

function deleteCampus(payload) {
  return axios.delete("/api/v1/campus", { data: payload });
}

export { getCampus, createCampus, updateCampus, deleteCampus };
