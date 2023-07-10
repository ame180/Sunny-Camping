@extends('layouts.admin')

@section('options')
    <div class="text-center mt-3">
        <a class="btn btn-lg btn-primary m-1" href="clients/add-client">Dodaj klienta</a>
        <a class="btn btn-lg btn-primary m-1" href="/api/clients/export-registered">Exportuj</a>
    </div>
@endsection

@section('table')
    <div id="clients-table" class="mt-3">
        <clients-table :clients="{{ $clients }}" :filters="{{ $filters }}" :client-names="{{ $clientNames }}" :assigned-tokens="{{ $assignedTokens }}">
        </clients-table>
        <div class="mt-2">
            {!! $pagination !!}
        </div>
    </div>
@endsection

@section('main')
    @yield('options')
    @yield('table')
@endsection
