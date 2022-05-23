import axiosInstance from "./axiosInstance";

async function getUser(id) {
    return await axiosInstance.get(  "api/users/"+id);
}

async function getUsers(tpzId) {
    return await axiosInstance.get("/gestion/getEtudiants/" + tpzId)
}

async function addStudent(data) {
    //return await axiosInstance.post("/gestion/addStudent", data)
    return await axiosInstance.post("api/users", data)
}

export { getUser, getUsers, addStudent };
