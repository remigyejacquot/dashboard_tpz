
import axiosInstance from "./axiosInstance";

async function login(data) {
  return await axiosInstance.post("/tpz/dashboard_tpz/back/public/index.php/authentication", data);
}

async function logout() {
  return await axiosInstance.post("/tpz/dashboard_tpz/back/public/index.php/logout");
}

export { login, logout };
