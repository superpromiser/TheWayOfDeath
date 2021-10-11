import axios from "axios";

function getTodayDutyData(payload) {
  return axios.get("/api/v1/todayDuty", { params: payload });
}

function createTodayDutyData(payload) {
  return axios.post("/api/v1/todayDuty", payload);
}

function updateTodayDutyData(payload) {
  return axios.put("/api/v1/todayDuty", payload);
}

function deleteTodayDutyData(payload) {
  return axios.delete("/api/v1/todayDuty", { params: payload });
}

export {
  getTodayDutyData,
  createTodayDutyData,
  updateTodayDutyData,
  deleteTodayDutyData
};
