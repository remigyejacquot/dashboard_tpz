import axiosInstance from "./axiosInstance";

async function getAllTpzMembers() {
    return await axiosInstance.get(  "api/tpz_roles");
}

export { getAllTpzMembers };
