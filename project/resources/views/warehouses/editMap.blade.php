@extends('layouts.master')

@section('content')
    <script>
        let warehouses = JSON.parse('{!! json_encode($warehouses) !!}');
        // let id = JSON.parse('{!! json_encode($warehouses) !!}');
        let id = {!! $id !!};
    </script>

    <div id="map" class="map mt-3 border border-dark"></div>
    {{-- <div class="my-1">
        <button class="btn btn-info" id="addWarehouse">Dodaj skład</button>
        <button class="btn btn-danger" id="stopDrawing">Zatrzymaj rysowanie</button>
    </div> --}}

    <!-- Okienko z atrybutami składu budowlanego -->
    <div class="card border-dark" id="popup" style="width: 17rem;">
        <div class="card-header bg-dark text-white">
            <span id="warehouse-name">Czy zapisać obecne położenie?</span>
        </div>
        <div class="card-body d-flex">
            <form action="{{route('warehouses.updateMap', $id)}}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="lat" id="newWarehouse-lat">
                <input type="hidden" name="lon" id="newWarehouse-lon">
                <button type="submit" class="btn btn-light border-dark">Tak</button>
            </form>
            <a href="{{route('home')}}" class="btn btn-light border-dark ml-2">Nie</a>
            <span class="btn btn-light border-dark ml-auto" id="cancelBtn">Anuluj</span>
        </div>
    </div>    
@endsection

@section('custom-scripts')
    <script src="{{asset('js/editMap.js')}}"></script>
@endsection