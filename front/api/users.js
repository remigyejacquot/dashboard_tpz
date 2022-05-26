import axiosInstance from "./axiosInstance";

async function getUser(id) {
    return await axiosInstance.get(  "api/users/"+id);
}

async function getUsers(tpzId) {
    return await axiosInstance.get("api/users?tpz.id=" + tpzId)
}

async function deleteUser(id) {
    return await axiosInstance.delete("api/users/"+id)
}

//Students
async function addStudent(data) {
    return await axiosInstance.post("/gestion/addStudent", data)
    //return await axiosInstance.post("api/users", data)
}

async function updateUser(id,data) {
    return await axiosInstance.put("/gestion/updateUser/"+id, data)
}

//Teachers
async function getTeachers() {
    return await axiosInstance.get("/gestion/getTeachers")
}

async function addTeacher(data) {
    return await axiosInstance.post("/gestion/addTeacher", data)
}

export { getUser, getUsers, deleteUser, addStudent, updateUser, getTeachers, addTeacher };
