@extends('layouts.admin')

@section('options')
    <clients-toolbar></clients-toolbar>
@endsection

@section('table')
    <div id="clients-table" class="mt-2">
        <clients-table :clients="{{ $clients }}" :filters="{{ $filters }}" :client-names="{{ $clientNames }}" :assigned-tokens="{{ $assignedTokens }}">
        </clients-table>
        <div class="mt-2">
            {!! $pagination !!}
        </div>
    </div>
@endsection

@section('main')
    <div class="container">
        @yield('options')
        @yield('table')
    </div>
@endsection
