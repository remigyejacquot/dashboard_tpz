import axios from 'axios';

//const urlRemi = "http://localhost:8888/tpz/dashboard_tpz/back/public/index.php/"

const axiosInstance = axios.create({
    baseURL: 'http://localhost:8888/tpz/dashboard_tpz/back/public/index.php/'//http://localhost/dashboard_tpz/back/public/index.php',
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
        return Promise.reject(error);
    },
);


axiosInstance.defaults.timeout = 10000;

export default axiosInstance;
