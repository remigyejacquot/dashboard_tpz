import axiosInstance from "./axiosInstance";

async function getUser(id) {
    return await axiosInstance.get(  "api/users/"+id);
}

async function getUsers(tpzId) {
    return await axiosInstance.get("/gestion/getEtudiants/" + tpzId)
}

export { getUser, getUsers };
