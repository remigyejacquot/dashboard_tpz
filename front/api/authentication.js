
import axiosInstance from "./axiosInstance";

async function login(data) {
  return await axiosInstance.post(process.env.VUE_BASE_URL + "/authentication", data);
}

async function logout() {
  return await axiosInstance.post(process.env.VUE_BASE_URL + "logout");
}

export { login, logout };
