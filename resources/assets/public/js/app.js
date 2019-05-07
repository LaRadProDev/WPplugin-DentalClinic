import VueRouter from 'vue-router'
import Vue from 'vue'
import store from './store';
import VueCountdown from '@chenfengyuan/vue-countdown';

let MainPage = require('./pages/MainPage.vue');
let QuizPage = require('./pages/QuizPage.vue');
let ReviewPage = require('./pages/ReviewPage.vue');

Vue.use(VueRouter);
Vue.use(require('vue-moment'));
Vue.component(VueCountdown.name, VueCountdown);

Vue.filter('striphtml', function (value) {
    var div = document.createElement("div");
    div.innerHTML = value;
    var text = div.textContent || div.innerText || "";
    return text;
});

Vue.filter('truncate', function (text, length, suffix) {
    if (text.length > length) {
        return text.substring(0, length) + suffix;
    } else {
        return text;
    }
});

const routes = [
    { path: '/', component: MainPage, beforeEnter: (to, from, next) => {
        store.commit('refreshQuizData');
        store.commit('refreshQuestions');
        next();
    } },
    { path: '/start', component: QuizPage, beforeEnter: (to, from, next) => {
        if (!store.state.quiz_data.terms || !store.state.selectedQuestionsNum) {
            next('/');
        } else {
            next()
        }
    } },
    { path: '/review', component: ReviewPage, beforeEnter: (to, from, next) => {
        if (!store.state.questions.length) {
            next('/');
        } else {
            next();
        }
    } }
]

const router = new VueRouter({
    routes
})

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-WP-Nonce'] = window.ptt.nonce

Vue.prototype.$ajaxurl = window.ptt.ajax_url;
Vue.prototype.$base_rest_url = window.ptt.base_rest_url;
Vue.prototype.$base_url = window.ptt.base_url;
Vue.prototype.$plugin_url = window.ptt.plugin_url;

const app = new Vue({
    router,
    store
}).$mount('#pass-this-test');