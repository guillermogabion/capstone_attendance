require('./bootstrap');

window.Vue = require('vue').default;

import vuetify from './plugins/vuetify'
import router from './plugins/router';
import App from './layouts/App.vue';
import general from './mixins/general.vue'
import store from './store';
import Vue from 'vue';
import VueQRCodeComponent from 'vue-qrcode-component'
// import VueHtml2Canvas from 'vue-html2canvas';


Vue.component('qr-code', VueQRCodeComponent)

// Vue.use(VueHtml2Canvas);


Vue.mixin(general)
const app = new Vue({
    router,
    vuetify,
    store,
    el: '#app',
    render: h => h(App),
});