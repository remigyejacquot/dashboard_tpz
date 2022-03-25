//import axiosInstance from "./axiosInstance";
//import axios from "axios";
//import {API_BASE_URL} from "./apiPath";
import axiosInstance from "./axiosInstance";

async function getAllAgencies() {
    return await axiosInstance.get(  "api/agencies");
}

export { getAllAgencies };
