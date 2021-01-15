import clientsTableRow from '../../components/clientsTableRow';

Vue.component('clients-table-row', clientsTableRow);

window.clientsTable = new Vue({
    el: '#clients-table',
    data: {
        clients: null
    },
    methods: {
        deleteClient: function (id, event) {
            event.preventDefault();
            axios.post(baseUrl + '/admin/clients/delete/' + id, {
                _method: 'DELETE'
            });
            this.clients.forEach((client, index) => {
                if (client.id === id) this.clients.splice(index, 1);
            });
        }
    },
    mounted() {
        axios.get(baseUrl + '/admin/clients/getAllJson')
            .then(response => this.clients = response.data);
    }
});
