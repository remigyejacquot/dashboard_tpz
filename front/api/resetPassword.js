import axios from "axios";

async function resetPassword(data) {
    return await axios.post("/reset-password", data);
}

export { resetPassword };
