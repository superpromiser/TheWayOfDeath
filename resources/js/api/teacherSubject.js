import axios from "axios";

function getScheduleClass() {
  return axios.get("/api/v1/teacher/schedule");
}

function createScheduleClass(payload) {
  return axios.post("/api/v1/teacher/schedule", payload);
}

function updateScheduleClass(payload) {
  return axios.put("/api/v1/teacher/schedule", payload);
}

function deleteScheduleClass(payload) {
  return axios.delete("/api/v1/teacher/schedule", payload);
}

export {
  getScheduleClass,
  createScheduleClass,
  updateScheduleClass,
  deleteScheduleClass
};
