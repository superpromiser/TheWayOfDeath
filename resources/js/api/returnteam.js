import axios from "axios";

function getReturnTeam() {
  return axios.get("/api/v1/returnteam");
}

function createReturnTeam(payload) {
  return axios.post("/api/v1/returnteam", payload);
}

function createRemainTeam(payload) {
  return axios.post("/api/v1/remainteam", payload);
}

function updateReturnTeam(payload) {
  return axios.put("/api/v1/returnteam", payload);
}

function deleteReturnTeam(payload) {
  return axios.delete("/api/v1/returnteam", { data: payload });
}

export {
  getReturnTeam,
  createReturnTeam,
  createRemainTeam,
  updateReturnTeam,
  deleteReturnTeam
};
