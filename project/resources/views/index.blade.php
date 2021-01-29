@extends('layouts.master')

@section('content')
    <script>
        var warehouses = JSON.parse('{!! json_encode($warehouses) !!}');
        var openingHours = JSON.parse('{!! json_encode($openingHours) !!}');
    </script>

    <div id="map" class="map mt-3 border border-dark"></div>

    <!-- Okienko z atrybutami składu budowlanego -->
    @include('warehouse-card')

@endsection

@section('custom-scripts')
    <script src="{{asset('js/map.js')}}"></script>
    <script src="{{asset('js/warehouse-card.js')}}"></script>
@endsection