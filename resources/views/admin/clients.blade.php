@extends('layouts.admin')

@section('options')
    <div class="text-center">
        <a class="btn btn-lg btn-primary m-1" href="clients/add-client" id="add-client-btn">Dodaj klienta</a>
        <a class="btn btn-lg btn-primary m-1" href="/api/clients/export-registered">Exportuj</a>
    </div>
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
    <script>
        // Preserve filters when clicking "Add Client" button
        document.addEventListener('DOMContentLoaded', function() {
            const addClientBtn = document.getElementById('add-client-btn');
            if (addClientBtn) {
                addClientBtn.addEventListener('click', function(e) {
                    // Store current filters from URL parameters
                    const urlParams = new URLSearchParams(window.location.search);
                    const filters = {
                        unregistered: urlParams.get('unregistered') || '',
                        cash_register: urlParams.get('cash_register') || '',
                        terminal: urlParams.get('terminal') || '',
                        voucher: urlParams.get('voucher') || '',
                        invoice: urlParams.get('invoice') || '',
                        departure_date: urlParams.get('departure_date') || '',
                        status: urlParams.get('status') || '',
                        token_number: urlParams.get('token_number') || '',
                        query: urlParams.get('query') || ''
                    };
                    sessionStorage.setItem('clientTableFilters', JSON.stringify(filters));
                });
            }
        });
    </script>
@endsection
