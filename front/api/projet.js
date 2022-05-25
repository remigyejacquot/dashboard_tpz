import axiosInstance from "./axiosInstance";

async function addProject(data) {
    return await axiosInstance.post("api/projects", data)
}

async function updateProject(id, data) {
    return await axiosInstance.put("api/projects/" + id, data)
}

async function deleteProject(id) {
    return await axiosInstance.delete("api/projects/" + id)
}

export {addProject, updateProject, deleteProject}