import axios from "axios";

function getDashboardData(payload) {
  return axios.get("/api/v1/tablet/dashboard", { params: payload });
}

function getLessonSchedule(payload) {
  return axios.get("/api/v1/tablet/lessonSchedule", { params: payload });
}

function getLessonList() {
  return axios.get("/api/v1/tablet/lessonList");
}

export { getDashboardData, getLessonSchedule, getLessonList };
