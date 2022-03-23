import axios from "axios";

async function resetPassword(data) {
    return await axios.post("http://localhost:8888/tpz/dashboard_tpz/back/public/index.php/reset-password", data);
}

export { resetPassword };
