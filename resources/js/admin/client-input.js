export default $(document).ready(function () {
    $("#client-form").submit(function () {
        let fields = $("#client-form").serializeArray();
        let values = [];
        $.each(fields, function () {
            values[this.name] = this.value;
        });
        if (values['first_name'] == "" && values['last_name'] == "") {
            alert("Imię lub Nazwisko musi być wpisane!");
            return false;
        }
        if (values['adults'] == "" && values['children'] == "") {
            alert("Musisz wpisać co najmniej jedną osobę!");
            return false;
        }
        if (new Date(values['arrival_date']) >= new Date(values['departure_date'])) {
            alert("Data odjazdu musi być później od daty przyjazdu!");
            return false;
        }
        if (values['adults'] < 0 || values['children'] < 0 || values['electricity'] < 0 || values['big_places'] < 0 ||
            values['small_places'] < 0) {
            alert("Liczby nie mogą być ujemne!")
            return false;
        }
    });
});
