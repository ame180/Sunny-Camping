@extends('layouts.admin')

@section('input')
    <form class="row mt-4" method="POST" action="">
        @csrf
        @method('PUT')
        @foreach($inputs as $input)
            @include('admin.templates.client_input')
        @endforeach
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success w-50">Zatwierdź</button>
        </div>
    </form>
@endsection

@section('main')
    @yield('input')
@endsection
