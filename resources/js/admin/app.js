import ClientsTable from "../../components/ClientsTable";
import ClientsForm from "../../components/ClientsForm";
import ClientsToolbar from '../../components/ClientsToolbar.vue';
import ReportingDashboard from '../../components/ReportingDashboard.vue';

Vue.component('clients-table', ClientsTable);
Vue.component('clients-form', ClientsForm);
Vue.component('clients-toolbar', ClientsToolbar);
Vue.component('reporting-dashboard', ReportingDashboard);

new Vue({
    el: '#app',
});
