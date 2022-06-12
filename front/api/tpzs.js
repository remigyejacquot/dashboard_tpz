import axiosInstance from "./axiosInstance";

async function getAllTpzs() {
    return await axiosInstance.get(  "/api/tpzs?order[year]=desc");
}

async function getTpz(id) {
    return await axiosInstance.get(  "api/tpzs/"+id);
}

async function postTpz(data) {
    return await axiosInstance.post("api/tpzs", data)
}

export { getAllTpzs, getTpz, postTpz };
