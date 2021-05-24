import ClientsTable from "../../components/ClientsTable";
import ClientsForm from "../../components/ClientsForm";
import CustomAdminMenu from '../../components/CustomAdminMenu.vue';
import VModal from 'vue-js-modal/dist/index.nocss.js';

Vue.component('clients-table', ClientsTable);
Vue.component('clients-form', ClientsForm);
Vue.component('custom-admin-menu', CustomAdminMenu);
Vue.use(VModal, {dialog: true});

new Vue({
    el: '#app',
});
