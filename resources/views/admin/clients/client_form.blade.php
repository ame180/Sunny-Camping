<form class="row mt-3" method="POST" action="">
    @csrf
    @method('PUT')
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="first_name">Imię</label>
        <input name="first_name" class="form-control form-control-sm" type="text" placeholder="Imię">
    </div>
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="last_name">Nazwisko</label>
        <input name="last_name" class="form-control form-control-sm" type="text" placeholder="Nazwisko">
    </div>
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="arrival_date">Data przyjazdu</label>
        <input name="arrival_date" class="form-control form-control-sm" type="date" required>
    </div>
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="departure_date">Data odjazdu</label>
        <input name="departure_date" class="form-control form-control-sm" type="date" required>
    </div>
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="adults">Dorośli</label>
        <input name="adults" class="form-control form-control-sm" type="number" placeholder="0">
    </div>
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="children">Dzieci</label>
        <input name="children" class="form-control form-control-sm" type="number" placeholder="0">
    </div>
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="electricity">Prąd</label>
        <input name="electricity" class="form-control form-control-sm" type="number" placeholder="0">
    </div>
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="small_places">Małe miejsca</label>
        <input name="small_places" class="form-control form-control-sm" type="number" placeholder="0">
    </div>
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="big_places">Duże miejsca</label>
        <input name="big_places" class="form-control form-control-sm" type="number" placeholder="0">
    </div>
    <div class="col-6 col-sm-4 col-md-3 form-group">
        <label for="discount">Rabat</label>
        <select name="discount" class="custom-select custom-select-sm">
            <option value="0" selected>0%</option>
            <option value="5">5%</option>
            <option value="10">10%</option>
        </select>
    </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-success w-50">Zatwierdź</button>
    </div>
</form>
