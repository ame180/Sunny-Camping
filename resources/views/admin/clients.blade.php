@extends('layouts.admin')

@section('options')
    <div data-vue-component="clients-toolbar"></div>
@endsection

@section('table')
    <div id="clients-table" class="mt-2">
        <div data-vue-component="clients-table" data-props="{{ json_encode(['clients' => $clients, 'filters' => $filters, 'clientNames' => $clientNames, 'assignedTokens' => $assignedTokens]) }}"></div>
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
