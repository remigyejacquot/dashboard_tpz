//import axiosInstance from "./axiosInstance";
//import axios from "axios";
//import {API_BASE_URL} from "./apiPath";
import axiosInstance from "./axiosInstance";

async function getUserLicenceAgencies(id) {
    return await axiosInstance.get(  "user_licence_agencies/"+id);
}

async function getLicenceAgencies(type) {
    return await axiosInstance.get(  "licence_agencies/"+type);
}

async function getAgencyMembers(id) {
    return await axiosInstance.get("agencies/"+id)
}

export { getUserLicenceAgencies, getLicenceAgencies, getAgencyMembers };
