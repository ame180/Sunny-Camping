import ClientsTable from "../../components/ClientsTable";

Vue.component('clients-table', ClientsTable);

new Vue({
    el: '#clients-table',
});

new Vue({
    el: '#client-form',
    methods: {
        submitClientForm(mode) {
            if (!this.first_name && !this.last_name) {
                alert("Imię lub Nazwisko musi być wpisane!");
                return false;
            }
            if (!this.adults && !this.children) {
                alert("Musisz wpisać co najmniej jedną osobę!");
                return false;
            }
            if (new Date(this.arrival_date) >= new Date(this.departure_date)) {
                alert("Data odjazdu musi być później od daty przyjazdu!");
                return false;
            }
            if (this.adults < 0 || this.children < 0 || this.electricity < 0 || this.big_places < 0 ||
                this.small_places < 0) {
                alert("Liczby nie mogą być ujemne!")
                return false;
            }
            var request;
            if (mode == 'PUT') {
                request = axios.put(baseUrl + '/admin/clients/add', {
                    id: this.id,
                    first_name: this.first_name,
                    last_name: this.last_name,
                    arrival_date: this.arrival_date,
                    departure_date: this.departure_date,
                    sector: this.sector,
                    adults: this.adults,
                    children: this.children,
                    electricity: this.electricity,
                    small_places: this.small_places,
                    big_places: this.big_places,
                    comment: this.comment,
                    discount: this.discount
                });
            } else {
                request = axios.patch(baseUrl + '/admin/clients/update/' + this.id, {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    arrival_date: this.arrival_date,
                    departure_date: this.departure_date,
                    sector: this.sector,
                    adults: this.adults,
                    children: this.children,
                    electricity: this.electricity,
                    small_places: this.small_places,
                    big_places: this.big_places,
                    comment: this.comment,
                    discount: this.discount
                });
            }
            request.then(() => {
                window.location = baseUrl + '/admin/clients';
            }, () => {
                alert("Coś poszło nie tak! Upewnij się że wpisane dane są poprawne!");
            });
        }
    },
    data: {
        id: null,
        first_name: null,
        last_name: null,
        arrival_date: null,
        departure_date: null,
        sector: null,
        adults: null,
        children: null,
        electricity: null,
        small_places: null,
        big_places: null,
        comment: null,
        discount: 0
    }
});
