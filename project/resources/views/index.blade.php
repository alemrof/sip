@extends('layouts.master')

@section('content')
    <script>
        var warehouses = JSON.parse('{!! json_encode($warehouses) !!}');
    </script>

    <div id="map" class="map mt-3 border border-dark"></div>
    {{-- <div class="my-1">
        <button class="btn btn-info" id="addWarehouse">Dodaj skład</button>
        <button class="btn btn-danger" id="stopDrawing">Zatrzymaj rysowanie</button>
    </div> --}}

    <!-- Okienko z atrybutami składu budowlanego -->
    <div class="card border-dark" id="popup" style="width: 15rem;">
        <div class="card-header bg-dark text-white">
            <span id="warehouse-name">Nazwa składu</span>
            <button type="button" class="close" id="closer">
            <span aria-hidden="true" class="text-white">&times;</span>
            </button>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item" id="warehouse-company">Sieć sklepów</li>
            <li class="list-group-item" id="warehouse-adress">Aleja Grunwaldzka 102, 81-045 Gdańsk</li>
            <li class="list-group-item" id="warehouse-location">Położenie</li>
        </ul>
        <div class="card-body d-flex justify-content-between">
            <a href="" class="btn btn-light border-dark" id="edit-link">Edytuj</a>
            <a href="" class="btn btn-light border-dark" id="editMap-link">Edytuj Wsp.</a>
        </div>
    </div>    
@endsection

@section('custom-scripts')
    <script src="{{asset('js/map.js')}}"></script>
@endsection