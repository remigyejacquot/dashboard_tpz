import axiosInstance from "./axiosInstance";

async function getGroupesData(id) {
    return await axiosInstance.get(  "/gestion/groupes/"+id);
}

export {getGroupesData}