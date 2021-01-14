@extends('layouts.admin')

@section('main')
    <div id="app">
        <div id="chart">
            <apexchart type="bar" height="350" :options="chartOptions" :series="series"></apexchart>
        </div>
    </div>
@endsection
