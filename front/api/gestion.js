import axiosInstance from "./axiosInstance";

async function getGroupesData(id) {
    return await axiosInstance.get(  "/gestion/groupes/"+id);
}

async function deleteGroupe(id) {
    return await axiosInstance.post("/gestion/deleteGroupMembers/" +id).then(async function (){
        return await axiosInstance.delete("/api/agencies/" + id)
    })
}

async function updateRole(role, idUser, idAgence) {
    return await axiosInstance.post("/gestion/updateRole", {
        'roleUser' : role,
        'idUser' : idUser,
        'idAgence' : idAgence,
    })
}

async function updateRoleBureau(data) {
    return await axiosInstance.post("/gestion/updateRoleBureau", {
        'data' : data,
    })
}

export {getGroupesData, updateRole, deleteGroupe, updateRoleBureau}