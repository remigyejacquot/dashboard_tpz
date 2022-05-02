import axiosInstance from "./axiosInstance";

async function getAllMembers() {
    return await axiosInstance.get(  "/tpz/dashboard_tpz/back/public/index.php/api/tpz_roles");
}

export { getAllMembers };
