import axios from "axios";

function getSms(payload) {
  return axios.get("/api/v1/sms", { params: payload });
}

function createSms(payload) {
  return axios.post("/api/v1/sms", payload);
}

function updateSms(payload) {
  return axios.put("/api/v1/sms", payload);
}

function deleteSms(payload) {
  return axios.delete("/api/v1/sms", { data: payload });
}

export { getSms, createSms, updateSms, deleteSms };
