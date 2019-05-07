window.Vue = require('vue');

Vue.component('editable-radio', require('./components/EditableRadio.vue'));

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.prototype.$ajaxurl = window.ptt.ajax_url;
Vue.prototype.$base_rest_url = window.ptt.base_rest_url;
Vue.prototype.$base_url = window.ptt.base_url;
Vue.prototype.$plugin_url = window.ptt.plugin_url;

const app = new Vue({
    el: '#vue-editable-radio',
});