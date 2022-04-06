//import axiosInstance from "./axiosInstance";
//import axios from "axios";
//import {API_BASE_URL} from "./apiPath";
import axiosInstance from "./axiosInstance";

async function getUserLicenceAgencies(id) {
    return await axiosInstance.get(  "licence_agencies/"+id);
}

export { getUserLicenceAgencies };
