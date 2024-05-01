// Axios
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Bootstrap
import * as Popper from '@popperjs/core';
window.Popper = Popper;
import 'bootstrap';

// Alpine
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
Alpine.plugin(mask);
window.Alpine = Alpine;
Alpine.start();


// Toastr
import toastr from 'toastr';
window.showToastNotification = function (type, message) {
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-left",
        "escapeHtml": true // To prevent XSS - https://security.snyk.io/vuln/SNYK-JS-TOASTR-2396430
    };
    toastr[type](message);
}
