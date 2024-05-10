require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Vue = require('vue').default;
Vue.component('users-table', require('./components/UsersTable.vue').default);
Vue.component('users-data-table', require('./components/UsersDataTable.vue'));
const app = new Vue({
    el: '#app',
});


