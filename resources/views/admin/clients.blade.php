@extends('layouts.admin')

@section('input')
    @include('admin.clients.client_form')
@endsection

@section('table')
    <table class="table table-responsive-md table-bordered text-center">
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
            <th scope="col">Opcje</th>
        </tr>
        </thead>
        <tbody>
        {{--
        <tr>
            <th scope="row"></th>
            <td class="form-inline">
                <input class="form-control-sm w-50" type="text" placeholder="Imię">
                <input class="form-control-sm w-50" type="text" placeholder="Nazwisko">
            </td>
            <td>
                <input class="form-control-sm" type="date" placeholder="{{date('Y-m-d')}}">
            </td>
            <td>
                <input class="form-control-sm" type="date" placeholder="{{date('Y-m-d')}}">
            </td>
            <td>
                <input class="form-control-sm" type="number" placeholder="0">
            </td>
            <td class="form-inline">
                <input class="form-control-sm w-50" type="number" placeholder="0">
                <input class="form-control-sm w-50" type="number" placeholder="0">
            </td>
            <td>
                <input class="form-control-sm" type="number" placeholder="0">
            </td>
            <td class="form-inline">
                <input class="form-control-sm w-50" type="number" placeholder="0">
                <input class="form-control-sm w-50" type="number" placeholder="0">
            </td>
        </tr>
        --}}
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
                <td class="p-0">
                    <form class="m-0" method="POST" action="clients/delete/{{$client->id}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete-user rounded-0 h-100 w-100">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('main')
    <div class="container">
        @yield('input')
        @yield('table')
    </div>
@endsection
