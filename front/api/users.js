import axiosInstance from "./axiosInstance";

async function getUser(id) {
    return await axiosInstance.get(  "/tpz/dashboard_tpz/back/public/index.php/api/users/"+id);
}

export { getUser };
