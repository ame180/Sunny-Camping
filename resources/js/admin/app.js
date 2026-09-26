import ClientsTable from "../../components/ClientsTable";
import ClientsForm from "../../components/ClientsForm";
import CustomAdminMenu from '../../components/CustomAdminMenu.vue';
import ClientsToolbar from '../../components/ClientsToolbar.vue';
import ReportingDashboard from '../../components/ReportingDashboard.vue';
import VModal from 'vue-js-modal/dist/index.nocss.js';

Vue.component('clients-table', ClientsTable);
Vue.component('clients-form', ClientsForm);
Vue.component('custom-admin-menu', CustomAdminMenu);
Vue.component('clients-toolbar', ClientsToolbar);
Vue.component('reporting-dashboard', ReportingDashboard);
Vue.use(VModal, {dialog: true});

new Vue({
    el: '#app',
});
