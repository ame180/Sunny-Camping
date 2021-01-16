@extends('layouts.admin')

@section('options')
    <div class="text-center">
        <a class="btn btn-lg btn-primary mt-4 w-50" href="clients/add-client">Dodaj klienta</a>
    </div>
@endsection

@section('table')
    <div id="clients-table" class="mt-3">
        <clients-table>
        </clients-table>
    </div>
@endsection

@section('temp')
    <table class="table table-responsive-lg table-bordered text-center mt-3">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Imię i Nazwisko</th>
            <th scope="col">Data Przyjazdu</th>
            <th scope="col">Data Odjazdu</th>
            <th scope="col">Sektor</th>
            <th scope="col">Osoby</th>
            <th scope="col">Prąd</th>
            <th scope="col">Miejsca</th>
            <th scope="col">Rabat</th>
            <th scope="col">Cena</th>
            <th scope="col">Komentarz</th>
            <th scope="col">Opcje</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="client in clients" :key="client.id" :client="client" is="clients-table-row">
        </tr>
        </tbody>
    </table>
@endsection

@section('main')
    @yield('options')
    @yield('table')
@endsection
