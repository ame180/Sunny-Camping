import ClientsTable from "../../components/ClientsTable";
import ClientsForm from "../../components/ClientsForm";

Vue.component('clients-table', ClientsTable);
Vue.component('clients-form', ClientsForm);

new Vue({
    el: '#app',
});
