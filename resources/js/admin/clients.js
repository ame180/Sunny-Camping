import clientsTableRow from '../../components/clientsTableRow';
import ClientsTable from "../../components/ClientsTable";

Vue.component('clients-table-row', clientsTableRow);
Vue.component('clients-table', ClientsTable);

window.clientsTable = new Vue({
    el: '#clients-table',
});
