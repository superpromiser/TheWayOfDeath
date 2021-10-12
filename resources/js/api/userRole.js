import axios from "axios";

function getUserRole() {
  return axios.get("/api/v1/userRole");
}
function createUserRole(payload) {
  return axios.post("/api/v1/userRole", payload);
}
function updateUserRole(payload) {
  return axios.put("/api/v1/userRole", payload);
}

function deleteUserRole(payload) {
  return axios.delete("/api/v1/userRole", { data: payload });
}

export { getUserRole, createUserRole, updateUserRole, deleteUserRole };
