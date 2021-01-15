@extends('layouts.admin')

@section('input')
    <form id="client-form" class="row mt-4" method="POST" action="">
        @foreach($inputs as $input)
            @include('admin.templates.client_input')
        @endforeach
        <div class="col-12 text-center">
            <button @@click.prevent="submitClientForm" class="btn btn-success w-50">Zatwierdź</button>
        </div>
    </form>
@endsection

@section('main')
    @yield('input')
@endsection
