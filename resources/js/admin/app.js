import { createApp } from 'vue';
import ClientsTable from '../../components/ClientsTable.vue';
import ClientsForm from '../../components/ClientsForm.vue';
import ClientsToolbar from '../../components/ClientsToolbar.vue';
import ReportingDashboard from '../../components/ReportingDashboard.vue';

const components = {
    'clients-table': ClientsTable,
    'clients-form': ClientsForm,
    'clients-toolbar': ClientsToolbar,
    'reporting-dashboard': ReportingDashboard,
};

document.querySelectorAll('[data-vue-component]').forEach((element) => {
    const component = components[element.dataset.vueComponent];
    const props = JSON.parse(element.dataset.props || '{}');

    createApp(component, props).mount(element);
});
