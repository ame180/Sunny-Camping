<template>
    <form id="client-form" class="row mt-4" @submit.prevent="submitClientForm()" method="POST" action="">
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="first_name">Imię</label>
            <input v-model="client.first_name" name="first_name" type="text" placeholder="Imię"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="last_name">Imię</label>
            <input v-model="client.last_name" name="last_name" type="text" placeholder="Naziwsko"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="arrival_date">Data przyjazdu</label>
            <input v-model="client.arrival_date" name="arrival_date" type="date" class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="departure_date">Data odjazdu</label>
            <input v-model="client.departure_date" name="departure_date" type="date"
                   class="form-control form-control-sm"
                   required>
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="adults">Dorośli</label>
            <input v-model="client.adults" name="adults" type="number" placeholder="0"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="children">Dzieci</label>
            <input v-model="client.children" name="children" type="number" placeholder="0"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="electricity">Prąd</label>
            <input v-model="client.electricity" name="electricity" type="number" placeholder="0"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="small_places">Małe miejsca</label>
            <input v-model="client.small_places" name="small_places" type="number" placeholder="0"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="big_places">Duże miejsca</label>
            <input v-model="client.big_places" name="big_places" type="number" placeholder="0"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="comment">Komentarz</label>
            <input v-model="client.comment" name="comment" type="text" placeholder="Komentarz"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="discount">Rabat</label>
            <select v-model="client.discount" name="discount" class="custom-select custom-select-sm">
                <option value="0">0%</option>
                <option value="5">5%</option>
                <option value="10">10%</option>
            </select>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success w-50">
                Zatwierdź
            </button>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['mode', 'id'],
        data() {
            return {
                client: {
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
            }
        },
        mounted() {
            if (this.mode == 'PATCH' && this.id != null) {
                axios.get(baseUrl + '/admin/clients/find-json/' + this.id)
                    .then((response) => {
                        this.client = response.data;
                    })
            }
        },
        methods: {
            isEmpty(input) {
                if (!input) return true;
                if (!input.trim()) return true;
                return false;
            },
            submitClientForm() {
                if (this.isEmpty(this.client.first_name) && this.isEmpty(this.client.last_name)) {
                    alert("Imię lub Nazwisko musi być wpisane!");
                    return false;
                }
                if (!this.client.adults && !this.client.children) {
                    alert("Musisz wpisać co najmniej jedną osobę!");
                    return false;
                }
                if (new Date(this.client.arrival_date) >= new Date(this.client.departure_date)) {
                    alert("Data odjazdu musi być później od daty przyjazdu!");
                    return false;
                }
                if (this.client.adults < 0 || this.client.children < 0 || this.client.electricity < 0 || this.client.big_places < 0 ||
                    this.client.small_places < 0) {
                    alert("Liczby nie mogą być ujemne!")
                    return false;
                }
                var request;
                if (this.mode == 'PUT') {
                    request = axios.put(baseUrl + '/admin/clients/add', this.client);
                } else {
                    request = axios.patch(baseUrl + '/admin/clients/update/' + this.id, this.client);
                }
                request.then(() => {
                    window.location.href = baseUrl + '/admin/clients';
                }, () => {
                    alert("Coś poszło nie tak! Upewnij się że wpisane dane są poprawne!");
                });
            }
        },
    }
</script>
