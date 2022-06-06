import axiosInstance from "./axiosInstance";

async function getCommentaries(agencyId) {
    return await axiosInstance.get("api/commentaries?agence.id=" + agencyId)
}

async function postCommentary(data) {
    return await axiosInstance.post("api/commentaries", data)
}

async function putCommentary(id, data) {
    return await axiosInstance.put("api/commentaries/" + id, data)
}

async function deleteCommentary(id) {
    return await axiosInstance.delete("api/commentaries/" + id)
}

export { getCommentaries, postCommentary, putCommentary, deleteCommentary };
