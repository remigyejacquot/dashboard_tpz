
import axiosInstance from "./axiosInstance";

async function login(data) {
  return await axiosInstance.post("authentication", data);
}

async function logout() {
  return await axiosInstance.post( "logout");
}

export { login, logout };
