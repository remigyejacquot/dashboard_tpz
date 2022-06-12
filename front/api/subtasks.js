import axiosInstance from "./axiosInstance";


async function addSubtask(data) {
    return await axiosInstance.post("/api/subtasks", data)
}

async function updateSubtask(id, data) {
    return await axiosInstance.put("/api/subtasks/" + id, data)
}

async function deleteSubtask(id) {
    return await axiosInstance.delete("/api/subtasks/"+id)
}

export {addSubtask, updateSubtask, deleteSubtask}
