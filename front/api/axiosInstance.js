import axios from 'axios';
import {BASE_URL} from "./apiPath";

const headers = {
    "Accept": 'application/json',
    "Content-Type": 'application/json; charset=utf-8',
    "Access-Control-Allow-Credentials": true,
    "Access-Control-Allow-Origin": "http://localhost:8888/tpz/dashboard_tpz/back/public/index.php/api",
    "X-Requested-With": 'XMLHttpRequest',
};

const axiosInstance = axios.create({
    "baseURL": BASE_URL,
    headers,
});

axiosInstance.interceptors.request.use(
    async (config) => {
        let token;
        token = localStorage.getItem('token');
        if (token !== null && config.headers) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    error => {
        console.log('debug')
        return Promise.reject(error);
    },
);

axiosInstance.defaults.timeout = 10000;

export default axiosInstance;
