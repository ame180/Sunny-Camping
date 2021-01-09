@extends('layouts.admin')

@section('input')
    <form class="row mt-4" method="POST" action="../update/{{$client->id}}">
        @csrf
        @method('PUT')
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="first_name">Imię</label>
            <input name="first_name" class="form-control form-control-sm" type="text" placeholder="Imię"
                   value="{{$client->first_name}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="last_name">Nazwisko</label>
            <input name="last_name" class="form-control form-control-sm" type="text" placeholder="Nazwisko"
                   value="{{$client->last_name}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="arrival_date">Data przyjazdu</label>
            <input name="arrival_date" class="form-control form-control-sm" type="date" required
                   value="{{$client->arrival_date}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="departure_date">Data odjazdu</label>
            <input name="departure_date" class="form-control form-control-sm" type="date" required
                   value="{{$client->departure_date}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="adults">Dorośli</label>
            <input name="adults" class="form-control form-control-sm" type="number" placeholder="0"
                   value="{{$client->adults}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="children">Dzieci</label>
            <input name="children" class="form-control form-control-sm" type="number" placeholder="0"
                   value="{{$client->children}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="electricity">Prąd</label>
            <input name="electricity" class="form-control form-control-sm" type="number" placeholder="0"
                   value="{{$client->electricity}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="small_places">Małe miejsca</label>
            <input name="small_places" class="form-control form-control-sm" type="number" placeholder="0"
                   value="{{$client->small_places}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="big_places">Duże miejsca</label>
            <input name="big_places" class="form-control form-control-sm" type="number" placeholder="0"
                   value="{{$client->big_places}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="comment">Komentarz</label>
            <input name="comment" class="form-control form-control-sm" type="text" placeholder="Komentarz"
                   value="{{$client->comment}}">
        </div>
        <div class="col-6 col-sm-4 col-md-3 form-group">
            <label for="discount">Rabat</label>
            <select name="discount" class="custom-select custom-select-sm">
                <option value="0" {{$client->discount == 0 ? "selected" : ""}}>0%</option>
                <option value="5" {{$client->discount == 5 ? "selected" : ""}}>5%</option>
                <option value="10" {{$client->discount == 10 ? "selected" : ""}}>10%</option>
            </select>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success w-50">Zatwierdź</button>
        </div>
    </form>
@endsection

@section('main')
    <div class="container">
        @yield('input')
    </div>
@endsection
