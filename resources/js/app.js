
require('./bootstrap');
require('./kostum/adminTemplate/phone_mode');
require('./kostum/adminTemplate/misc');

// import VModal from 'vue-js-modal'
import router from './kostum/router/router'
import akses from  './kostum/akses'
import 'animate.css';


import { Form, HasError, AlertError } from 'vform'
import swal from 'sweetalert2'

window.Vue = require('vue');
window.nv=new Vue();

Vue.prototype.$akses = new akses(window.user);

// Toast Component
import toast from './kostum/alert/toast'
Vue.prototype.$toast = new toast;
//  ======

// Swal Manual
window.Swal=swal;
// =========

// Vform Component
window.Form=Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
// ===============




const app = new Vue({
    el: '#app',
    router
});
