import axiosInstance from "./axiosInstance";

async function getAllMembers() {
    return await axiosInstance.get(  "api/tpz_roles");
}

export { getAllMembers };
