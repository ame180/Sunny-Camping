import ClientsTable from "../../components/ClientsTable";

Vue.component('clients-table', ClientsTable);

new Vue({
    el: '#clients-table',
});

new Vue({
    el: '#client-form',
    methods: {
        submitClientForm() {
            console.log(this);
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
