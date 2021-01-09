@extends('layouts.admin')

@section('options')
    <div class="text-center">
        <a class="btn btn-lg btn-primary mt-4 w-50" href="clients/add">Dodaj klienta</a>
    </div>
@endsection

@section('table')
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
        @foreach($clients as $client)
            <tr>
                <th scope="row">{{$client->id}}</th>
                <td>{{$client->first_name." ".$client->last_name}}</td>
                <td>{{$client->arrival_date}}</td>
                <td>{{$client->departure_date}}</td>
                <td>{{$client->sector}}</td>
                <td>{{$client->adults." + ".$client->children}}</td>
                <td>{{$client->electricity}}</td>
                <td>{{$client->small_places." + ".$client->big_places}}</td>
                <td>{{$client->discount."%"}}</td>
                <td>{{$client->price}}</td>
                <td>{{$client->comment}}</td>
                <td class="p-0">
                    <div class="row no-gutters h-100">
                        <div class="col-12 col-xl-6 p-0">
                            <a type="submit" class="btn btn-primary rounded-0 w-100 h-100"
                               href="clients/edit/{{$client->id}}">
                                <i class="far fa-sticky-note"></i>
                            </a>
                        </div>
                        <form class="col-12 col-xl-6 p-0 m-0" method="POST" action="clients/delete/{{$client->id}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-user rounded-0 w-100">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('main')
    <div class="container">
        @yield('options')
        @yield('table')
    </div>
@endsection
