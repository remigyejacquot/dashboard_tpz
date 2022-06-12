
import axiosInstance from "./axiosInstance";

async function resetPassword(data) {
    return await axiosInstance.post("/reset-password/sendMail", data);
}

export { resetPassword };
