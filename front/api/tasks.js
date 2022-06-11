import axiosInstance from "./axiosInstance";

async function addTask(data) {
    return await axiosInstance.post("/api/tasks",data)
}

async function updateTask(id,data) {
    return await axiosInstance.put("/api/tasks/"+id,data)
}

async function deleteTask(id) {
    return await axiosInstance.delete("/api/tasks/"+id)
}

export {addTask, updateTask, deleteTask}
