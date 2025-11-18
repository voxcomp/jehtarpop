// bootstrap.js
window._ = require('lodash');
try {
    window.bootstrap = require('bootstrap');
} catch (e) {
    console.error(e);
}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';