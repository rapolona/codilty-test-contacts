require('./bootstrap');

window.Vue = require('vue');

import VeeValidate from 'vee-validate';
import axios from 'axios'
import VueAxios from 'vue-axios'
import VuejsDialog from 'vuejs-dialog';
import jquery from 'jquery/src/jquery';

import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

const opts = {};

export default new Vuetify(opts);

Vue.use(VeeValidate);
Vue.use(VueAxios, axios);
Vue.use(VuejsDialog, {
    html : true,
    okText : 'Proceed',
    cancelText: 'Cancel',
    animation : 'bounce'
});

Vue.component('contact-list', require('./components/ContactList.vue').default);
Vue.component('contact-form', require('./components/ContactForm.vue').default);
Vue.component('contacts', require('./components/Contacts.vue').default);

let _tokenHeader = { headers: { 'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]')}};

const app = new Vue({
    el: '#app',
    data : {
        showForm : false,
        showList : true,
        showCList : false,
        tokenHeader : _tokenHeader,
        contactId : null,
        contactName : null,
        msg: null,
        type : null
    },
    methods : {
        showContactForm() {
            this.showForm = true;
            this.showList = false;
            this.showCList = false;
        },
        showContactList() {
            this.showForm = false;
            this.showList = true;
            this.showCList = false;
        }
    },
    created() {
        this.$root.$refs.main = this;
    }
});