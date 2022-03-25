
import axiosInstance from "./axiosInstance";

async function authentication(data) {
  return await axiosInstance.post("authentication", data);
}

export { authentication };
