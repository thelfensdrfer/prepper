window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
if (!CSRF_TOKEN) {
    console.warning('No csrf token found!');
}

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': CSRF_TOKEN
};
