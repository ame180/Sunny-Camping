<template>
    <form id="client-form" class="row mt-4" @submit.prevent="submitClientForm()" method="POST" action="">
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="name">Imię i nazwisko</label>
            <input id="name" v-model="client.name" :class="{ 'is-invalid': isNameInvalid }" @input="isNameInvalid = false" @blur="client.name = trim(client.name)"
                   name="name"
                   type="text" placeholder="Imię i nazwisko"
                   class="form-control form-control-sm">
            <div class="invalid-feedback">
                Imię i nazwisko muszą być podane!
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="arrival_date">Data przyjazdu</label>
            <input id="arrival_date" v-model="client.arrivalDate" name="arrival_date" type="date"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="departure_date">Data odjazdu</label>
            <input id="departure_date" v-model="client.departureDate" name="departure_date" type="date"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="comment">Komentarz</label>
            <input id="comment" v-model="client.comment" name="comment" type="text" placeholder="Komentarz"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="discount">Rabat</label>
            <select id="discount" v-model="client.discount" name="discount" class="custom-select custom-select-sm">
                <option value="0">0%</option>
                <option value="5">5%</option>
                <option value="10">10%</option>
            </select>
        </div>
        <div v-if="mode === 'PATCH' && initialPaid > 0" class="col-6 col-sm-4 col-md-3 form-group">
            <label for="paid">Zapłacono</label>
            <input id="paid" v-model="client.paid" name="paid" type="number" placeholder="0"
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
                name: null,
                arrivalDate: null,
                departureDate: null,
                comment: null,
                paid: null,
                discount: 0
            },
            initialPaid: null,
            isNameInvalid: false
        }
    },
    mounted() {
        if (this.mode === 'PATCH' && this.id != null) {
            axios.get(baseUrl + '/api/client/find/' + this.id)
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
        submitClientForm() {
            if (!this.client.name) {
                this.isNameInvalid = true;
                return false;
            }
            if (this.client.arrivalDate && this.client.departureDate && new Date(this.client.arrivalDate) >= new Date(this.client.departureDate)) {
                alert("Data odjazdu musi być później od daty przyjazdu!");
                return false;
            }
            let request;
            if (this.mode === 'PUT') {
                request = axios.put(baseUrl + '/api/client/add', this.client);
            } else {
                request = axios.patch(baseUrl + '/api/client/update/' + this.id, this.client);
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
