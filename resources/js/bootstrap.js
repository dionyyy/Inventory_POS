import _ from 'lodash';
import axios from 'axios';
import Noty from 'noty';

window._ = _;
window.Noty = Noty;

/**
 * Axios HTTP client. Sends the X-Requested-With header so Laravel treats
 * requests as XHR, and attaches the stored JWT as a Bearer token.
 */
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});
