window.clientsTable = new Vue({
    el: '#clients-table',
    data: {
        clients: null
    },
    mounted() {
        axios.get(baseUrl + '/admin/clients/getAllJson')
            .then(response => this.clients = response.data);
    }
});
