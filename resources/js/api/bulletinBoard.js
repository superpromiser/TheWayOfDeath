import axios from "axios";

function getBulletinBoard(payload) {
  return axios.get("/api/v1/bulletinBoard", { params: payload });
}

function createBulletinBoard(payload) {
  return axios.post("/api/v1/bulletinBoard", payload);
}

function updateBulletinBoard(payload) {
  return axios.put("/api/v1/bulletinBoard", payload);
}

function deleteBoard(payload) {
  return axios.delete("/api/v1/bulletinBoard", { data: payload });
}

export {
  getBulletinBoard,
  createBulletinBoard,
  updateBulletinBoard,
  deleteBoard
};
