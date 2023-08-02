/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



// window.Vue = require('vue').default;
import Vue from 'vue';
import { BootstrapVue, IconsPlugin, FormSelectPlugin  } from 'bootstrap-vue';
import '../css/custom.scss'
import Vuelidate from 'vuelidate'
import VueMq from 'vue-mq'
import store from "./store/index.js";
import WebCam from 'vue-web-cam'

import router from './routes.js';
import i18n from './lang';

import ProgressBar from 'vuejs-progress-bar' //progress bar


 // Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

 Vue.use(VueMq, {
     breakpoints: {
     phone: 320,
     large_phone: 480,
     portrait_tablet: 768,
     landscape_tablet: 1024,
     laptop: 1200,
     desktop: Infinity
     },
     defaultBreakpoint: 'desktop' // customize this for SSR
   });
   
 // Make BootstrapVue and IconsPlugin available throughout your project
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(localStorage);
Vue.use(Vuelidate);
Vue.use(FormSelectPlugin);
Vue.use(ProgressBar) // progress bar


// qr bar code 
import VueQRCodeComponent from 'vue-qrcode-component'
Vue.component('qr-code', VueQRCodeComponent)

Vue.use(WebCam)

// // Init plugin for loading
// Vue.use(Loading);
//  Vue.use(VueCompositionAPI)

//  const router = new VueRouter({
//   mode: 'history',
//   base: process.env.BASE_URL,
//   routes
//  })
 /**
  * The following block of code may be used to automatically register your
  * Vue components. It will recursively scan this directory for the Vue
  * components and automatically register them with their "basename".
  *
  * Eg. ./components/ExampleComponent.vue -> <ehhxample-component></example-component>
  */
 
 // const files = require.context('./', true, /\.vue$/i)
 // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
 Vue.component('main-app', require('./layout/MainApp.vue').default);
 Vue.component('signup', require('./views/Authentication/Signup').default);
 Vue.component('signin', require('./views/Authentication/Signin.vue').default);
 Vue.component('custom-button', require('./components/Global/Button.vue').default);
 Vue.component('custom-checkbox', require('./components/Global/Checkbox.vue').default);
 Vue.component('custom-footer', require('./components/Global/Footer.vue').default);
 Vue.component('custom-header', require('./components/Global/Header.vue').default);
 Vue.component('custom-logo', require('./components/Global/Logo.vue').default);
 Vue.component('custom-link', require('./components/Global/Link.vue').default);
 Vue.component('custom-heading', require('./components/Global/Heading.vue').default);
 Vue.component('custom-input', require('./components/Global/Input.vue').default);
 Vue.component('signup-form', require('./views/Authentication/SignUpForm.vue').default);
 Vue.component('signin-form', require('./views/Authentication/SignInForm.vue').default);
 Vue.component('custom-image', require('./components/Global/Image.vue').default);
 Vue.component('forget-password-form', require('./views/Authentication/ForgotPasswordForm.vue').default);
 Vue.component('custom-alert', require('./components/Global/Alert.vue').default);
 Vue.component('basic-header', require('./components/Global/BasicHeader.vue').default);
 Vue.component('man-with-heading', require('./components/Global/ManWithHeading.vue').default);
 Vue.component('personal-form', require('./views/User/Owner/PersonalForm.vue').default);
 Vue.component('customer-form', require('./views/User/Customer/AddNewCustomerForm.vue').default);
 Vue.component('default-button', require('./components/Global/DefaultButton.vue').default);
 Vue.component('pagination', require('laravel-vue-pagination'));

 Vue.component('dashboard-side-bar', require('./views/Dashboard/Sidebar_db.vue').default);

//  Vue.component('flow-button', require('/components/Global/FlowButton.vue'));
// Vue.component('custom-button', require('./components/Global/QuiteProcedure.vue').default);

 
 /**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */

 const app = new Vue({
     el: '#app',
     store, //vuex
     components: {
      Loading
    },
     router,
     i18n
 });