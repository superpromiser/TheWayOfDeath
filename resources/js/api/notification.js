import axios from "axios";

function getNotification() {
  return axios.get("/api/v1/class/notification");
}

function createNotification(payload) {
  //console.log('+++++++++',payload)
  return axios.post("/api/v1/class/notification", payload);
}

function updateNotification(payload) {
  return axios.put("/api/v1/class/notification", payload);
}

function deleteNotification(payload) {
  return axios.delete("/api/v1/class/notification", { data: payload });
}

export {
  getNotification,
  createNotification,
  updateNotification,
  deleteNotification
};
