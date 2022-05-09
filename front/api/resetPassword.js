import axios from "axios";

async function resetPassword(data) {
    return await axios.post(process.env.VUE_BASE_URL + "/reset-password", data);
}

export { resetPassword };
