import axiosInstance from "./axiosInstance";

async function updateSubtasks(id, data) {
    return await axiosInstance.put("/api/subtasks/" + id, data)
}

export {updateSubtasks}
