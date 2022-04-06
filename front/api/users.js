import axiosInstance from "./axiosInstance";

async function getUser(id) {
    return await axiosInstance.get(  "api/users/"+id);
}

export { getUser };
