<template>
    <form id="client-form" class="row mt-4" @submit.prevent="submitClientForm()" method="POST" action="">
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="first_name">Imię</label>
            <input v-model="client.firstName" @blur="client.firstName = trim(client.firstName)"
                   name="first_name"
                   type="text" placeholder="Imię"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="last_name">Imię</label>
            <input v-model="client.lastName" @blur="client.lastName = trim(client.lastName)" name="last_name"
                   type="text" placeholder="Naziwsko"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="arrival_date">Data przyjazdu</label>
            <input v-model="client.arrivalDate" @change="updateDiscount()" name="arrival_date" type="date"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="departure_date">Data odjazdu</label>
            <input v-model="client.departureDate" @change="updateDiscount()" name="departure_date" type="date"
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
            <input v-model="client.smallPlaces" name="small_places" type="number" placeholder="0"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="big_places">Duże miejsca</label>
            <input v-model="client.bigPlaces" name="big_places" type="number" placeholder="0"
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
        <div v-if="mode === 'PATCH' && initialPaid > 0" class="col-6 col-sm-4 col-md-3 form-group">
            <label for="paid">Zapłacono</label>
            <input v-model="client.paid" name="paid" type="number" placeholder="0"
                   class="form-control form-control-sm">
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
                firstName: null,
                lastName: null,
                arrivalDate: null,
                departureDate: null,
                sector: null,
                adults: null,
                children: null,
                electricity: null,
                smallPlaces: null,
                bigPlaces: null,
                comment: null,
                paid: null,
                discount: 0
            }
        }
    },
    mounted() {
        if (this.mode == 'PATCH' && this.id != null) {
            axios.get(baseUrl + '/admin/clients/find-json/' + this.id)
                .then((response) => {
                    this.client = response.data;
                    this.initialPaid = this.client.paid
                })
        }
    },
    methods: {
        trim(input) {
            if (input) return input.trim();
            return null;
        },
        updateDiscount() {
            if (!this.client.arrivalDate || !this.client.departureDate) return false;
            let days = (new Date(this.client.departureDate) - new Date(this.client.arrivalDate)) / (1000 * 60 * 60 * 24);
            console.log(days);
            if (days >= 7 && days < 14) this.client.discount = 5;
            else if (days >= 14) this.client.discount = 10;
            else this.client.discount = 0;
        },
        submitClientForm() {
            if (this.client.firstName) this.client.firstName = this.client.firstName.trim();
            if (this.client.lastName) this.client.lastName = this.client.lastName.trim();
            if (!this.client.firstName && !this.client.lastName) {
                alert("Imię lub Nazwisko musi być wpisane!");
                return false;
            }
            if (!this.client.adults && !this.client.children) {
                alert("Musisz wpisać co najmniej jedną osobę!");
                return false;
            }
            if (new Date(this.client.arrivalDate) >= new Date(this.client.departureDate)) {
                alert("Data odjazdu musi być później od daty przyjazdu!");
                return false;
            }
            if (this.client.adults < 0 || this.client.children < 0 || this.client.electricity < 0 || this.client.bigPlaces < 0 ||
                this.client.smallPlaces < 0) {
                alert("Liczby nie mogą być ujemne!")
                return false;
            }
            let request;
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
