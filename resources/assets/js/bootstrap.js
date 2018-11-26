window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');

window.Vue = require('vue');

window.Vue.prototype.authorize = function (handler) {
    let user = window.App.user;

    return user ? handler(user) : false
}

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.App.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};
