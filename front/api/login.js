import axiosInstance from "./axiosInstance";
import { BASE_URL } from "./apiPath";

async function authentication(data) {
  return await axiosInstance.post(BASE_URL + "/authentication", data);
}

export { authentication };
