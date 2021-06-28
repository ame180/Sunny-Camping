<template>
    <div id="client-form" class="row mt-4">
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
            <input id="arrival_date" v-model="client.arrival_date" name="arrival_date" type="date"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="departure_date">Data odjazdu</label>
            <input id="departure_date" v-model="client.departure_date" name="departure_date" type="date"
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
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="paid">Zapłacono</label>
            <input id="paid" v-model="client.paid" name="paid" type="number" placeholder="0"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="climate_paid">Klimatyczne</label>
            <input id="climate_paid" v-model="client.climate_paid" name="paid" type="number" placeholder="0"
                   class="form-control form-control-sm">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="status">Status</label>
            <select id="status" v-model="client.status" name="paid" type="select"
                 class="form-control form-control-sm">
              <option value="unsettled">Nierozliczono</option>
              <option value="settled">Rozliczono</option>
            </select>
        </div>
        <div class="col-12">
            <hr>
            <div v-for="(category, index) in categories" :key="category.id" class="row">
                <div class="col-12">
                    <h2>{{ category.name }}</h2>
                    <div class="mb-3">
                        <a v-for="item in category.service_category_items" :key="item.id" @click="addItem(index, item)"
                           class="btn btn-primary mx-1">{{ item.name }}</a>
                    </div>
                    <div class="row" v-for="(item, itemIndex) in category.addedItems">
                        <div class="col-3 col-md-2 d-flex justify-content-center align-items-center">
                            <b>{{ item.name }}</b>
                        </div>
                        <div class="col-3 col-md-2 form-group">
                            <label>Cena</label>
                            <input v-model="item.price" type="number"
                                   class="form-control form-control-sm">
                        </div>
                        <div class="col-3 col-md-2 form-group">
                            <label>Ilość</label>
                            <input v-model="item.count" type="number"
                                   class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Usuń</label>
                            <div>
                                <a class="btn btn-danger" @click="deleteItem(index, itemIndex)"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <div class="col-12 text-center">
            <button @click="submitClientForm()" class="btn btn-success w-50 mb-4">
                Zatwierdź
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['mode', 'id'],
    data() {
        return {
            client: {
                name: null,
                arrival_date: null,
                departure_date: null,
                comment: null,
                paid: null,
                climate_paid: null,
                discount: 0,
                client_items: []
            },
            categories: [],
            items: [],
            isNameInvalid: false
        }
    },
    mounted() {
        if (this.mode === 'PATCH' && this.id != null) {
            axios.get(baseUrl + '/api/client/find/' + this.id)
                .then((response) => {
                    this.client = response.data;

                    axios.get(baseUrl + '/api/category/all-by-service/1')
                        .then((response) => {
                            let categories = [];
                            response.data.forEach(function (category) {
                                category.addedItems = [];
                                this.client.client_items.forEach(function (item) {
                                    if (category.id === item.service_category_id) {
                                        category.addedItems.push(item);
                                    }
                                })
                                categories.push(category);
                            }, this)
                            this.categories = categories;
                        });
                });
        }
        if (this.mode === 'PUT') {
            axios.get(baseUrl + '/api/category/all-by-service/1')
                .then((response) => {
                    let categories = [];
                    response.data.forEach(function (category) {
                        category.addedItems = [];
                        this.client.client_items.forEach(function (item) {
                            if (category.id === item.service_category_id) {
                                category.addedItems.push(item);
                            }
                        })
                        categories.push(category);
                    }, this)
                    this.categories = categories;
                });
        }
    },
    methods: {
        trim(input) {
            if (input) return input.trim();
            return null;
        },
        addItem(categoryId, item) {
            item.id = null;
            item.count = 1;
            this.categories[categoryId].addedItems.push(Vue.util.extend({}, item));
        },
        deleteItem(categoryId, itemId) {
            this.categories[categoryId].addedItems.splice(itemId, 1);
        },
        submitClientForm() {
            if (!this.client.name) {
                this.isNameInvalid = true;
                return false;
            }
            if (this.client.arrival_date && this.client.departure_date && new Date(this.client.arrival_date) >= new Date(this.client.departure_date)) {
                alert("Data odjazdu musi być później od daty przyjazdu!");
                return false;
            }
            let request;

            this.client.client_items = [];
            this.categories.forEach(function(category) {
                this.client.client_items = this.client.client_items.concat(category.addedItems);
            }, this);

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
