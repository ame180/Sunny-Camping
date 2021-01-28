import ClientsTable from "../../components/ClientsTable.vue";
import ClientsForm from "../../components/ClientsForm.vue";
import VModal from 'vue-js-modal/dist/index.nocss.js';
import Vue from "vue";

Vue.component('clients-table', ClientsTable);
Vue.component('clients-form', ClientsForm);
Vue.use(VModal, {dialog: true});

new Vue({
    el: '#app',
});
