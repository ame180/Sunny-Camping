import ClientsTable from "../../components/ClientsTable";
import ClientsForm from "../../components/ClientsForm";
import VModal from 'vue-js-modal/dist/index.nocss.js';

Vue.component('clients-table', ClientsTable);
Vue.component('clients-form', ClientsForm);
Vue.use(VModal, {dialog: true});

new Vue({
    el: '#app',
});
