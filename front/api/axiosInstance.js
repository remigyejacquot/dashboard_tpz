import axios from 'axios';

/*const headers = {
    "Accept": 'application/json',
    "Content-Type": 'application/json; charset=utf-8',
    "Access-Control-Allow-Credentials": true,
    "Access-Control-Allow-Origin": "http://localhost:8888/tpz/dashboard_tpz/back/public/index.php/api",
    "X-Requested-With": 'XMLHttpRequest',
};*/

const axiosInstance = axios.create({
    baseURL: 'http://localhost/dashboard_tpz/back/public/index.php',
    //headers,
});

axiosInstance.interceptors.request.use(
    async (config) => {
        let token = localStorage.getItem('userToken');
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
