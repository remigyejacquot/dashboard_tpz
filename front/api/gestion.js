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
    console.log(role)
    return await axiosInstance.post("/gestion/updateRole", {
        'roleUser' : role,
        'idUser' : idUser,
        'idAgence' : idAgence,
    })
}

export {getGroupesData, updateRole, deleteGroupe}