import axiosInstance from "./axiosInstance";

async function addTask(data) {
    return await axiosInstance.post("/api/tasks",data)
}

async function updateTask(id,data) {
    return await axiosInstance.put("/api/tasks/"+id,data)
}

export {addTask, updateTask}
