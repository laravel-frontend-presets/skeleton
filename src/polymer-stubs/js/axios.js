import axios from 'axios';

export default (() => {
    const axiosInstance = axios.create();

    axiosInstance.interceptors.request.use(config => {
        if(window.App.csrf_token) {
            config.headers['X-CSRF-TOKEN'] = window.App.csrf_token;
        }

        return config;
    }, Promise.reject);

    return axiosInstance;
})();
