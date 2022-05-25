import axiosInstance from "./axiosInstance";

async function getUser(id) {
    return await axiosInstance.get(  "api/users/"+id);
}

async function getUsers(tpzId) {
    return await axiosInstance.get("api/users?tpz.id=" + tpzId)
}

async function getTeachers() {
    return await axiosInstance.get("/gestion/getTeachers")
}

async function addStudent(data) {
    return await axiosInstance.post("/gestion/addStudent", data)
    //return await axiosInstance.post("api/users", data)
}

async function updateStudent(id,data) {
    return await axiosInstance.put("/gestion/updateStudent/"+id, data)
}

async function deleteStudent(id) {
    return await axiosInstance.delete("api/users/"+id)
}

export { getUser, getUsers, addStudent, updateStudent, deleteStudent, getTeachers };
