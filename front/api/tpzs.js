import axiosInstance from "./axiosInstance";

async function getAllTpzs() {
    return await axiosInstance.get(  "/api/tpzs");
}

async function getTpz(id) {
    return await axiosInstance.get(  "api/tpzs/"+id);
}

export { getAllTpzs, getTpz };
