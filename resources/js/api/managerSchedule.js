import axios from "axios";

function getBaseData() {
  return axios.get("/api/v1/manager/schedule/baseData");
}

function getSchedule(payload) {
  return axios.get("/api/v1/manager/schedule", { params: payload });
}

function createSchedule(payload) {
  return axios.post("/api/v1/manager/schedule", payload);
}

function updateSchedule(payload) {
  return axios.put("/api/v1/manager/schedule", payload);
}

function deleteSchedule(payload) {
  return axios.delete("/api/v1/manager/schedule", { data: payload });
}
export {
  getBaseData,
  getSchedule,
  createSchedule,
  updateSchedule,
  deleteSchedule
};
